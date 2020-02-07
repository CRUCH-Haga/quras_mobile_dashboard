<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/kyc';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }

    public function getVerify($code) {
        try {
            $user = User::where('verify_code', $code)->first();

            if (!empty($user) && $code == $user->verify_code) {

                $user->verify_code = '';
                $user->verify = 1;
                $user->save();

                Auth::loginUsingId($user->id);
                return redirect('/kyc')->with('verify', true);
            }
        } catch (QueryException $e) {
            return redirect('/login')->with('failed', trans('message.mail.verify-failed'));
        }

        return redirect('/login')->with('failed', trans('message.mail.verify-failed'));
    }
}
