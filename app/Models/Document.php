<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Document extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'slug', 'description', 'excerpt', 'type', 'status', 'access_level',
        'is_featured', 'is_downloadable', 'requires_approval', 'downloads_count',
        'views_count', 'file_size', 'file_extension', 'mime_type', 'tags', 'metadata',
        'category_id', 'uploader_id', 'approved_by_id', 'published_at', 'approved_at'
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'is_downloadable' => 'boolean',
        'requires_approval' => 'boolean',
        'tags' => 'array',
        'metadata' => 'array',
        'published_at' => 'datetime',
        'approved_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($document) {
            if (empty($document->slug)) {
                $document->slug = Str::slug($document->title);
            }
        });
    }

    // Relationships
    public function category(): BelongsTo
    {
        return $this->belongsTo(DocumentCategory::class, 'category_id');
    }

    public function uploader(): BelongsTo
    {
        return $this->belongsTo(User::class, 'uploader_id');
    }

    public function approvedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by_id');
    }

    public function versions(): HasMany
    {
        return $this->hasMany(DocumentVersion::class);
    }

    public function currentVersion(): HasMany
    {
        return $this->hasMany(DocumentVersion::class)->where('is_current', true);
    }

    public function latestVersion(): HasMany
    {
        return $this->hasMany(DocumentVersion::class)->latest();
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

    public function scopeByUploader($query, $uploaderId)
    {
        return $query->where('uploader_id', $uploaderId);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeDownloadable($query)
    {
        return $query->where('is_downloadable', true);
    }

    public function scopeByAccessLevel($query, $level)
    {
        return $query->where('access_level', $level);
    }

    public function scopeByTags($query, $tags)
    {
        return $query->whereJsonContains('tags', $tags);
    }

    public function scopeRecent($query)
    {
        return $query->orderBy('published_at', 'desc');
    }

    public function scopePopular($query)
    {
        return $query->orderBy('downloads_count', 'desc');
    }

    public function scopeMostViewed($query)
    {
        return $query->orderBy('views_count', 'desc');
    }

    // Accessors
    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'draft' => 'Ciornă',
            'published' => 'Publicat',
            'archived' => 'Arhivat',
            default => 'Ciornă'
        };
    }

    public function getTypeLabelAttribute(): string
    {
        return match($this->type) {
            'pdf' => 'PDF',
            'doc' => 'Word Document',
            'docx' => 'Word Document',
            'ppt' => 'PowerPoint',
            'pptx' => 'PowerPoint',
            'xls' => 'Excel',
            'xlsx' => 'Excel',
            'txt' => 'Text',
            'zip' => 'Archive',
            'rar' => 'Archive',
            'image' => 'Image',
            'video' => 'Video',
            'audio' => 'Audio',
            'other' => 'Other',
            default => 'Other'
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

    public function getFileSizeFormattedAttribute(): string
    {
        if (!$this->file_size) {
            return 'N/A';
        }

        $units = ['B', 'KB', 'MB', 'GB'];
        $size = $this->file_size;
        $unit = 0;

        while ($size >= 1024 && $unit < count($units) - 1) {
            $size /= 1024;
            $unit++;
        }

        return round($size, 2) . ' ' . $units[$unit];
    }

    public function getDownloadsCountFormattedAttribute(): string
    {
        if ($this->downloads_count >= 1000) {
            return number_format($this->downloads_count / 1000, 1) . 'k';
        }
        return $this->downloads_count;
    }

    public function getViewsCountFormattedAttribute(): string
    {
        if ($this->views_count >= 1000) {
            return number_format($this->views_count / 1000, 1) . 'k';
        }
        return $this->views_count;
    }

    public function getPublishedFormattedAttribute(): string
    {
        if (!$this->published_at) {
            return 'Nepublicat';
        }

        $diff = $this->published_at->diffForHumans();
        return $diff;
    }

    public function getCurrentVersionAttribute(): ?DocumentVersion
    {
        return $this->versions()->where('is_current', true)->first();
    }

    public function getDownloadUrlAttribute(): ?string
    {
        $currentVersion = $this->currentVersion;
        if (!$currentVersion) {
            return null;
        }

        return route('documents.download', $this);
    }

    public function getPreviewUrlAttribute(): ?string
    {
        if (in_array($this->type, ['image', 'pdf'])) {
            return route('documents.preview', $this);
        }

        return null;
    }

    // Helper methods
    public function isPublished(): bool
    {
        return $this->status === 'published';
    }

    public function isApproved(): bool
    {
        return $this->approved_at !== null;
    }

    public function canBeAccessedBy(User $user = null): bool
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

    public function canBeDownloadedBy(User $user = null): bool
    {
        if (!$this->is_downloadable) {
            return false;
        }

        return $this->canBeAccessedBy($user);
    }

    public function canBeEditedBy(User $user = null): bool
    {
        if (!$user) {
            return false;
        }

        // Uploader can edit their own documents
        if ($this->uploader_id === $user->id) {
            return true;
        }

        // Teachers can edit any document
        if ($user->isTeacher()) {
            return true;
        }

        return false;
    }

    public function canBeDeletedBy(User $user = null): bool
    {
        if (!$user) {
            return false;
        }

        // Uploader can delete their own documents
        if ($this->uploader_id === $user->id) {
            return true;
        }

        // Teachers can delete any document
        if ($user->isTeacher()) {
            return true;
        }

        return false;
    }

    public function incrementViews(): void
    {
        $this->increment('views_count');
    }

    public function incrementDownloads(): void
    {
        $this->increment('downloads_count');
    }

    public function approve(User $approver): void
    {
        $this->update([
            'approved_by_id' => $approver->id,
            'approved_at' => now(),
        ]);
    }

    public function publish(): void
    {
        $this->update([
            'status' => 'published',
            'published_at' => now(),
        ]);
    }

    public function archive(): void
    {
        $this->update(['status' => 'archived']);
    }
}
