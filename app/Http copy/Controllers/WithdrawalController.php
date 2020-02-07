<?php
/**
 * Created by PhpStorm.
 * User: James
 * Date: 9/9/2019
 * Time: 1:46 AM
 */

namespace App\Http\Controllers;


use App\UserKYC;
use App\WithdrawalHistory;
use App\WithdrawalReq;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class WithdrawalController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $available_amount = $this->getAvailableAmount();
        $data['available_amount'] = number_format($available_amount, 2) . ' ' . SYMBOL;
        $data['ba_amount'] = $available_amount/10;
        $data['bonus_available_amount'] = number_format($data['ba_amount'], 2) . ' ' . SYMBOL;

        $user = Auth::user();
        $req_list = array();
        try{
            $req_list = WithdrawalReq::where('verify_state', WITHDRAWAL_VERIFIED)->where('user_id', $user->id)->get()->toArray();
        } catch (QueryException $e) {
        }

        for($i = 0; $i < count($req_list); $i++)
            $req_list[$i]['wallet'] = $this->decryptData($req_list[$i]['wallet']);

        $data['req_list'] = $req_list;
        $data['wallet'] = $this->decryptData($user->wallet);
        return view('withdrawal', $data);
    }

    public function withdrawalReq(Request $request)
    {
        $available_amount = $this->getAvailableAmount();
        $data = $request->all();

        $validator = Validator::make($data, [
            'wallet' => 'required',
            'amount' => 'required|numeric|max:'.$available_amount,
        ]);

        if (!$this->isETHAddress($data['wallet']))
            $validator->getMessageBag()->add('wallet', trans('validation.eth_wallet'));

        $errors = $validator->errors();
        if (!$errors->isEmpty())
            return redirect()->back()->withInput()->withErrors($errors);

        try {
            $user = Auth::user();

            $kyc_info = UserKYC::where('user_id', $user->id)->first();
            if ($kyc_info === null) {
                return redirect()->back()->withInput()->with('failed', trans('message.kyc.no_verified'));
            } else {
                if ($kyc_info->verify_state != VERIFIED)
                    return redirect()->back()->withInput()->with('failed', trans('message.kyc.no_verified'));
            }
            $amount = $data['amount'];
            $org_wallet = $data['wallet'];
            $wallet = $this->encryptData($org_wallet);

            $date = date("Y-m-d h:i:sa");
            $verify_code = md5($user->email . $amount . $date);
            $res = WithdrawalReq::insert([
                'user_id' => $user->id,
                'wallet' => $wallet,
                'amount' => $amount,
                'verify_code' => $verify_code,
            ]);

            if ($res === null)
                return redirect()->back()->withInput()->with('failed', trans('message.withdrawal.failed'));

            //Verify URL
            $url = url('withdrawal/confirm/' . $verify_code);

            $mailData = [
                'email' => $user->email,
                'url' => $url,
                'erc_wallet' => $org_wallet,
                'amount' => number_format($amount, 8, '.', ',') . ' ' . SYMBOL,
            ];

            Session::put('mail_data', $mailData);
            Session::put('mail', $user->email);

            $locale = app()->getLocale();

            Mail::send('emails.'.$locale.'.withdrawalmail', $mailData, function($message) use ($user)
            {
                $message->to($user->email)->subject(trans('message.mail.withdrawal_confirm'));
            });

            $data = array();

            $data['email'] = $user -> email;
            $data['wallet'] = $org_wallet;
            $data['amount'] = number_format($amount, 8, '.', ',') . ' ' . SYMBOL;

            return view('withdrawalconfirm', $data);
        } catch (QueryException $e) {
            return redirect()->back()->withInput()->with('failed', trans('message.withdrawal.failed'));
        }
    }

    public function getConfirm($code)
    {
        try {
            $withdrawal_info = WithdrawalReq::where('verify_code', $code)->first();

            if (!empty($withdrawal_info) && $code == $withdrawal_info->verify_code) {

                $withdrawal_info->verify_code = '';
                $withdrawal_info->verify_state = WITHDRAWAL_VERIFIED;
                $withdrawal_info->save();

                return redirect('/withdrawal')->with('success', trans('message.withdrawal.success'));
            }
        } catch (QueryException $e) {
            return redirect()->back()->withInput()->with('failed', trans('message.withdrawal.failed'));
        }

        return redirect()->back()->withInput()->with('failed', trans('message.withdrawal.failed'));
    }

    public function history()
    {
        $history = array();
        try {
            $user = Auth::user();
            $history = WithdrawalHistory::where('user_id', $user->id)->orderby('tx_datetime', 'desc')->get()->toArray();
        } catch (QueryException $e) {
        }

        for ($i = 0; $i < count($history); $i++) {
            $history[$i]['wallet'] = $this->decryptData($history[$i]['wallet']);
            $history[$i]['tx_id'] = $this->decryptData($history[$i]['tx_id']);
        }

        $data['history_list'] = $history;
        return view('withdrawalhistory', $data);
    }
}