<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class EditCredentialsController extends Controller
{
    public function showChooseMarkerForm()
    { 
        return view('EditCredentials.ChangeMarker');
    }

    public function updateChosenMarker(Request $request)
    {
        $user = auth()->user();
        
        // Validate the chosen_marker field
        $request->validate([
            'chosen_marker' => 'required|in:marker1,marker2',  // Add more options as needed
        ]);

        // Update the chosen_marker for the authenticated user
        $user->update([
            'chosen_marker' => $request->input('chosen_marker'),
        ]);

        return redirect()->route('dashboard')->with('success', 'Chosen marker updated successfully!');
    }
}
