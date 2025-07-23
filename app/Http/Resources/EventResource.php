<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EventResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'          => $this->id,
            'title'       => $this->title,
            'description' => $this->description,
            'start'       => $this->start_at->toIso8601String(),   // FullCalendar expects “start”
            'end'         => optional($this->end_at)->toIso8601String(),
            'location'    => $this->location,
        ];
    }
    
}
