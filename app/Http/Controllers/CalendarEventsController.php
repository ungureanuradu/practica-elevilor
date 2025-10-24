<?php

namespace App\Http\Controllers;

use App\Models\CalendarEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class CalendarEventsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Static categories for events
        $categories = [
            ['id' => 1, 'name' => 'Workshop'],
            ['id' => 2, 'name' => 'Conferință'],
            ['id' => 3, 'name' => 'Training'],
            ['id' => 4, 'name' => 'Networking'],
            ['id' => 5, 'name' => 'Prezentare'],
            ['id' => 6, 'name' => 'Demo'],
            ['id' => 7, 'name' => 'Q&A'],
            ['id' => 8, 'name' => 'Altele'],
        ];

        // Static event types (matching database ENUM values)
        $types = [
            'single' => 'Eveniment Unic',
            'recurring' => 'Eveniment Recurent',
            'all-day' => 'Toată Ziua',
        ];

        return Inertia::render('CalendarEvents/Create', [
            'categories' => $categories,
            'types' => $types,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'excerpt' => 'nullable|string|max:500',
            'category_id' => 'required|integer',
            'type' => 'required|in:single,recurring,all-day',
            'location' => 'nullable|string|max:255',
            'url' => 'nullable|url',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'access_level' => 'required|in:public,private,restricted',
            'status' => 'required|in:draft,published,archived',
            'is_featured' => 'boolean',
            'requires_registration' => 'boolean',
            'max_participants' => 'nullable|integer|min:1',
            'application_instructions' => 'nullable|string',
            'reminders' => 'nullable|array',
        ]);

        // Add organizer_id (current user)
        $validated['organizer_id'] = Auth::id();

        // Set default timezone if not provided
        $validated['timezone'] = $validated['timezone'] ?? 'Europe/Bucharest';

        // Create the event
        $event = CalendarEvent::create($validated);

        return redirect()->route('company.dashboard')
            ->with('success', 'Evenimentul a fost creat cu succes!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
