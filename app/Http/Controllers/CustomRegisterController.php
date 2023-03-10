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

    public function registerUser(RegisterRequest $request){
        $attributes=$request->all();
        $attributes['password']=Hash::make($request->password);
        User::create($attributes);

        return redirect('/home');
        // $user=new User();
        // $user->name=$request->name;
        // $user->username=$request->username;
        // $user->password=Hash::make($request->password);
        // $user->email=$request->email;
        // $res=$user->save();

        // if ($res) {
        //     return redirect('login');
        // } else {
        //     return back()->back('fail','Unfortunately, you are not registered. Please try again');
        // }
    }




}
