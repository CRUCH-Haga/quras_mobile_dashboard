<?php
/**
 * Created by PhpStorm.
 * User: James
 * Date: 8/3/2018
 * Time: 3:01 AM
 */

namespace App\Http\Controllers;


use App\BonusAddress;
use App\UserKYC;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class KYCController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $user = Auth::user();

        $data['email'] = $user->email;

        try {
            $kyc_info = UserKYC::where('user_id', $user->id)->first();

            if ($kyc_info === null) {
                $data['kyc_state'] = trans('kyc.not_verified');
                $data['reject_cause'] = '';
                $data['verify_state'] = REJECTED;
            } else {
                $data['verify_state'] = $kyc_info->verify_state;
                $data['reject_cause'] = $kyc_info->reject_cause;

                if ($kyc_info->verify_state == CHECKING)
                    $data['kyc_state'] = trans('kyc.checking');
                else if ($kyc_info->verify_state == VERIFIED)
                    $data['kyc_state'] = trans('kyc.verified');
                else if ($kyc_info->verify_state == REJECTED)
                    $data['kyc_state'] = trans('kyc.rejected');
            }
        } catch (QueryException $e) {
            $data['kyc_state'] = trans('kyc.not_verified');
        }

        return view('kycverification', $data);
    }

    public function getKYCState(Request $request)
    {
        $user = Auth::user();

        try {
            $kyc_info = UserKYC::where('user_id', $user->id)->first();

            if ($kyc_info === null) {
                $data['kyc_state'] = trans('message.kyc.no_info');
                $data['verify_state'] = REJECTED;
            } else {
                if ($kyc_info->verify_state == CHECKING) {
                    $data['kyc_state'] = trans('message.kyc.checking');
                    $data['verify_state'] = CHECKING;
                } else if ($kyc_info->verify_state == VERIFIED)
                    $data['verify_state'] = VERIFIED;
                else if ($kyc_info->verify_state == REJECTED) {
                    $data['kyc_state'] = trans('message.kyc.rejected');
                    $data['verify_state'] = REJECTED;
                }
            }
        } catch (QueryException $e) {
            $data['kyc_state'] = trans('message.kyc.no_info');
            $data['verify_state'] = REJECTED;
        }

        echo json_encode($data);
    }

    public function registerKYC(Request $request)
    {
        $user = Auth::user();

        $data = $request->all();

        if (!isset($data['verify_state']))
            return redirect()->back()->withInput()->withErrors(['failed' => trans('message.kyc.register_failed')]);

        if ($data['verify_state'] == REJECTED) {
            $validator = Validator::make($data, [
                'passport' => 'required|mimes:jpeg,jpg,png,pdf',
                'selfie' => 'required|mimes:jpeg,jpg,png,pdf',
            ]);

            if ($validator->fails()) {
                $errors = $validator->errors();
                return redirect()->back()->withInput()->withErrors($errors);
            }

            $passport = $data['passport'];
            $selfie = $data['selfie'];

            $passport_url = KYC_PHOTO_URL . $user->email . '/';
            $passport_file = 'Passport.' . substr(strrchr($passport->getClientOriginalName(), "."), 1);

            $selfie_url = KYC_PHOTO_URL . $user->email . '/';
            $selfie_file = 'Selfie.' . substr(strrchr($selfie->getClientOriginalName(), "."), 1);

            if (!$passport->move($passport_url, $passport_file))
                return redirect()->back()->withInput()->withErrors(['passport' => trans('message.kyc.upload_failed')]);

            if (!$selfie->move($selfie_url, $selfie_file))
                return redirect()->back()->withInput()->withErrors(['selfie' => trans('message.kyc.upload_failed')]);

            try {
                $kyc_info = UserKYC::where('user_id', $user->id)->first();

                if (is_null($kyc_info)) {
                    $kyc_info = UserKYC::create([
                        'user_id' => $user->id,
                        'passport' => $passport_file,
                        'selfie' => $selfie_file,
                    ]);
                } else {
                    $kyc_info->passport = $passport_file;
                    $kyc_info->selfie = $selfie_file;
                    $kyc_info->verify_state = CHECKING;
                    $kyc_info->save();
                }

                if ($kyc_info === null)
                    return redirect()->back()->withInput()->with(['failed' => trans('message.kyc.register_failed')]);
            } catch (QueryException $e) {
                return redirect()->back()->withInput()->with(['failed' => trans('message.kyc.register_failed')]);
            }

            return redirect()->route('kyc')->with('success', trans('message.kyc.register_succeed'));;
        }

        return redirect()->route('kyc');
    }
}