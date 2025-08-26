<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GroupMember extends Model
{
    use HasFactory;

    protected $fillable = [
        'group_id', 'user_id', 'role', 'status', 'notes',
        'joined_at', 'last_activity_at'
    ];

    protected $casts = [
        'joined_at' => 'datetime',
        'last_activity_at' => 'datetime',
    ];

    // Relationships
    public function group(): BelongsTo
    {
        return $this->belongsTo(Group::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeByRole($query, $role)
    {
        return $query->where('role', $role);
    }

    public function scopeModerators($query)
    {
        return $query->where('role', 'moderator');
    }

    public function scopeMembers($query)
    {
        return $query->where('role', 'member');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    // Accessors
    public function getRoleLabelAttribute(): string
    {
        return match($this->role) {
            'owner' => 'Proprietar',
            'moderator' => 'Moderator',
            'member' => 'Membru',
            'invited' => 'Invitat',
            'pending' => 'În așteptare',
            default => 'Membru'
        };
    }

    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'active' => 'Activ',
            'inactive' => 'Inactiv',
            'banned' => 'Interzis',
            'left' => 'A plecat',
            default => 'Activ'
        };
    }

    public function getJoinedFormattedAttribute(): string
    {
        if (!$this->joined_at) {
            return 'N/A';
        }

        $diff = $this->joined_at->diffForHumans();
        return $diff;
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
    public function isOwner(): bool
    {
        return $this->role === 'owner';
    }

    public function isModerator(): bool
    {
        return $this->role === 'moderator';
    }

    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    public function isBanned(): bool
    {
        return $this->status === 'banned';
    }

    public function canModerate(): bool
    {
        return $this->isOwner() || $this->isModerator();
    }

    public function updateLastActivity(): void
    {
        $this->update(['last_activity_at' => now()]);
    }
}
