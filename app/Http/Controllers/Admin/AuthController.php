<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class AuthController extends Controller{
    use AuthenticatesUsers;
    
    protected $maxAttempts = 3;
    protected $decayMinutes = 2;

    public function showFormLogin(){
        if(Auth::check()){
            return redirect()->route('admin.dashboard');
        }
        return view('admin.login');
    }

    public function login(LoginRequest $request){
        $data = [
            'email'     => $request->input('email'),
            'password'  => $request->input('password'),
        ];
        Auth::attempt($data);
        if(Auth::check()){
            $this->clearLoginAttempts($request);
            return redirect()->route('admin.dashboard');
        }
        else{
            $this->incrementLoginAttempts($request);
            return  redirect()->back()->with('error','Email atau Password Salah');
        }
    }

    public function logout(){
        Auth::logout();
        return redirect()->route('admin.login');
    }
}
