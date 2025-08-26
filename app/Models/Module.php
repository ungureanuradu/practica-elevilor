<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Module extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'content', 'type', 'file_path', 'video_url',
        'duration_minutes', 'order', 'is_published', 'metadata', 'chapter_id'
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'metadata' => 'array',
    ];

    // Relationships
    public function chapter(): BelongsTo
    {
        return $this->belongsTo(Chapter::class);
    }

    public function course(): BelongsTo
    {
        return $this->chapter->course;
    }

    // Scopes
    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    // Accessors
    public function getFormattedDurationAttribute(): string
    {
        if (!$this->duration_minutes) {
            return 'N/A';
        }

        $hours = floor($this->duration_minutes / 60);
        $minutes = $this->duration_minutes % 60;

        if ($hours > 0) {
            return $hours . 'h ' . $minutes . 'm';
        }

        return $minutes . ' min';
    }

    public function getFileUrlAttribute(): ?string
    {
        if ($this->file_path) {
            return asset('storage/' . $this->file_path);
        }
        return null;
    }

    // Helper methods
    public function isPublished(): bool
    {
        return $this->is_published;
    }

    public function isVideo(): bool
    {
        return $this->type === 'video';
    }

    public function isFile(): bool
    {
        return $this->type === 'file';
    }

    public function isQuiz(): bool
    {
        return $this->type === 'quiz';
    }

    public function isAssignment(): bool
    {
        return $this->type === 'assignment';
    }

    public function isText(): bool
    {
        return $this->type === 'text';
    }
}
