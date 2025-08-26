<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JobApplication extends Model
{
    use HasFactory;

    protected $fillable = [
        'job_id', 'applicant_id', 'status', 'cover_letter', 'cv_path',
        'portfolio_url', 'answers', 'notes', 'feedback', 'reviewed_at',
        'interview_scheduled_at', 'responded_at'
    ];

    protected $casts = [
        'answers' => 'array',
        'reviewed_at' => 'datetime',
        'interview_scheduled_at' => 'datetime',
        'responded_at' => 'datetime',
    ];

    // Relationships
    public function job(): BelongsTo
    {
        return $this->belongsTo(Job::class, 'job_id');
    }

    public function applicant(): BelongsTo
    {
        return $this->belongsTo(User::class, 'applicant_id');
    }

    public function company(): BelongsTo
    {
        return $this->job->company();
    }

    // Scopes
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeReviewed($query)
    {
        return $query->where('status', 'reviewed');
    }

    public function scopeShortlisted($query)
    {
        return $query->where('status', 'shortlisted');
    }

    public function scopeInterviewed($query)
    {
        return $query->where('status', 'interviewed');
    }

    public function scopeAccepted($query)
    {
        return $query->where('status', 'accepted');
    }

    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }

    public function scopeActive($query)
    {
        return $query->whereIn('status', ['pending', 'reviewed', 'shortlisted', 'interviewed']);
    }

    // Accessors
    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'pending' => 'În așteptare',
            'reviewed' => 'Revizuit',
            'shortlisted' => 'Pe lista scurtă',
            'interviewed' => 'Interviu programat',
            'accepted' => 'Acceptat',
            'rejected' => 'Respins',
            default => 'În așteptare'
        };
    }

    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'pending' => 'yellow',
            'reviewed' => 'blue',
            'shortlisted' => 'green',
            'interviewed' => 'purple',
            'accepted' => 'green',
            'rejected' => 'red',
            default => 'gray'
        };
    }

    public function getCvUrlAttribute(): ?string
    {
        if ($this->cv_path) {
            return asset('storage/' . $this->cv_path);
        }
        return null;
    }

    public function getDaysSinceAppliedAttribute(): int
    {
        return $this->created_at->diffInDays(now());
    }

    public function getIsPendingAttribute(): bool
    {
        return $this->status === 'pending';
    }

    public function getIsActiveAttribute(): bool
    {
        return in_array($this->status, ['pending', 'reviewed', 'shortlisted', 'interviewed']);
    }

    public function getIsCompletedAttribute(): bool
    {
        return in_array($this->status, ['accepted', 'rejected']);
    }

    // Helper methods
    public function canBeUpdated(): bool
    {
        return $this->is_pending;
    }

    public function canBeWithdrawn(): bool
    {
        return $this->is_active;
    }

    public function markAsReviewed(): void
    {
        $this->update([
            'status' => 'reviewed',
            'reviewed_at' => now(),
        ]);
    }

    public function shortlist(): void
    {
        $this->update(['status' => 'shortlisted']);
    }

    public function scheduleInterview(\DateTime $dateTime): void
    {
        $this->update([
            'status' => 'interviewed',
            'interview_scheduled_at' => $dateTime,
        ]);
    }

    public function accept(): void
    {
        $this->update([
            'status' => 'accepted',
            'responded_at' => now(),
        ]);
    }

    public function reject(string $feedback = null): void
    {
        $this->update([
            'status' => 'rejected',
            'feedback' => $feedback,
            'responded_at' => now(),
        ]);
    }

    public function addNote(string $note): void
    {
        $currentNotes = $this->notes ? $this->notes . "\n\n" : '';
        $this->update(['notes' => $currentNotes . now()->format('Y-m-d H:i') . ': ' . $note]);
    }
}
