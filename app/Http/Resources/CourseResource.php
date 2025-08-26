<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CourseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'excerpt' => $this->excerpt,
            'slug' => $this->slug,
            'thumbnail' => $this->thumbnail ? asset('storage/' . $this->thumbnail) : null,
            'level' => $this->level,
            'status' => $this->status,
            'duration_hours' => $this->duration_hours,
            'max_students' => $this->max_students,
            'price' => $this->price,
            'is_free' => $this->is_free,
            'formatted_price' => $this->formatted_price,
            'tags' => $this->tags,
            'requirements' => $this->requirements,
            'learning_outcomes' => $this->learning_outcomes,
            'total_modules' => $this->total_modules,
            'total_duration' => $this->total_duration,
            'published_at' => $this->published_at?->toISOString(),
            'created_at' => $this->created_at->toISOString(),
            'updated_at' => $this->updated_at->toISOString(),
            
            // Relationships
            'instructor' => [
                'id' => $this->instructor->id,
                'name' => $this->instructor->name,
                'display_name' => $this->instructor->display_name,
                'profile_photo_url' => $this->instructor->profile_photo_url,
                'role_label' => $this->instructor->role_label,
            ],
            
            'chapters' => $this->whenLoaded('chapters', function () {
                return $this->chapters->map(function ($chapter) {
                    return [
                        'id' => $chapter->id,
                        'title' => $chapter->title,
                        'description' => $chapter->description,
                        'order' => $chapter->order,
                        'is_published' => $chapter->is_published,
                        'module_count' => $chapter->module_count,
                        'total_duration' => $chapter->total_duration,
                        'modules' => $chapter->whenLoaded('modules', function () use ($chapter) {
                            return $chapter->modules->map(function ($module) {
                                return [
                                    'id' => $module->id,
                                    'title' => $module->title,
                                    'type' => $module->type,
                                    'duration_minutes' => $module->duration_minutes,
                                    'formatted_duration' => $module->formatted_duration,
                                    'order' => $module->order,
                                    'is_published' => $module->is_published,
                                ];
                            });
                        }),
                    ];
                });
            }),
        ];
    }
}
