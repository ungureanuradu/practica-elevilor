<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class ForumCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'slug', 'description', 'icon', 'color', 'order',
        'is_active', 'is_public', 'access_level', 'permissions',
        'threads_count', 'posts_count', 'last_activity_at'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_public' => 'boolean',
        'permissions' => 'array',
        'last_activity_at' => 'datetime',
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }

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
    public function threads(): HasMany
    {
        return $this->hasMany(ForumThread::class, 'category_id');
    }

    public function activeThreads(): HasMany
    {
        return $this->hasMany(ForumThread::class, 'category_id')
                    ->where('status', 'active');
    }

    public function pinnedThreads(): HasMany
    {
        return $this->hasMany(ForumThread::class, 'category_id')
                    ->where('status', 'pinned');
    }

    public function recentThreads(): HasMany
    {
        return $this->hasMany(ForumThread::class, 'category_id')
                    ->where('status', 'active')
                    ->orderBy('last_reply_at', 'desc')
                    ->limit(5);
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

    public function getThreadsCountFormattedAttribute(): string
    {
        if ($this->threads_count >= 1000) {
            return number_format($this->threads_count / 1000, 1) . 'k';
        }
        return $this->threads_count;
    }

    public function getPostsCountFormattedAttribute(): string
    {
        if ($this->posts_count >= 1000) {
            return number_format($this->posts_count / 1000, 1) . 'k';
        }
        return $this->posts_count;
    }

    public function getLastActivityFormattedAttribute(): string
    {
        if (!$this->last_activity_at) {
            return 'Nicio activitate';
        }

        $diff = $this->last_activity_at->diffForHumans();
        return $diff;
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

        // Teachers can create threads in any category
        if ($user->isTeacher()) {
            return true;
        }

        // Students can create threads in student categories and public categories
        if ($user->isStudent()) {
            return in_array($this->access_level, ['public', 'students']);
        }

        return false;
    }

    public function updateCounts(): void
    {
        $this->update([
            'threads_count' => $this->activeThreads()->count(),
            'posts_count' => $this->threads()->withCount('posts')->get()->sum('posts_count'),
            'last_activity_at' => $this->threads()->max('last_reply_at'),
        ]);
    }
}
