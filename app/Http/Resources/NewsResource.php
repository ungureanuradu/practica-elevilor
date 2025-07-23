<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NewsResource extends JsonResource
{
    /** @return array<string, mixed> */
    public function toArray(Request $request): array
    {
        return [
            'id'           => $this->id,
            'title'        => $this->title,
            'excerpt'      => $this->excerpt,
            'body'         => $this->body,
            'published_at' => optional($this->published_at)->toDateString(),
        ];
    }
}
