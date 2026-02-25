<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\ClassAnnouncement;
use App\Models\ClassComment;

class ClassAnnouncementController extends Controller
{
    public function store(Request $request, Course $course)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
        ]);
        $ann = ClassAnnouncement::create([
            'course_id' => $course->id,
            'user_id' => auth()->id(),
            'title' => $data['title'],
            'body' => $data['body'],
        ]);
        return redirect()->route('trainee.courses.show', $course)->with('success', 'Announcement posted.');
    }

    public function comment(Request $request, ClassAnnouncement $announcement)
    {
        $data = $request->validate([
            'body' => 'required|string',
        ]);
        ClassComment::create([
            'class_announcement_id' => $announcement->id,
            'user_id' => auth()->id(),
            'body' => $data['body'],
        ]);
        return back()->with('success', 'Comment added.');
    }
}
