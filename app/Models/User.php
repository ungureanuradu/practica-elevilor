<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    protected $fillable = [
        'name', 'email', 'password', 'role', 'bio', 'phone', 'location', 'website',
        'school', 'year_of_study', 'skills', 'cv_path', 'department', 'title', 'specializations',
        'company_name', 'company_type', 'company_size', 'company_description',
        'is_public', 'is_available_for_contact', 'profile_completed_at',
    ];

    protected $hidden = [
        'password', 'remember_token', 'two_factor_recovery_codes', 'two_factor_secret',
    ];

    protected $appends = [
        'profile_photo_url', 'display_name', 'role_label',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'skills' => 'array',
            'specializations' => 'array',
            'is_public' => 'boolean',
            'is_available_for_contact' => 'boolean',
            'profile_completed_at' => 'datetime',
        ];
    }

    // Relații
    public function news() { return $this->hasMany(News::class); }
    public function events() { return $this->hasMany(Event::class); }
    public function groups() { return $this->belongsToMany(Group::class, 'group_members'); }
    public function jobApplications() { return $this->hasMany(JobApplication::class, 'applicant_id'); }

    // Accessors
    public function getDisplayNameAttribute(): string
    {
        if ($this->role === 'company' && $this->company_name) {
            return $this->company_name;
        }
        if ($this->role === 'teacher' && $this->title) {
            return $this->title . ' ' . $this->name;
        }
        return $this->name;
    }

    public function getRoleLabelAttribute(): string
    {
        return match($this->role) {
            'student' => 'Elev/Student',
            'teacher' => 'Profesor',
            'company' => 'Companie',
            default => 'Membru'
        };
    }

    // Scopes
    public function scopeStudents($query) { return $query->where('role', 'student'); }
    public function scopeTeachers($query) { return $query->where('role', 'teacher'); }
    public function scopeCompanies($query) { return $query->where('role', 'company'); }
    public function scopePublic($query) { return $query->where('is_public', true); }

    // Helper methods
    public function isStudent(): bool { return $this->role === 'student'; }
    public function isTeacher(): bool { return $this->role === 'teacher'; }
    public function isCompany(): bool { return $this->role === 'company'; }

    public function getProfileCompleteness(): int
    {
        $requiredFields = match($this->role) {
            'student' => ['bio', 'school', 'skills'],
            'teacher' => ['bio', 'department', 'specializations'],
            'company' => ['company_description', 'company_type', 'company_size'],
            default => ['bio']
        };

        $completed = 0;
        foreach ($requiredFields as $field) {
            if (!empty($this->$field)) $completed++;
        }

        return (int) (($completed / count($requiredFields)) * 100);
    }
}