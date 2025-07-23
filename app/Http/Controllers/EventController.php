<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Http\Resources\EventResource;

class EventController extends Controller
{
    public function index()
    {
        return EventResource::collection(
            Event::orderBy('start_at')->get()
        );
    }
}
