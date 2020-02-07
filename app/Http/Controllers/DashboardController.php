<?php
namespace App\Http\Controllers;

use App\BackOffice;
use App\Step;
use App\UserKYC;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = Auth::user();

        try{
            $verify_state = UserKYC::where('user_id', $user->id)->select('verify_state')->first();
            if (is_null($verify_state)) {
                $data['kyc_state'] = trans('kyc.not_verified');
                $data['verify_state'] = REJECTED;
            } else {
                $data['verify_state'] = $verify_state->verify_state;
                if ($verify_state->verify_state == CHECKING)
                    $data['kyc_state'] = trans('kyc.checking');
                else if ($verify_state->verify_state == VERIFIED)
                    $data['kyc_state'] = trans('kyc.verified');
                else if ($verify_state->verify_state == REJECTED)
                    $data['kyc_state'] = trans('kyc.rejected');
            }
        } catch (QueryException $e) {

        }
        $data['wallet'] = $this->decryptData($user->wallet);
        return view('dashboard', $data);
    }

    public function getBalance(Request $request)
    {
        $data = array(
            'purchased' => '0 '.SYMBOL,
            'managing' => '0'.SYMBOL,
            'unlocked' => '0 '.SYMBOL,
            'available' => '0'.SYMBOL,
            'withdrawn' => '0 '.SYMBOL,
        );

        try {
            $data['purchased'] = number_format($this->getPurchasedAmount(),2) . ' ' .SYMBOL;
            $data['managing'] = number_format($this->getManageAmount(),2) . ' ' .SYMBOL;
            $data['unlocked'] = number_format($this->getUnlockedAmount(),2) . ' ' .SYMBOL;
            $data['available'] = number_format($this->getAvailableAmount(),2) . ' ' .SYMBOL;
            $data['withdrawn'] = number_format($this->getWithdrawnAmount(),2) . ' ' .SYMBOL;
        } catch (QueryException $e) {
            echo json_encode($data);
            exit;
        }

        echo json_encode($data);
    }

}