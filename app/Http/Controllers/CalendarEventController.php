<?php

namespace App\Http\Controllers;

use App\Models\CalendarEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CalendarEventController extends Controller
{
    public function store(Request $request)
    {
        if (Auth::user()->role !== 'trainer') {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_time' => 'required|date',
            'end_time' => 'nullable|date|after_or_equal:start_time',
            'type' => 'required|string|in:event,class,deadline',
        ]);

        Auth::user()->calendarEvents()->create($validated);

        return back()->with('success', 'Event created successfully.');
    }

    public function destroy(CalendarEvent $event)
    {
        if (Auth::user()->role !== 'trainer' || Auth::id() !== $event->user_id) {
            abort(403, 'Unauthorized action.');
        }

        $event->delete();

        return back()->with('success', 'Event deleted successfully.');
    }
}
