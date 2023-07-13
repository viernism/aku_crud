<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\ValidationException;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use App\Models\User;
use Session;

class CustomLoginController extends Controller
{

    public function login(){
        return view('auth.login');
    }

    public function loginUser(LoginRequest $request)
    {
        $user=$request->only(['email','password']);

        if (Auth::attempt($user)) {
            return redirect('/')->with('success','You are logged in successfuly');
        }

        throw ValidationException::withMessages([
            'email'=>'This email is not registered or not valid',
            'password'=>'Your password is invalid'
        ]);
    }
}
