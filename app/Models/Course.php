<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'description', 'excerpt', 'slug', 'thumbnail',
        'level', 'status', 'duration_hours', 'max_students',
        'price', 'is_free', 'tags', 'requirements', 'learning_outcomes',
        'instructor_id', 'published_at'
    ];

    protected $casts = [
        'tags' => 'array',
        'requirements' => 'array',
        'learning_outcomes' => 'array',
        'is_free' => 'boolean',
        'published_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($course) {
            if (empty($course->slug)) {
                $course->slug = Str::slug($course->title);
            }
        });
    }

    // Relationships
    public function instructor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'instructor_id');
    }

    public function chapters(): HasMany
    {
        return $this->hasMany(Chapter::class)->orderBy('order');
    }

    public function publishedChapters(): HasMany
    {
        return $this->hasMany(Chapter::class)->where('is_published', true)->orderBy('order');
    }

    // Scopes
    public function scopePublished($query)
    {
        return $query->where('status', 'published')
                    ->whereNotNull('published_at');
    }

    public function scopeByLevel($query, $level)
    {
        return $query->where('level', $level);
    }

    public function scopeFree($query)
    {
        return $query->where('is_free', true);
    }

    public function scopePaid($query)
    {
        return $query->where('is_free', false);
    }

    // Accessors
    public function getFormattedPriceAttribute(): string
    {
        if ($this->is_free) {
            return 'Gratuit';
        }
        return number_format($this->price, 2) . ' RON';
    }

    public function getTotalModulesAttribute(): int
    {
        return $this->chapters->sum(function ($chapter) {
            return $chapter->modules->count();
        });
    }

    public function getTotalDurationAttribute(): int
    {
        return $this->chapters->sum(function ($chapter) {
            return $chapter->modules->sum('duration_minutes');
        });
    }

    // Helper methods
    public function isPublished(): bool
    {
        return $this->status === 'published' && $this->published_at !== null;
    }

    public function canBeAccessedBy(User $user): bool
    {
        // Free courses can be accessed by anyone
        if ($this->is_free) {
            return true;
        }

        // TODO: Add enrollment check when we implement enrollment system
        return false;
    }
}
