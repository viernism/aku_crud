<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RolePermissionController extends Controller
{
    public function indexrole(){
        // $roles=Role::all()->paginate();
        // $firstItem=$roles->firstItem();
        return view('pages.admin.role',compact('firstItem','roles'));
    }

    public function indexpermission(){
        return view('pages.admin.permission');
    }
}
