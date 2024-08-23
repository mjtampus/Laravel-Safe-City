<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Announcement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use App\Notifications\AnnouncementNotification;

class AnnouncementController extends Controller
{
    public function create()
    {
        return view('admin.createAnnouncement');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'message' => 'required'
           
        ]);

        $announcement = Announcement::create([
            'title' => $request->input('title'),
            'message' => $request->input('message'),
        ]);

        Notification::send(\App\Models\User::all(), new AnnouncementNotification($announcement->message));

        return redirect()->route('announcements.create')->with('success', 'Announcement created successfully!');
    }
    public function index()
    {
        $announcements = Announcement::latest()->get();
        return view('admin.index', compact('announcements'));
    }
}
