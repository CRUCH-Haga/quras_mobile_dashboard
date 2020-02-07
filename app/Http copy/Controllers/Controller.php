<?php

namespace App\Http\Controllers;

use App\BackOffice;
use App\Rate;
use App\Step;
use App\WithdrawalHistory;
use App\WithdrawalReq;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Sha3\Sha3;
use kornrunner\Keccak;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function generateAffiliateCode($id)
    {
        $affiliate_num = str_pad($id, 7, 0, STR_PAD_LEFT);
        $affiliate_code = 'Q' . $affiliate_num;
        $hash = md5($affiliate_code);
        $hash = substr($hash, 0 ,3);
        $affiliate_code = $affiliate_code . $hash;

        return $affiliate_code;
    }

    protected function getCurrentRate()
    {
        $rate = array(
            'btc_qrs' => 0,
            'eth_qrs' => 0,
        );

        $now = date('Y-m-d H:i:s');
        try {
            $rate_info = Rate::where('rate_date', '<=', $now)
                ->select('btc', 'btc_qrs', 'eth', 'eth_qrs')
                ->orderby('rate_date', 'desc')
                ->first();
            if (is_null($rate_info))
                return $rate;

            $rate['btc_qrs'] = $rate_info->btc_qrs / $rate_info->btc;
            $rate['eth_qrs'] = $rate_info->eth_qrs / $rate_info->eth;

        } catch (QueryException $e) {
            return $rate;
        }

        return $rate;
    }

    protected function checkBTCAddress($address){
        $decoded = $this->decodeBase58($address);
        if ($decoded === false)
            return false;

        $d1 = hash("sha256", substr($decoded,0,21), true);
        $d2 = hash("sha256", $d1, true);

        if(substr_compare($decoded, $d2, 21, 4)){
            return false;
        }
        return true;
    }

    function decodeBase58($input) {
        $alphabet = "123456789ABCDEFGHJKLMNPQRSTUVWXYZabcdefghijkmnopqrstuvwxyz";

        $out = array_fill(0, 25, 0);
        for($i=0;$i<strlen($input);$i++){
            if(($p=strpos($alphabet, $input[$i]))===false){
                return false;
            }
            $c = $p;
            for ($j = 25; $j--; ) {
                $c += (int)(58 * $out[$j]);
                $out[$j] = (int)($c % 256);
                $c /= 256;
                $c = (int)$c;
            }
            if($c != 0){
                return false;
            }
        }

        $result = "";
        foreach($out as $val){
            $result .= chr($val);
        }

        return $result;
    }

    public function isETHAddress($address)
    {
        // See: https://github.com/ethereum/web3.js/blob/7935e5f/lib/utils/utils.js#L415
        if ($this->matchesPattern($address)) {
            return $this->isAllSameCaps($address) ?: $this->isValidChecksum($address);
        }

        return false;
    }

    protected function matchesPattern($address)
    {
        return preg_match('/^(0x)?[0-9a-f]{40}$/i', $address);
    }

    protected function isAllSameCaps($address)
    {
        return preg_match('/^(0x)?[0-9a-f]{40}$/', $address) || preg_match('/^(0x)?[0-9A-F]{40}$/', $address);
    }

    protected function isValidChecksum($address)
    {
        $address = str_replace('0x', '', $address);
        $hash = Keccak::hash(strtolower($address), 256);

        // See: https://github.com/web3j/web3j/pull/134/files#diff-db8702981afff54d3de6a913f13b7be4R42
        for ($i = 0; $i < 40; $i++ ) {
            if (ctype_alpha($address{$i})) {
                // Each uppercase letter should correlate with a first bit of 1 in the hash char with the same index,
                // and each lowercase letter with a 0 bit.
                $charInt = intval($hash{$i}, 16);

                if ((ctype_upper($address{$i}) && $charInt <= 7) || (ctype_lower($address{$i}) && $charInt > 7)) {
                    return false;
                }
            }
        }

        return true;
    }

    protected function currFormat($amount, $curr=null)
    {
        if ($curr == BTC)
            $points = 8;
        else if ($curr == ETH)
            $points = 6;
        else
            $points = 0;
        
        if (empty($amount))
            return $amount;
        else
            $amount = number_format($amount, $points, '.', ',');

        return $amount;
    }

    protected function getManageAmount()
    {
        $purchased_amount = $this->getPurchasedAmount();
        $withdrawan_amount = $this->getWithdrawnAmount();

        $managing_amount = $purchased_amount - $withdrawan_amount;

        return $managing_amount;
    }

    protected function getPurchasedAmount()
    {
        $user = auth()->user();
        $purchased = 0;
        try {
            $purchased = BackOffice::where('email', $user->email)->sum('amount');
        } catch (QueryException $e) {
            return $purchased;
        }
        return $purchased;
    }

    protected function getUnlockedAmount()
    {
        $unlocked = 0;
        try {
            $purchased = $this->getPurchasedAmount();

            $step_list = Step::get()->toArray();
            $count = count($step_list);

            $today = date('Y-m-d');
            $step_info = Step::where([['from_date', '<=', $today], ['to_date', '>=', $today]])->first();
            if (is_null($step_info))
                $step = 0;
            else
                $step = $step_info->step;

            $unlocked = ($purchased / $count) * $step;
        } catch (QueryException $e) {
            return $unlocked;
        }
        return $unlocked;
    }

    protected function getWithdrawnAmount()
    {
        $withdrawn = 0;
        try {
            $user = auth()->user();
            $withdrawn = WithdrawalHistory::where('user_id', '=', $user->id)->sum('amount');
        } catch (QueryException $e) {
            return $withdrawn;
        }
        return $withdrawn;
    }

    protected function getAvailableAmount()
    {
        $user = auth()->user();
        $amount = 0;
        try{
            $purchased = $this->getUnlockedAmount();
            $req_amount = WithdrawalReq::where([['user_id', '=', $user->id ], ['verify_state', '=', WITHDRAWAL_VERIFIED]])->sum('amount');
            $withdrawn_amount = $this->getWithdrawnAmount();
            $amount = $purchased - $req_amount - $withdrawn_amount;
        } catch (QueryException $e) {
            return $amount;
        }
        return $amount;
    }

    protected function encryptData($data)
    {
        $privKey = openssl_pkey_get_private('file://'.PRIVATE_KEY);
        $encryptedData = "";
        openssl_private_encrypt($data, $encryptedData, $privKey);
        $encryptedData = base64_encode($encryptedData);
        return $encryptedData;
    }

    protected function decryptData($data)
    {
        $data = base64_decode($data);
        $pubKey = openssl_pkey_get_public('file://'.PUBLIC_KEY);
        $decryptedData = "";
        openssl_public_decrypt($data, $decryptedData, $pubKey);
        return $decryptedData;
    }
}
