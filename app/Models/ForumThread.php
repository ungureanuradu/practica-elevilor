<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Str;

class ForumThread extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'slug', 'content', 'status', 'type', 'is_solved', 'is_featured',
        'views_count', 'replies_count', 'likes_count', 'tags',
        'category_id', 'author_id', 'last_post_id', 'solved_by_id',
        'last_reply_at', 'solved_at'
    ];

    protected $casts = [
        'is_solved' => 'boolean',
        'is_featured' => 'boolean',
        'tags' => 'array',
        'last_reply_at' => 'datetime',
        'solved_at' => 'datetime',
    ];

    // public function getRouteKeyName()
    // {
    //     return 'slug';
    // }

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($thread) {
            if (empty($thread->slug)) {
                $thread->slug = Str::slug($thread->title);
            }
        });
    }

    // Relationships
    public function category(): BelongsTo
    {
        return $this->belongsTo(ForumCategory::class, 'category_id');
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function lastPost(): BelongsTo
    {
        return $this->belongsTo(ForumPost::class, 'last_post_id');
    }

    public function solvedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'solved_by_id');
    }

    public function posts(): HasMany
    {
        return $this->hasMany(ForumPost::class, 'thread_id');
    }

    public function activePosts(): HasMany
    {
        return $this->hasMany(ForumPost::class, 'thread_id')
                    ->where('status', 'active');
    }

    public function solutionPost(): HasMany
    {
        return $this->hasMany(ForumPost::class, 'thread_id')
                    ->where('is_solution', true);
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

    public function scopePinned($query)
    {
        return $query->where('status', 'pinned');
    }

    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    public function scopeSolved($query)
    {
        return $query->where('is_solved', true);
    }

    public function scopeUnsolved($query)
    {
        return $query->where('is_solved', false);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeByCategory($query, $categoryId)
    {
        return $query->where('category_id', $categoryId);
    }

    public function scopeByAuthor($query, $authorId)
    {
        return $query->where('author_id', $authorId);
    }

    public function scopeRecent($query)
    {
        return $query->orderBy('last_reply_at', 'desc');
    }

    public function scopePopular($query)
    {
        return $query->orderBy('views_count', 'desc');
    }

    public function scopeByTags($query, $tags)
    {
        return $query->whereJsonContains('tags', $tags);
    }

    // Accessors
    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'active' => 'Activ',
            'locked' => 'Închis',
            'pinned' => 'Fixes',
            'archived' => 'Arhivat',
            default => 'Activ'
        };
    }

    public function getTypeLabelAttribute(): string
    {
        return match($this->type) {
            'discussion' => 'Discuție',
            'question' => 'Întrebare',
            'announcement' => 'Anunț',
            'sticky' => 'Important',
            default => 'Discuție'
        };
    }

    public function getViewsCountFormattedAttribute(): string
    {
        if ($this->views_count >= 1000) {
            return number_format($this->views_count / 1000, 1) . 'k';
        }
        return $this->views_count;
    }

    public function getRepliesCountFormattedAttribute(): string
    {
        if ($this->replies_count >= 1000) {
            return number_format($this->replies_count / 1000, 1) . 'k';
        }
        return $this->replies_count;
    }

    public function getLastReplyFormattedAttribute(): string
    {
        if (!$this->last_reply_at) {
            return 'Nicio răspuns';
        }

        $diff = $this->last_reply_at->diffForHumans();
        return $diff;
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

    // Helper methods
    public function canBeEditedBy(User $user = null): bool
    {
        if (!$user) {
            return false;
        }

        // Author can edit their own threads
        if ($this->author_id === $user->id) {
            return true;
        }

        // Teachers can edit any thread
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

        // Author can delete their own threads
        if ($this->author_id === $user->id) {
            return true;
        }

        // Teachers can delete any thread
        if ($user->isTeacher()) {
            return true;
        }

        return false;
    }

    public function incrementViews(): void
    {
        $this->increment('views_count');
    }

    public function markAsSolved(ForumPost $solutionPost, User $solver): void
    {
        $this->update([
            'is_solved' => true,
            'solved_by_id' => $solver->id,
            'solved_at' => now(),
        ]);

        $solutionPost->update(['is_solution' => true]);
    }

    public function markAsUnsolved(): void
    {
        $this->update([
            'is_solved' => false,
            'solved_by_id' => null,
            'solved_at' => null,
        ]);

        // Remove solution from any posts
        $this->posts()->where('is_solution', true)->update(['is_solution' => false]);
    }

    public function updateCounts(): void
    {
        $this->update([
            'replies_count' => $this->activePosts()->count() - 1, // Exclude the first post
            'last_reply_at' => $this->activePosts()->max('created_at'),
        ]);
    }
}
