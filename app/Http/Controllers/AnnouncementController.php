<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Announcement;

class AnnouncementController extends Controller
{
    public function store(Request $request)
    {
        $user = Auth::user();
        if (!$user || $user->role !== 'trainer') {
            return back()->with('error', 'Only trainers can post announcements.');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        Announcement::create([
            'user_id' => $user->id,
            'title' => $request->title,
            'message' => $request->message,
        ]);

        return back()->with('success', 'Announcement posted successfully.');
    }
}
