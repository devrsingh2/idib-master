<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\GeneralHelper;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use PHPUnit\Exception;

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
    protected $redirectTo = RouteServiceProvider::HOME;

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
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showRegistrationForm() {
        return view('website.auth.register');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator($request)
    {
        return $request->validate([
            'name' => 'required|string',
            'email' => 'required|email:rfc|string|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function postRegister(Request $request)
    {
        if($request->terms){
            $request->merge(['terms' => 'on']);
        }else{
            $request->merge(['terms' => '']);
        }

//        $this->validator($request->all())->validate();
        $validator = $this->validator($request);
        try {
            $username = explode('@', $request->email)[0];
            $user = new User();
            $user->name = $request->name;
            $user->username = $username;
            $user->email = $request->email;
//        $user->phone = $request->phone;
            $user->email_verified = '1';
            $user->account_status = true;
            $user->isAdmin = false;
            $user->user_type = '2';
            $user->activation_code = GeneralHelper::generateReferenceNumber();
            $user->password = Hash::make($request->password);
            $user->save();

//        request()->session()->flash('alert-class', 'alert-success');
//        request()->session()->flash('message', 'Your registration done successfully, We sent activation code. Please check your mail');
            toastr()->success('You account created successfully!');
            return redirect()->route('login');
        }
        catch (Exception $e) {
            toastr()->error('An error has occurred please try again later.');
            return redirect()->route('register');
        }
    }
    /*protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }*/
}
