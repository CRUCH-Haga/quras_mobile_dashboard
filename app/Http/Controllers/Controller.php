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

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

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

}
