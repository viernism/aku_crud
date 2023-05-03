<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\RegisterRequest;
use Illuminate\Http\Request;
use App\Models\User;
use Session;


class CustomRegisterController extends Controller
{

    public function register(){
        return view('auth.register');
    }

    public function registerUser(Request $request){
        $attributes=$request->all();
        $attributes['password']=Hash::make($request->password);
        $user=User::create($attributes);
        $user->assignRole('AM');

        return redirect('/home');
    }
}
