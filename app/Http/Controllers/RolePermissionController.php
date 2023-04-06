<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RolePermissionController extends Controller
{
    public function indexrole(Request $request)
    {
        $length = $request->input('length', 10); // default = 10 if not set

        $roles = Role::query();

        // live search method
        if ($request->has('search')) {
            $search = $request->input('search');
            $roles->where(function($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%')
                    ->orWhere('guard_name', 'like', '%' . $search . '%');
                // add more where clauses as needed
            });
        }

        $roles = $roles->paginate($length);


        $guard_names = Role::distinct('guard_name')->pluck('guard_name')->toArray();
        return view('pages.admin.role', compact('roles', 'guard_names'));
    }
}
