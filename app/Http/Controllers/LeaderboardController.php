<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class LeaderboardController extends Controller
{
    public function index()
    {
        // Fetch users with the count of confirmed reports, ordered by the count in descending order
        $leaderboard = User::withCount('confirmedReports')
            ->orderByDesc('confirmed_reports_count')
            ->limit(5)
            ->get();

        return view('leaderboard.index', compact('leaderboard'));
    }
}
