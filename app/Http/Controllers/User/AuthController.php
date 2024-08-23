<?php

namespace App\Http\Controllers\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{
   
    
    public function login(Request $request)
    {
        // Validate the login form data
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        // Attempt to log the user in
        if (Auth::attempt($request->only('email', 'password'))) {
            // Check the user's role
            if (auth()->user()->isAdmin()) {
                // Redirect to admin dashboard
                return redirect()->route('admin.dashboard');
            } else {
                // Check if the user is restricted
                if (auth()->user()->isRestricted()) {
                    // Redirect to restricted user dashboard or another page
                    return redirect()->route('restricted.dashboard');
                } else {
                    // Redirect to regular user dashboard
                    return redirect()->route('dashboard');
                }
            }
        }
    
        // Redirect back if login fails
        return back()->with('error', 'Invalid login credentials');
    }

public function showLoginForm()
    {
        return view('login');
    }
}
