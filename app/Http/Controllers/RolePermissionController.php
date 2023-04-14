<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionController extends Controller
{
    public function index(Request $request)
    {
        //role things
        $length = $request->input('length', 10); // default = 10 if not set
        $roles = Role::query();
        $roles = $roles->paginate($length);

        //permission things
        $length = $request->input('length', 10); // default = 10 if not set
        $permissions = Permission::query();
        $permissions = $permissions->paginate($length);

        return view('pages.admin.rolepermission', compact('roles', 'permissions'));
    }

    public function store(Request $request){
        $validatedData=$request->validate([
            'name' => 'required|string|unique:roles,name',
            'guard_name' => 'required|string',
        ]);

        $role=Role::create([
            'name'=>$validatedData['name'],
            'guard_name'=>$validatedData['guard_name']
        ]);

        $permission=$request->input('permission');
        $role->syncPermissions($permission);

        return redirect()->back();
    }

    public function storeP(Request $request){
        $validatedData=$request->validate([
            'name' => 'required|string|unique:permissions,name',
            'guard_name' => 'required|string',
        ]);

        Permission::create([
            'name'=>$validatedData['name'],
            'guard_name'=>$validatedData['guard_name']
        ]);

        return redirect()->back();
    }

    public function update(Request $request, $roleId){

        if ($request->isMethod('post')) {
            $data=$request->all();
            $role = Role::find($roleId);
            $role ->name = $data['name'];
            $permission=$request->input('permission');
            $role->syncPermissions($permission);
            $role ->update();
            return redirect()->back()->with('success', 'Role updated successfully.');
        }
    }

    public function destroy ($roleId)
    {
        $role = Role::find($roleId);
        if (!$role) {
            return redirect()->back()->with('error', 'Role not found.');
        }

        $role->delete();

        return redirect()->back()->with('success', 'Role deleted successfully.');
    }

    public function deleteSelected(Request $request)
    {
        $ids = $request->input('id');
        Role::whereIn('id', $ids)->delete();
    }
}
