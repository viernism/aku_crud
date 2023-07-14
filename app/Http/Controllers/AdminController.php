<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;

class AdminController extends Controller
{
    public function index()
    {
        $users = User::paginate();

        $roles=Role::all();

        return view('pages.admin.admin', compact('users','roles'));
    }


    public function store(Request $request)
    {
        // Validate the form data
        $validatedData = $request->validate([
            'name' => 'required',
            'username' => 'required|unique:users',
            'email' => 'required|email|unique:users',
             'password' => 'required', // add pw validation
        ]);

        // Create a new user in the database
        $user = new User;
        $user->name = $validatedData['name'];
        $user->username = $validatedData['username'];
        $user->email = $validatedData['email'];
        // $user->name = $validatedData['phone'];
        $user->password = bcrypt($validatedData['password']); // Add password hashing
        $role=$request->input('role');
        $user->syncRoles($role);
        $user->save();

        // Redirect the user back to the admin panel with a success message
        return redirect()->back()->with('success', 'User created successfully.');
    }

    public function update(Request $request, $userId)
    {
        if ($request->isMethod('post')) {
            $data=$request->all();
            $user = User::find($userId);
            $user->name = $data['name'];
            $user->username = $data['username'];
            $user->email = $data['email'];
            $role=$request->input('role');
            $user->syncRoles($role);
            // $user->bio=$data['bio'];
            $user->update();
        }

    // Redirect the user back to the admin panel with a success message
        return redirect()->back()->with('success', 'User updated successfully.');
    }

    public function destroy(User $user)
    {
        // Delete the user obviously
        $user->delete();

        // Redirect the user back to the admin panel with a sucess message
        return redirect()->back()->with('success', 'User deleted successfully.');
    } // ok this stupid delete method took me an hour to figure out... well same with the rest...

    public function deleteSelected(Request $request){
        $ids=$request->input('id');
        User::whereIn('id',$ids)->delete();
    }
}
