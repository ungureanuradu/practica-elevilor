<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;

class Group extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'slug', 'description', 'excerpt', 'avatar', 'cover_image',
        'type', 'category', 'tags', 'settings', 'is_active', 'requires_approval',
        'max_members', 'members_count', 'topics_count', 'posts_count',
        'owner_id', 'moderator_id', 'last_activity_at'
    ];

    protected $casts = [
        'tags' => 'array',
        'settings' => 'array',
        'is_active' => 'boolean',
        'requires_approval' => 'boolean',
        'last_activity_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($group) {
            if (empty($group->slug)) {
                $group->slug = Str::slug($group->name);
            }
        });
    }

    // Relationships
    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function moderator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'moderator_id');
    }

    public function members(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'group_members')
                    ->withPivot(['role', 'status', 'notes', 'joined_at', 'last_activity_at'])
                    ->withTimestamps();
    }

    public function activeMembers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'group_members')
                    ->wherePivot('status', 'active')
                    ->withPivot(['role', 'joined_at', 'last_activity_at'])
                    ->withTimestamps();
    }

    public function moderators(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'group_members')
                    ->wherePivot('role', 'moderator')
                    ->wherePivot('status', 'active')
                    ->withPivot(['joined_at', 'last_activity_at'])
                    ->withTimestamps();
    }

    public function pendingMembers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'group_members')
                    ->wherePivot('status', 'pending')
                    ->withPivot(['notes', 'created_at'])
                    ->withTimestamps();
    }

    public function groupMembers(): HasMany
    {
        return $this->hasMany(GroupMember::class);
    }

    public function topics(): HasMany
    {
        return $this->hasMany(GroupTopic::class);
    }

    public function activeTopics(): HasMany
    {
        return $this->hasMany(GroupTopic::class)->where('is_active', true);
    }

    public function pinnedTopics(): HasMany
    {
        return $this->hasMany(GroupTopic::class)->where('is_pinned', true);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    public function scopePublic($query)
    {
        return $query->where('type', 'public');
    }

    public function scopeByOwner($query, $ownerId)
    {
        return $query->where('owner_id', $ownerId);
    }

    public function scopePopular($query)
    {
        return $query->orderBy('members_count', 'desc');
    }

    public function scopeRecent($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    public function scopeByTags($query, $tags)
    {
        return $query->whereJsonContains('tags', $tags);
    }

    // Accessors
    public function getTypeLabelAttribute(): string
    {
        return match($this->type) {
            'public' => 'Public',
            'private' => 'Privat',
            'secret' => 'Secret',
            default => 'Public'
        };
    }

    public function getCategoryLabelAttribute(): string
    {
        return match($this->category) {
            'academic' => 'Academic',
            'hobby' => 'Hobby',
            'professional' => 'Profesional',
            'social' => 'Social',
            'study' => 'Studiu',
            'project' => 'Proiect',
            'other' => 'Altul',
            default => 'Altul'
        };
    }

    public function getMembersCountFormattedAttribute(): string
    {
        if ($this->members_count >= 1000) {
            return number_format($this->members_count / 1000, 1) . 'k';
        }
        return $this->members_count;
    }

    public function getLastActivityFormattedAttribute(): string
    {
        if (!$this->last_activity_at) {
            return 'Nicio activitate';
        }

        $diff = $this->last_activity_at->diffForHumans();
        return $diff;
    }

    public function getAvatarUrlAttribute(): string
    {
        if ($this->avatar) {
            return asset('storage/' . $this->avatar);
        }
        return asset('images/default-group-avatar.png');
    }

    public function getCoverImageUrlAttribute(): string
    {
        if ($this->cover_image) {
            return asset('storage/' . $this->cover_image);
        }
        return asset('images/default-group-cover.jpg');
    }

    public function getIsFullAttribute(): bool
    {
        return $this->max_members && $this->members_count >= $this->max_members;
    }

    public function getCanJoinAttribute(): bool
    {
        return $this->is_active && !$this->is_full && $this->type !== 'secret';
    }

    // Helper methods
    public function isOwnedBy(User $user): bool
    {
        return $this->owner_id === $user->id;
    }

    public function isModeratedBy(User $user): bool
    {
        return $this->moderator_id === $user->id;
    }

    public function hasMember(User $user): bool
    {
        return $this->members()->where('user_id', $user->id)->where('status', 'active')->exists();
    }

    public function hasModerator(User $user): bool
    {
        return $this->moderators()->where('user_id', $user->id)->exists();
    }

    public function canBeJoinedBy(User $user): bool
    {
        if (!$this->can_join) {
            return false;
        }

        if ($this->hasMember($user)) {
            return false;
        }

        return true;
    }

    public function canBeViewedBy(User $user = null): bool
    {
        if ($this->type === 'public') {
            return true;
        }

        if (!$user) {
            return false;
        }

        if ($this->type === 'private') {
            return $this->hasMember($user) || $this->isOwnedBy($user);
        }

        if ($this->type === 'secret') {
            return $this->hasMember($user) || $this->isOwnedBy($user);
        }

        return false;
    }

    public function canBeEditedBy(User $user): bool
    {
        return $this->isOwnedBy($user) || $this->isModeratedBy($user);
    }

    public function canBeDeletedBy(User $user): bool
    {
        return $this->isOwnedBy($user);
    }

    public function addMember(User $user, string $role = 'member'): void
    {
        $this->members()->attach($user->id, [
            'role' => $role,
            'status' => 'active',
            'joined_at' => now(),
            'last_activity_at' => now(),
        ]);

        $this->increment('members_count');
    }

    public function removeMember(User $user): void
    {
        $this->members()->detach($user->id);
        $this->decrement('members_count');
    }

    public function updateMemberRole(User $user, string $role): void
    {
        $this->members()->updateExistingPivot($user->id, ['role' => $role]);
    }

    public function banMember(User $user, string $notes = null): void
    {
        $this->members()->updateExistingPivot($user->id, [
            'status' => 'banned',
            'notes' => $notes,
        ]);
    }

    public function updateCounts(): void
    {
        $this->update([
            'members_count' => $this->activeMembers()->count(),
            'topics_count' => $this->activeTopics()->count(),
            'last_activity_at' => $this->topics()->max('last_activity_at'),
        ]);
    }
}
