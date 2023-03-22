<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        $users = User::paginate();

        return view('pages.admin-panel', compact('users'));
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
        $user->save();

        // Redirect the user back to the admin panel with a success message
        return redirect('/admin-panel')->with('success', 'User created successfully.');
    }

    public function update(Request $request, $id)
    {
    $user = User::findOrFail($id);

    // Validate the form data
    $validatedData = $request->validate([
        'name' => 'required',
        'username' => 'required|unique:users,username,'. $user->id,
        'email' => 'required|email|unique:users,email,' . $user->id,
        'password' => 'nullable|min:8',
    ]);

    // Update the user in the database
    $user->name = $validatedData['name'];
    $user->username = $validatedData['username'];
    $user->email = $validatedData['email'];
    if (!empty($validatedData['password'])) {
        $user->password = bcrypt($validatedData['password']);
    }
    $user->save();

    // Redirect the user back to the admin panel with a success message
    return redirect('/admin-panel')->with('success', 'User updated successfully.');
    }

    public function destroy(User $user)
    {
        // Delete the user obviously
        $user->delete();

        // Redirect the user back to the admin panel with a sucess message
        return redirect('/admin-panel')->with('success', 'User deleted successfully.');
    } // ok this stupid delete method took me an hour to figure out... well same with the rest...
}
