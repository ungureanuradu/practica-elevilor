<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Chapter extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'description', 'order', 'is_published', 'course_id'
    ];

    protected $casts = [
        'is_published' => 'boolean',
    ];

    // Relationships
    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function modules(): HasMany
    {
        return $this->hasMany(Module::class)->orderBy('order');
    }

    public function publishedModules(): HasMany
    {
        return $this->hasMany(Module::class)
                    ->where('is_published', true)
                    ->orderBy('order');
    }

    // Scopes
    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    // Accessors
    public function getTotalDurationAttribute(): int
    {
        return $this->modules->sum('duration_minutes');
    }

    public function getModuleCountAttribute(): int
    {
        return $this->modules->count();
    }

    // Helper methods
    public function isPublished(): bool
    {
        return $this->is_published;
    }
}
