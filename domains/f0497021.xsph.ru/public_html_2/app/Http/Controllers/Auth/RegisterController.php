<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\RegistrationApplication;
use App\Rules\Fio;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class RegisterController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Show the application registration form.
     *
     * @return Application|Factory|View|\Illuminate\View\View
     */
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    /**
     * Handle a registration request for the application.
     *
     * @param Request $request
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function register(Request $request): RedirectResponse
    {
        $this->validator($request->all())->validate();

        // TODO: убрать confirm, когда будет готово подверждение регистрации
        $this->create($request->all())->confirm();

        return redirect()->route('login');
    }


    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data): \Illuminate\Contracts\Validation\Validator
    {
        return Validator::make($data, [
            'fio' => ['required', 'string', 'max:255', new Fio],
            'group' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return RegistrationApplication
     */
    protected function create(array $data): RegistrationApplication
    {
        $application = RegistrationApplication::make([
            'email' => $data['email'],
            'group' => $data['group'],
            'password' => Hash::make($data['password']),
        ]);

        // TODO: проверить работу мутатора
        $application->fio = $data['fio'];
        $application->save();

        return $application;
    }
}
