<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\AccidentReport;

class AdminController extends Controller
{
    public function showReports()
    {
        $confirmedReports = AccidentReport::where('location_status', 1)->get();
        $pendingReports = AccidentReport::where('location_status', 0)->get();

        return view('admin.accident_reports', compact('confirmedReports', 'pendingReports'));
    }
    
    public function confirmReport($id)
    {
        $report = AccidentReport::findOrFail($id);
        $report->location_status = 1; // Confirm the report
        $report->save();

        return redirect()->route('admin.accident_reports')->with('success', 'Accident report confirmed successfully.');
    }

    public function deleteReport($id)
    {
        $report = AccidentReport::findOrFail($id);
        $report->delete();

        return redirect()->route('admin.accident_reports')->with('success', 'Accident report deleted successfully.');
    }
    public function revertReportStatus($id)
    {
        $report = AccidentReport::findOrFail($id);
        $report->location_status = 0; // Set the location status back to pending
        $report->save();

        return redirect()->route('admin.accident_reports')->with('success', 'Accident report status reverted to pending successfully.');
    }
    public function manageRoles()
{
    // Fetch users from the database
    $admins = User::where('role', 'admin')->get();
    $users = User::where('role', 'user')->get();

    return view('admin.manage_roles', ['admins' => $admins, 'users' => $users]);
}

public function updateRole(Request $request)
{
    $request->validate([
        'user_id' => 'required|exists:users,id',
        'role' => 'required|in:user,admin', // Add any other roles you may have
    ]);

    $user = User::find($request->user_id);
    $user->update(['role' => $request->role]);

    return redirect()->route('admin.manageRoles')->with('success', 'User role updated successfully.');
}
public function searchUsers(Request $request)
{
    // Fetch all users from the database
    $results = User::where(function ($query) use ($request) {
        $query->where('name', 'like', '%' . $request->input('search') . '%')
              ->orWhere('email', 'like', '%' . $request->input('search') . '%')
              ->orWhere('phone', 'like', '%' . $request->input('search') . '%');
    })
    ->get();

    // Separate users and admins
    $users = $results->where('role', 'user');
    $admins = $results->where('role', 'admin');

    // Pass the data to the view along with the search term
    return view('admin.manage_roles', [
        'users' => $users,
        'admins' => $admins,
        'searchTerm' => $request->input('search')
    ]);

}
public function dashboard()
{
    $users = User::where('role', 'user')->get();
    $confirmedReportsCount = AccidentReport::where('location_status', true)->count();
    $pendingReportsCount = AccidentReport::where('location_status', false)->count();
    $usersCount = User::count();
    $leaderboard = User::withCount('confirmedReports')
        ->orderByDesc('confirmed_reports_count')
        ->limit(10)
        ->get();

    return view('admin.dashboard', compact('confirmedReportsCount', 'pendingReportsCount', 'usersCount', 'leaderboard', 'users'));
}


}