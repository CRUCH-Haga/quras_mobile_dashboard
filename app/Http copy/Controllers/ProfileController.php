<?php
/**
 * Created by PhpStorm.
 * User: James
 * Date: 11/14/2019
 * Time: 11:42 PM
 */

namespace App\Http\Controllers;


use App\UserKYC;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = Auth::user();

        $data['email'] = $user->email;
        $data['name'] = $user->name;
        $data['birthday'] = $user->birthday;
        $data['phone'] = $user->phone;
        $data['kyc_state'] = CHECKING;

        try {
            $kyc_info = UserKYC::where('user_id', $user->id)->first();
            if (isset($kyc_info) && $kyc_info->verify_state == VERIFIED)
                $data['kyc_state'] = VERIFIED;
        } catch (QueryException $e) {
        }

        return view('profile', $data);
    }

    public function update(Request $request)
    {
        $data = $request->all();

        try {
            $user = Auth::user();

            $kyc_info = UserKYC::where('user_id', $user->id)->first();
            if (isset($kyc_info) && $kyc_info->verify_state == VERIFIED)
                return redirect()->back()->withInput()->with(['profile_failed' => trans('message.profile.verified')]);

            $validator = Validator::make($data, [
                'name' => 'required|max:255|regex:/(^([a-zA-Z\s]+)?$)/u',
                'birthday' => 'required|date',
                'phone' => 'required|numeric',
            ]);

            if ($validator->fails()) {
                $errors = $validator->errors();
                return redirect()->back()->withInput()->withErrors($errors);
            }

            $user->name = $data['name'];
            $user->birthday = $data['birthday'];
            $user->phone = $data['phone'];

            $user->save();

        } catch (QueryException $e) {
            return redirect()->back()->withInput()->with(['profile_failed' => trans('message.profile.failed')]);
        }

        return redirect()->route('profile')->with('profile_success', trans('message.profile.success'));;
    }

    public function updatePassword(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'current_password' => 'required|min:6',
            'new_password' => 'required|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            return redirect()->back()->withInput()->withErrors($errors);
        }

        $user = Auth::user();
        if (!Hash::check($data['current_password'], $user->password))
            return redirect()->back()->withInput()->with(['password_failed' => trans('message.profile.no_current_password')]);

        try {
            $user->password = bcrypt($data['new_password']);
            $user->save();
        } catch (QueryException $e) {
            return redirect()->back()->withInput()->with(['password_failed' => trans('message.profile.password_failed')]);
        }

        return redirect()->back()->withInput()->with(['password_success' => trans('message.profile.password_success')]);
    }
}