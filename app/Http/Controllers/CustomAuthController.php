<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\User;
use Session;

class CustomAuthController extends Controller
{
    public function register(){
        return view('auth.register');
    }

    public function login(){
        return view('auth.login');
    }

    public function registerUser(Request $request){
        $request->validate([
            'name'=>'required',
            'username'=>'required',
            'password'=>'required|min:8',
            'email'=>'required|email|unique:users'
        ]);

        $user=new User();
        $user->name=$request->name;
        $user->username=$request->username;
        $user->password=Hash::make($request->password);
        $user->email=$request->email;
        $res=$user->save();

        if ($res) {
            return back()->with('success','You have been registered successfuly');
        } else {
            return back()->back('fail','Unfortunately, you are not registered. Please try again');
        }
    }

    public function loginUser(Request $request){
        $request->validate([
            'email'=>'required|email',
            'password'=>'required|min:8'
        ]);

        $user=User::where('email','=',$request->email)->first();

        if ($user) {
            if (Hash::check($request->password, $user->password)) {
                $request->session()->put('loginId',$user->id);
                return redirect('home');
            } else {
                return back()->with('fail','Password is invalid/not matches');
            }

        }
        else {
            return back()->with('fail','Email is invalid');
        }

    }
}
