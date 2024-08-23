<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class UserSettingsController extends Controller
{
    public function index()
    {
        return view('EditCredentials.UserSettings');
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();
    
        // Validate the incoming request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Ensure the file is an image
        ]);
    
        // Update the profile image if provided
        if ($request->hasFile('profile_image')) {
            $profileImage = $request->file('profile_image');
            $imageDirectory = public_path('images'); // Specify the directory within the public folder
            $imagePath = $profileImage->move($imageDirectory, uniqid() . '.' . $profileImage->getClientOriginalExtension());
            $user->profile_image = 'images/' . $imagePath->getFilename(); // Assuming you want to store the relative path in the database
        }
    
        // Update other profile fields
        $user->name = $validatedData['name'];
        $user->lastname = $validatedData['lastname'];
        $user->phone = $validatedData['phone'];
    
        // Save the changes
        $user->save();
    
        // Optionally, you can return a response indicating success

        return redirect()->route('settings.index')->with('success', 'Profile updated successfully.');

    }

    public function updatePassword(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'current_password' => 'required|string',
            'new_password' => 'required|string|min:8|confirmed:new_password_confirmation',
        ], [
            'new_password.confirmed' => 'New password and confirmation must match.',
        ]);
    
        if (!Hash::check($request->input('current_password'), $user->password)) {
            return redirect()->route('settings.index')->with('error', 'Current password is incorrect.');
        }
    
        $user->update([
            'password' => bcrypt($request->input('new_password')),
        ]);
    
        return redirect()->route('dashboard')->with('success', 'Password updated successfully.');
    }
}
