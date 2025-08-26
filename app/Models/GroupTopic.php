<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class GroupTopic extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'slug', 'description', 'icon', 'color', 'order',
        'is_active', 'is_pinned', 'is_public', 'permissions', 'posts_count', 'last_activity_at', 'group_id'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_pinned' => 'boolean',
        'is_public' => 'boolean',
        'permissions' => 'array',
        'last_activity_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($topic) {
            if (empty($topic->slug)) {
                $topic->slug = Str::slug($topic->name);
            }
        });
    }

    // Relationships
    public function group(): BelongsTo
    {
        return $this->belongsTo(Group::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopePinned($query)
    {
        return $query->where('is_pinned', true);
    }

    public function scopePublic($query)
    {
        return $query->where('is_public', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order')->orderBy('name');
    }

    // Accessors
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
        if (!$this->is_active) {
            return false;
        }

        if ($this->is_public) {
            return true;
        }

        if (!$user) {
            return false;
        }

        // Check if user is member of the group
        return $this->group->hasMember($user);
    }

    public function canBeCreatedBy(User $user = null): bool
    {
        if (!$user) {
            return false;
        }

        // Check if user can moderate the group
        return $this->group->canBeEditedBy($user);
    }

    public function updateCounts(): void
    {
        // This would be updated when posts are added/removed
        // For now, we'll just update the last activity
        $this->update(['last_activity_at' => now()]);
    }
}
