<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

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
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'nif' => 'required|string|max:9',
            'telephone' => 'required|integer|max:1000000000',
            'year' => 'required|integer|max:3000',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $user = User::create([
            'name' => $data['name'],
            'nif' => $data['nif'],
            'telephone' => $data['telephone'],
            'year' => $data['year'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            "email_code" => str_random(75),
            "verified" => false,
        ]);

        $user->sendVerifyEmail();

        return $user;
    }

    public function register() {
        /*
         * TODO once registered DO NOT log in the user
         * show page asking to confirm email before log in
         */
    }

    public function verifyEmail(Request $request, $token) {
        User::where("email_code", $token)->firstOrFail()->verify();

        return redirect(route("login"));
    }
}
