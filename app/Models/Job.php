<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Job extends Model
{
    use HasFactory;

    protected $table = 'job_postings';

    protected $fillable = [
        'title', 'description', 'requirements', 'benefits',
        'type', 'level', 'status', 'location', 'remote_ok', 'hybrid_ok',
        'salary_min', 'salary_max', 'salary_currency', 'salary_negotiable',
        'skills_required', 'skills_preferred', 'positions_available',
        'application_deadline', 'start_date', 'contact_email', 'contact_phone',
        'application_url', 'cv_required', 'cover_letter_required',
        'application_instructions', 'company_id', 'published_at'
    ];

    protected $casts = [
        'remote_ok' => 'boolean',
        'hybrid_ok' => 'boolean',
        'salary_negotiable' => 'boolean',
        'cv_required' => 'boolean',
        'cover_letter_required' => 'boolean',
        'skills_required' => 'array',
        'skills_preferred' => 'array',
        'application_deadline' => 'date',
        'start_date' => 'date',
        'published_at' => 'datetime',
    ];

    // Relationships
    public function company(): BelongsTo
    {
        return $this->belongsTo(User::class, 'company_id');
    }

    public function applications(): HasMany
    {
        return $this->hasMany(JobApplication::class);
    }

    public function pendingApplications(): HasMany
    {
        return $this->hasMany(JobApplication::class)->where('status', 'pending');
    }

    public function activeApplications(): HasMany
    {
        return $this->hasMany(JobApplication::class)->whereIn('status', ['pending', 'reviewed', 'shortlisted', 'interviewed']);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    public function scopeByLevel($query, $level)
    {
        return $query->where('level', $level);
    }

    public function scopeRemote($query)
    {
        return $query->where('remote_ok', true);
    }

    public function scopeHybrid($query)
    {
        return $query->where('hybrid_ok', true);
    }

    public function scopeByLocation($query, $location)
    {
        return $query->where('location', 'like', "%{$location}%");
    }

    public function scopeBySkills($query, $skills)
    {
        return $query->whereJsonContains('skills_required', $skills);
    }

    public function scopePublished($query)
    {
        return $query->whereNotNull('published_at');
    }

    public function scopeNotExpired($query)
    {
        return $query->where(function($q) {
            $q->whereNull('application_deadline')
              ->orWhere('application_deadline', '>=', now());
        });
    }

    // Accessors
    public function getFormattedSalaryAttribute(): string
    {
        if (!$this->salary_min && !$this->salary_max) {
            return 'Negociabil';
        }

        if ($this->salary_min && $this->salary_max) {
            return number_format($this->salary_min, 0) . ' - ' . number_format($this->salary_max, 0) . ' ' . $this->salary_currency;
        }

        if ($this->salary_min) {
            return 'De la ' . number_format($this->salary_min, 0) . ' ' . $this->salary_currency;
        }

        return 'Până la ' . number_format($this->salary_max, 0) . ' ' . $this->salary_currency;
    }

    public function getTypeLabelAttribute(): string
    {
        return match($this->type) {
            'full-time' => 'Full-time',
            'part-time' => 'Part-time',
            'internship' => 'Internship',
            'mentorship' => 'Mentorship',
            'freelance' => 'Freelance',
            default => 'Full-time'
        };
    }

    public function getLevelLabelAttribute(): string
    {
        return match($this->level) {
            'entry' => 'Entry Level',
            'junior' => 'Junior',
            'mid' => 'Mid Level',
            'senior' => 'Senior',
            default => 'Entry Level'
        };
    }

    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'active' => 'Activ',
            'paused' => 'Pus pe pauză',
            'closed' => 'Închis',
            default => 'Activ'
        };
    }

    public function getApplicationsCountAttribute(): int
    {
        return $this->applications()->count();
    }

    public function getIsExpiredAttribute(): bool
    {
        return $this->application_deadline && $this->application_deadline < now();
    }

    public function getIsActiveAttribute(): bool
    {
        return $this->status === 'active' && !$this->is_expired;
    }

    // Helper methods
    public function isPublished(): bool
    {
        return $this->published_at !== null;
    }

    public function canBeAppliedTo(): bool
    {
        return $this->is_active && $this->is_published;
    }

    public function hasUserApplied(User $user): bool
    {
        return $this->applications()->where('applicant_id', $user->id)->exists();
    }

    public function getUserApplication(User $user): ?JobApplication
    {
        return $this->applications()->where('applicant_id', $user->id)->first();
    }
}
