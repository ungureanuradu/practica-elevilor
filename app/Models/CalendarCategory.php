<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class CalendarCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'slug', 'description', 'color', 'icon', 'order',
        'is_active', 'is_public', 'access_level', 'permissions', 'events_count'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_public' => 'boolean',
        'permissions' => 'array',
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($category) {
            if (empty($category->slug)) {
                $category->slug = Str::slug($category->name);
            }
        });
    }

    // Relationships
    public function events(): HasMany
    {
        return $this->hasMany(CalendarEvent::class, 'category_id');
    }

    public function publishedEvents(): HasMany
    {
        return $this->hasMany(CalendarEvent::class, 'category_id')
                    ->where('status', 'published');
    }

    public function upcomingEvents(): HasMany
    {
        return $this->hasMany(CalendarEvent::class, 'category_id')
                    ->where('status', 'published')
                    ->where('start_date', '>=', now())
                    ->orderBy('start_date', 'asc');
    }

    public function featuredEvents(): HasMany
    {
        return $this->hasMany(CalendarEvent::class, 'category_id')
                    ->where('status', 'published')
                    ->where('is_featured', true);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopePublic($query)
    {
        return $query->where('is_public', true);
    }

    public function scopeByAccessLevel($query, $level)
    {
        return $query->where('access_level', $level);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order')->orderBy('name');
    }

    // Accessors
    public function getAccessLevelLabelAttribute(): string
    {
        return match($this->access_level) {
            'public' => 'Public',
            'students' => 'Studenți',
            'teachers' => 'Profesori',
            'authenticated' => 'Autentificați',
            default => 'Public'
        };
    }

    public function getEventsCountFormattedAttribute(): string
    {
        if ($this->events_count >= 1000) {
            return number_format($this->events_count / 1000, 1) . 'k';
        }
        return $this->events_count;
    }

    // Helper methods
    public function canBeAccessedBy(User $user = null): bool
    {
        if (!$this->is_active || !$this->is_public) {
            return false;
        }

        if ($this->access_level === 'public') {
            return true;
        }

        if (!$user) {
            return false;
        }

        return match($this->access_level) {
            'authenticated' => true,
            'students' => $user->isStudent(),
            'teachers' => $user->isTeacher(),
            default => false
        };
    }

    public function canBeCreatedBy(User $user = null): bool
    {
        if (!$user) {
            return false;
        }

        // Teachers can create events in any category
        if ($user->isTeacher()) {
            return true;
        }

        // Students can create events in student categories and public categories
        if ($user->isStudent()) {
            return in_array($this->access_level, ['public', 'students']);
        }

        return false;
    }

    public function updateCounts(): void
    {
        $this->update([
            'events_count' => $this->publishedEvents()->count(),
        ]);
    }
}
