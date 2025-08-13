<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Http\Resources\EventResource;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

class EventController extends Controller
{
    /**
     * GET /api/events - listă evenimente pentru API
     */
    public function index()
    {
        return EventResource::collection(
            Event::with('user')  // ← ADĂUGAT: încarcă relația user
                ->orderBy('start_at')
                ->get()
        );
    }

    /**
     * GET /events/{event} - pagina pentru eveniment individual
     */
    public function show(Event $event)
    {
        $event->load('user');  // Încarcă relația user
        
        return Inertia::render('EventShow', [
            'event' => new EventResource($event),
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
        ]);
    }
}