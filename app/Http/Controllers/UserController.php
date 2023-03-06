<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function index()
     {
        $users = User::Paginate(5);

        return view('pages.admin-panel', compact('users'));
    }
}
