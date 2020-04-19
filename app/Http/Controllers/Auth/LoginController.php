<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Auth;
use Redirect;
use Session;
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
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request) {
        $this->validate($request,[
            '_username'=>'required',
            '_password'=>'required'
        ],[
            '_username.required'=>'أدخل اسم المستخدم',
            '_password.required'=>'أدخل كلمة المرور'
        ]);
        
        $username=$request['_username'];
       
            if(Auth::attempt(['username'=>$username,'password'=>$request['_password']])){
                return Redirect::to('dashboard');
            }
            else {
                Session::flash('error','اسم المستخدم غير صحيح او كلمة المرور غير صحيحة او كليهما');
                return Redirect::back();
            }
        }
    

    public function logout() {
        Auth::logout();
        return Redirect::to('/');
    }
}
