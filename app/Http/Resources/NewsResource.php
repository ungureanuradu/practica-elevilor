<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class NewsResource extends JsonResource
{
    /** @return array<string, mixed> */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'excerpt' => $this->excerpt,
            'body' => $this->body,
            // Folosește published_at dacă există, altfel created_at
            'published_at' => $this->published_at ? 
                Carbon::parse($this->published_at)->format('d.m.Y') : 
                Carbon::parse($this->created_at)->format('d.m.Y'),
            'created_at' => Carbon::parse($this->created_at)->format('d.m.Y'),
            // Include autorul din relația cu User
            'author' => $this->whenLoaded('user', function() {
                return $this->user->name;
            }, 'Administrator'),
            // Include și informații despre user dacă e încărcat
            'user' => $this->whenLoaded('user', [
                'id' => $this->user->id ?? null,
                'name' => $this->user->name ?? 'Administrator',
                'email' => $this->user->email ?? null,
            ]),
        ];
    }
}