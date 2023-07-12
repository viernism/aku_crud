<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\EditProfileRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class UserProfileController extends Controller
{
    public function index() {
        $user = Auth::user();
        return view('pages.user-profile', compact('user'));
    }

    public function updateProfileImage(Request $request) {
        $user = Auth::user();

        if ($request->hasFile('photo')) {
            $file = $request->file('photo');

            // validate the uploaded file
            $validatedData = $request->validate([
                'photo' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            ]);

            // store the file and get the file path
            $path = $file->store('profile_images', 'public');
            $path = str_replace('public/', '', $path);
            $path = '/storage/' . $path;

            // update the user's profile image
            $user->photo = $path;
            $user->save();

            return redirect()->back()->with('success', 'Profile image updated successfully!');
        } else {
            return redirect()->back()->with('error', 'No image file was uploaded!');
        }
    }

    public function EditProfile(EditProfileRequest $request){
        $user=$request->only(['email','name','username','phone','bio']);
        // auth()->user()->update($user);
        Auth::user()->update($user);
        return redirect()->back();
    }
}


