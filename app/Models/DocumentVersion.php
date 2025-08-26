<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DocumentVersion extends Model
{
    use HasFactory;

    protected $fillable = [
        'version_number', 'file_path', 'file_name', 'file_size',
        'file_extension', 'mime_type', 'change_notes', 'metadata',
        'document_id', 'uploader_id', 'is_current'
    ];

    protected $casts = [
        'is_current' => 'boolean',
        'metadata' => 'array',
    ];

    // Relationships
    public function document(): BelongsTo
    {
        return $this->belongsTo(Document::class);
    }

    public function uploader(): BelongsTo
    {
        return $this->belongsTo(User::class, 'uploader_id');
    }

    // Scopes
    public function scopeCurrent($query)
    {
        return $query->where('is_current', true);
    }

    public function scopeByVersion($query, $versionNumber)
    {
        return $query->where('version_number', $versionNumber);
    }

    // Accessors
    public function getFileSizeFormattedAttribute(): string
    {
        $units = ['B', 'KB', 'MB', 'GB'];
        $size = $this->file_size;
        $unit = 0;

        while ($size >= 1024 && $unit < count($units) - 1) {
            $size /= 1024;
            $unit++;
        }

        return round($size, 2) . ' ' . $units[$unit];
    }

    public function getDownloadUrlAttribute(): string
    {
        return route('documents.download-version', [
            'document' => $this->document_id,
            'version' => $this->id
        ]);
    }

    public function getFileUrlAttribute(): string
    {
        return asset('storage/' . $this->file_path);
    }

    // Helper methods
    public function makeCurrent(): void
    {
        // Remove current flag from other versions
        $this->document->versions()->update(['is_current' => false]);
        
        // Set this version as current
        $this->update(['is_current' => true]);
    }

    public function isCurrent(): bool
    {
        return $this->is_current;
    }
}
