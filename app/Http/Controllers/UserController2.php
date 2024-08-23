<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController2 extends Controller
{

    public function showRegistrationForm()
    {
        return view('register');
    }

    public function register(Request $request)
{
    // Define custom messages for specific validation rules
    $customMessages = [
        'phone.numeric' => 'Please enter a valid phone number.',
        'phone.unique' => 'The phone number is already taken.',
        'phone.min' => 'The phone must be at least 11 numbers.',
        'password.regex' => 'The password must contain at least one special character (@, #, &, $, *, /, ?).',
    ];

    // Validate the form data
    $request->validate([
        'name' => 'required|string',
        'age' => 'required|integer',
        'lastname' => 'required|string',
        'gender' => 'required|string',
        'birthdate' => 'required|date',
        'phone' => 'required|string|unique:users|min:12|numeric',
        'email' => 'required|email|unique:users',
        'password' => [
            'required',
            'string',
            'min:8',
            'confirmed',
            'regex:/[@#&$*\/?]/', // Special characters
            'regex:/[a-z]/', // Lowercase letter
            'regex:/[A-Z]/', // Uppercase letter
            function ($attribute, $value, $fail) {
                if (!preg_match('/[a-z]/', $value) || !preg_match('/[A-Z]/', $value)) {
                    $fail('The password must contain at least one uppercase and one lowercase letter.');
                }
            },
        ],
    ], $customMessages);


        // Create a new user
        $user = new User($request->all());
        $user->password = hash::make($request->password);
        $user->save();

        // Redirect to login page
        return redirect()->route('login')->with('success', 'Registration successful. You can now log in.');
    
    }
    public function showDashboard()
    {
        $user = Auth::user();
        $chosenMarker = $user->chosen_marker;
    
        // Pass both the user and chosenMarker data to the view
        return view('testmap', ['user' => $user, 'chosenMarker' => $chosenMarker]);
    }
    public function showAdminDashboard()
    {
        $user = Auth::user();

        // Pass the user data to the view
        return view('admin.dashboard', ['user' => $user]);
    }

    Public function showRestrictedDashboard()
    {
        $user = Auth::user();

        // Pass the user data to the view
        return view('admin.dashboard', ['user' => $user]);
    }



    public function logout()
{
    $error = session('error');

    // Handle the error as needed

    Auth::logout();

    return redirect('/login')->with([
        'success' => 'Logout successful.',
        'error' => $error,
    ]);
}
    public function showForm()
    {
        $user = Auth::user();
        return view('report-form', ['user' => $user]);
    } 

    public function editCredentials(Request $request)
    {
        // Validate the form data
        $request->validate([
            'editEmail' => 'required|email',
            'editPhone' => 'required|string',
        ]);

        // Get the currently authenticated user
        $user = Auth::user();

        // Update the user's email and phone number
        $user->email = $request->input('editEmail');
        $user->phone = $request->input('editPhone');
        $user->save();

        // Redirect back to the dashboard with a success message
        return redirect()->route('dashboard')->with('success', 'Credentials updated successfully');
    }
    public function saveCustomMarker(Request $request)
{
    $user = auth()->user();
    $user->update(['chosen_marker' => $request->input('chosen_marker')]);

    return redirect()->route('dashboard')->with('success', 'MarkerUpdatedSuccessFully');
}

public function getChosenMarker(Request $request)
    {
        $user = $request->user(); // Retrieve the authenticated user
        $chosenMarker = $user->chosen_marker; // Assuming 'chosen_marker' is the field in your database

        return response()->json($chosenMarker);
    }

}
