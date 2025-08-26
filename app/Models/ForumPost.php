<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class ForumPost extends Model
{
    use HasFactory;

    protected $fillable = [
        'content', 'status', 'is_solution', 'is_edited', 'likes_count',
        'attachments', 'thread_id', 'author_id', 'parent_id',
        'edited_by_id', 'edited_at'
    ];

    protected $casts = [
        'is_solution' => 'boolean',
        'is_edited' => 'boolean',
        'attachments' => 'array',
        'edited_at' => 'datetime',
    ];

    // Relationships
    public function thread(): BelongsTo
    {
        return $this->belongsTo(ForumThread::class, 'thread_id');
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(ForumPost::class, 'parent_id');
    }

    public function replies(): HasMany
    {
        return $this->hasMany(ForumPost::class, 'parent_id');
    }

    public function editedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'edited_by_id');
    }

    public function likes(): MorphMany
    {
        return $this->morphMany(ForumLike::class, 'likeable');
    }

    public function bookmarks(): MorphMany
    {
        return $this->morphMany(ForumBookmark::class, 'bookmarkable');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeSolutions($query)
    {
        return $query->where('is_solution', true);
    }

    public function scopeByAuthor($query, $authorId)
    {
        return $query->where('author_id', $authorId);
    }

    public function scopeReplies($query)
    {
        return $query->whereNotNull('parent_id');
    }

    public function scopeTopLevel($query)
    {
        return $query->whereNull('parent_id');
    }

    public function scopeRecent($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    // Accessors
    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'active' => 'Activ',
            'hidden' => 'Ascuns',
            'deleted' => 'Șters',
            default => 'Activ'
        };
    }

    public function getIsLikedByUserAttribute(): bool
    {
        if (!auth()->check()) {
            return false;
        }

        return $this->likes()->where('user_id', auth()->id())->exists();
    }

    public function getIsBookmarkedByUserAttribute(): bool
    {
        if (!auth()->check()) {
            return false;
        }

        return $this->bookmarks()->where('user_id', auth()->id())->exists();
    }

    public function getEditedFormattedAttribute(): string
    {
        if (!$this->is_edited || !$this->edited_at) {
            return '';
        }

        return 'Editat ' . $this->edited_at->diffForHumans();
    }

    public function getAttachmentsCountAttribute(): int
    {
        return is_array($this->attachments) ? count($this->attachments) : 0;
    }

    public function getHasAttachmentsAttribute(): bool
    {
        return $this->attachments_count > 0;
    }

    // Helper methods
    public function canBeEditedBy(User $user = null): bool
    {
        if (!$user) {
            return false;
        }

        // Author can edit their own posts
        if ($this->author_id === $user->id) {
            return true;
        }

        // Teachers can edit any post
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

        // Author can delete their own posts
        if ($this->author_id === $user->id) {
            return true;
        }

        // Teachers can delete any post
        if ($user->isTeacher()) {
            return true;
        }

        return false;
    }

    public function canBeMarkedAsSolutionBy(User $user = null): bool
    {
        if (!$user) {
            return false;
        }

        // Thread author can mark solutions
        if ($this->thread->author_id === $user->id) {
            return true;
        }

        // Teachers can mark solutions
        if ($user->isTeacher()) {
            return true;
        }

        return false;
    }

    public function markAsSolution(): void
    {
        // Remove solution from other posts in the thread
        $this->thread->posts()->where('is_solution', true)->update(['is_solution' => false]);
        
        // Mark this post as solution
        $this->update(['is_solution' => true]);
        
        // Update thread
        $this->thread->markAsSolved($this, auth()->user());
    }

    public function unmarkAsSolution(): void
    {
        $this->update(['is_solution' => false]);
        $this->thread->markAsUnsolved();
    }

    public function markAsEdited(User $editor): void
    {
        $this->update([
            'is_edited' => true,
            'edited_by_id' => $editor->id,
            'edited_at' => now(),
        ]);
    }

    public function incrementLikes(): void
    {
        $this->increment('likes_count');
    }

    public function decrementLikes(): void
    {
        $this->decrement('likes_count');
    }
}
