<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\RegistrationApplication;
use Illuminate\Support\Facades\Auth;

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
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request){
        $credentials = $request->only('email', 'password');
        $this->validator($credentials)->validate();
        

        $unconfirmedUser = RegistrationApplication::where('email', '=', $credentials['email'])
            ->where('confirmed_at', '=', null)
            ->first();

        if($unconfirmedUser)
            return redirect()->back()->withErrors(['msg' => 'Данный аккаунт не подтвержден'])->withInput();

        if (Auth::attempt(['email' => $credentials['email'], 'password' => $credentials['password']])) {
            return redirect()->route('home');
        } else {
            return redirect()->back()->withErrors(['msg' => 'Неверный логин или пароль'])->withInput();
        }
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string', 'min:6'],
        ]);
    }
}
