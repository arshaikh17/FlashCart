<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use App\User_details;

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
    protected $redirectTo = '/user/home';

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
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password'],
            'username' => $data['username'],
        ]);
    }

    public function check_user_username(Request $request)
    {
        $username = $request->username;
        $username = trim(preg_replace('/ +/', ' ', preg_replace('/[^A-Za-z0-9 ]/', ' ', urldecode(html_entity_decode(strip_tags($username))))));
        if($username != "")
        {
            $user = User::where('username', 'like', $username)->first();
            if($user)
            {
                return['error'=>'yes'];
            }
            else
            {
                return ['error'=>'no'];
            }
        }
        else
        {
            return ['error'=>'Please Enter Username'];
        }
    }

    public function check_user_email(Request $request)
    {
        $email = $request->email;
        $email = trim(preg_replace('/ +/', ' ', preg_replace('/[^A-Za-z0-9._@]/', ' ', urldecode(html_entity_decode(strip_tags($email))))));
        if($email != "")
        {
            $user = User::where('email', 'like', $email)->first();
            if($user)
            {
                return['error'=>'yes'];
            }
            else
            {
                return ['error'=>'no'];
            }
        }
        else
        {
            return ['error'=>'Please Enter Email'];
        }
    }
}
