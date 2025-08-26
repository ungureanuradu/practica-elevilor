<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class CalendarEvent extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'description', 'excerpt', 'location', 'url', 'type', 'status',
        'access_level', 'is_featured', 'requires_registration', 'max_participants',
        'registered_participants', 'recurrence_rules', 'reminders', 'attachments',
        'metadata', 'category_id', 'organizer_id', 'start_date', 'end_date', 'timezone'
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'requires_registration' => 'boolean',
        'recurrence_rules' => 'array',
        'reminders' => 'array',
        'attachments' => 'array',
        'metadata' => 'array',
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    // Relationships
    public function category(): BelongsTo
    {
        return $this->belongsTo(CalendarCategory::class, 'category_id');
    }

    public function organizer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'organizer_id');
    }

    // Scopes
    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    public function scopeByCategory($query, $categoryId)
    {
        return $query->where('category_id', $categoryId);
    }

    public function scopeByOrganizer($query, $organizerId)
    {
        return $query->where('organizer_id', $organizerId);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeUpcoming($query)
    {
        return $query->where('start_date', '>=', now());
    }

    public function scopePast($query)
    {
        return $query->where('end_date', '<', now());
    }

    public function scopeToday($query)
    {
        $today = Carbon::today();
        return $query->whereDate('start_date', $today);
    }

    public function scopeThisWeek($query)
    {
        $startOfWeek = Carbon::now()->startOfWeek();
        $endOfWeek = Carbon::now()->endOfWeek();
        return $query->whereBetween('start_date', [$startOfWeek, $endOfWeek]);
    }

    public function scopeThisMonth($query)
    {
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();
        return $query->whereBetween('start_date', [$startOfMonth, $endOfMonth]);
    }

    public function scopeByAccessLevel($query, $level)
    {
        return $query->where('access_level', $level);
    }

    public function scopeOrderByStartDate($query)
    {
        return $query->orderBy('start_date', 'asc');
    }

    // Accessors
    public function getTypeLabelAttribute(): string
    {
        return match($this->type) {
            'single' => 'Eveniment unic',
            'recurring' => 'Eveniment recurent',
            'all-day' => 'Toată ziua',
            default => 'Eveniment unic'
        };
    }

    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'draft' => 'Ciornă',
            'published' => 'Publicat',
            'cancelled' => 'Anulat',
            default => 'Ciornă'
        };
    }

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

    public function getStartDateFormattedAttribute(): string
    {
        return $this->start_date->format('d.m.Y H:i');
    }

    public function getEndDateFormattedAttribute(): string
    {
        return $this->end_date->format('d.m.Y H:i');
    }

    public function getDurationAttribute(): string
    {
        $duration = $this->start_date->diffInMinutes($this->end_date);
        
        if ($duration < 60) {
            return $duration . ' minute';
        } elseif ($duration < 1440) {
            $hours = floor($duration / 60);
            $minutes = $duration % 60;
            return $hours . 'h ' . $minutes . 'm';
        } else {
            $days = floor($duration / 1440);
            return $days . ' zile';
        }
    }

    public function getIsUpcomingAttribute(): bool
    {
        return $this->start_date->isFuture();
    }

    public function getIsPastAttribute(): bool
    {
        return $this->end_date->isPast();
    }

    public function getIsTodayAttribute(): bool
    {
        return $this->start_date->isToday();
    }

    public function getIsThisWeekAttribute(): bool
    {
        return $this->start_date->isThisWeek();
    }

    public function getIsThisMonthAttribute(): bool
    {
        return $this->start_date->isThisMonth();
    }

    public function getIsFullAttribute(): bool
    {
        return $this->max_participants && $this->registered_participants >= $this->max_participants;
    }

    public function getCanRegisterAttribute(): bool
    {
        return $this->requires_registration && !$this->is_full && $this->is_upcoming;
    }

    public function getRemainingSpotsAttribute(): int
    {
        if (!$this->max_participants) {
            return -1; // Unlimited
        }
        return max(0, $this->max_participants - $this->registered_participants);
    }

    // Helper methods
    public function isPublished(): bool
    {
        return $this->status === 'published';
    }

    public function canBeViewedBy(User $user = null): bool
    {
        if (!$this->isPublished()) {
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

    public function canBeEditedBy(User $user): bool
    {
        if (!$user) {
            return false;
        }

        // Organizer can edit their own events
        if ($this->organizer_id === $user->id) {
            return true;
        }

        // Teachers can edit any event
        if ($user->isTeacher()) {
            return true;
        }

        return false;
    }

    public function canBeDeletedBy(User $user): bool
    {
        if (!$user) {
            return false;
        }

        // Organizer can delete their own events
        if ($this->organizer_id === $user->id) {
            return true;
        }

        // Teachers can delete any event
        if ($user->isTeacher()) {
            return true;
        }

        return false;
    }

    public function publish(): void
    {
        $this->update(['status' => 'published']);
    }

    public function cancel(): void
    {
        $this->update(['status' => 'cancelled']);
    }

    public function incrementParticipants(): void
    {
        $this->increment('registered_participants');
    }

    public function decrementParticipants(): void
    {
        $this->decrement('registered_participants');
    }
}
