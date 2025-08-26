<?php

namespace App\Http\Controllers;

use App\Models\ForumPost;
use App\Models\ForumThread;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ForumPostsController extends Controller
{
    /**
     * Display a listing of posts.
     */
    public function index(Request $request): Response
    {
        $query = ForumPost::with(['thread.category', 'author'])
            ->active();

        // Filter by thread
        if ($request->filled('thread')) {
            $query->where('thread_id', $request->thread);
        }

        // Filter by author
        if ($request->filled('author')) {
            $query->byAuthor($request->author);
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('content', 'like', "%{$search}%");
        }

        $posts = $query->orderBy('created_at', 'desc')->paginate(20)->withQueryString();

        return Inertia::render('ForumPosts/Index', [
            'posts' => $posts,
            'filters' => $request->only(['thread', 'author', 'search']),
        ]);
    }

    /**
     * Show the form for creating a new post.
     */
    public function create(Request $request): Response
    {
        $threadId = $request->get('thread');
        $parentId = $request->get('parent');
        
        $thread = null;
        $parentPost = null;

        if ($threadId) {
            $thread = ForumThread::findOrFail($threadId);
        }

        if ($parentId) {
            $parentPost = ForumPost::findOrFail($parentId);
        }

        return Inertia::render('ForumPosts/Create', [
            'thread' => $thread,
            'parentPost' => $parentPost,
        ]);
    }

    /**
     * Store a newly created post.
     */
    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required|string|min:5',
            'thread_id' => 'required|exists:forum_threads,id',
            'parent_id' => 'nullable|exists:forum_posts,id',
        ]);

        $user = auth()->user();
        $thread = ForumThread::findOrFail($request->thread_id);

        // Check if user can post in this thread
        if (!$thread->category->canBeAccessedBy($user)) {
            return back()->withErrors(['thread_id' => 'Nu aveți permisiunea să postați în acest thread.']);
        }

        // Check if thread is locked
        if ($thread->status === 'locked') {
            return back()->withErrors(['thread_id' => 'Acest thread este blocat și nu acceptă răspunsuri noi.']);
        }

        $post = ForumPost::create([
            'content' => $request->content,
            'thread_id' => $request->thread_id,
            'parent_id' => $request->parent_id,
            'author_id' => $user->id,
        ]);

        // Update thread with last post info
        $thread->update([
            'last_post_id' => $post->id,
            'last_reply_at' => now(),
            'replies_count' => $thread->posts()->whereNotNull('parent_id')->count(),
        ]);

        // Update category counts
        $thread->category->updateCounts();

        return redirect()->route('forum-threads.show', $thread)
            ->with('success', 'Răspunsul a fost postat cu succes!');
    }

    /**
     * Display the specified post.
     */
    public function show(ForumPost $post): Response
    {
        $post->load(['thread.category', 'author', 'replies.author']);

        return Inertia::render('ForumPosts/Show', [
            'post' => $post,
        ]);
    }

    /**
     * Show the form for editing the specified post.
     */
    public function edit(ForumPost $post): Response
    {
        if (!$post->canBeEditedBy(auth()->user())) {
            abort(403, 'Nu aveți permisiunea să editați acest post.');
        }

        return Inertia::render('ForumPosts/Edit', [
            'post' => $post,
        ]);
    }

    /**
     * Update the specified post.
     */
    public function update(Request $request, ForumPost $post)
    {
        if (!$post->canBeEditedBy(auth()->user())) {
            abort(403, 'Nu aveți permisiunea să editați acest post.');
        }

        $request->validate([
            'content' => 'required|string|min:5',
        ]);

        $post->update([
            'content' => $request->content,
            'is_edited' => true,
            'edited_by_id' => auth()->id(),
            'edited_at' => now(),
        ]);

        return redirect()->route('forum-threads.show', $post->thread)
            ->with('success', 'Post-ul a fost actualizat cu succes!');
    }

    /**
     * Remove the specified post.
     */
    public function destroy(ForumPost $post)
    {
        if (!$post->canBeDeletedBy(auth()->user())) {
            abort(403, 'Nu aveți permisiunea să ștergeți acest post.');
        }

        $thread = $post->thread;
        $category = $thread->category;

        // Delete replies first
        $post->replies()->delete();
        
        // Delete the post
        $post->delete();

        // Update thread counts
        $thread->update([
            'replies_count' => $thread->posts()->whereNotNull('parent_id')->count(),
        ]);

        // Update last post info if needed
        $lastPost = $thread->posts()->latest()->first();
        if ($lastPost) {
            $thread->update([
                'last_post_id' => $lastPost->id,
                'last_reply_at' => $lastPost->created_at,
            ]);
        } else {
            $thread->update([
                'last_post_id' => null,
                'last_reply_at' => null,
            ]);
        }

        // Update category counts
        $category->updateCounts();

        return redirect()->route('forum-threads.show', $thread)
            ->with('success', 'Post-ul a fost șters cu succes!');
    }

    /**
     * Like/unlike a post.
     */
    public function like(ForumPost $post)
    {
        $user = auth()->user();

        $existingLike = $post->likes()->where('user_id', $user->id)->first();

        if ($existingLike) {
            $existingLike->delete();
            $post->decrement('likes_count');
            $message = 'Like-ul a fost eliminat.';
        } else {
            $post->likes()->create(['user_id' => $user->id]);
            $post->increment('likes_count');
            $message = 'Post-ul a fost apreciat!';
        }

        return back()->with('success', $message);
    }

    /**
     * Bookmark/unbookmark a post.
     */
    public function bookmark(ForumPost $post, Request $request)
    {
        $user = auth()->user();

        $existingBookmark = $post->bookmarks()->where('user_id', $user->id)->first();

        if ($existingBookmark) {
            $existingBookmark->delete();
            $message = 'Bookmark-ul a fost eliminat.';
        } else {
            $post->bookmarks()->create([
                'user_id' => $user->id,
                'notes' => $request->notes,
            ]);
            $message = 'Post-ul a fost adăugat la bookmark-uri!';
        }

        return back()->with('success', $message);
    }

    /**
     * Mark post as solution.
     */
    public function markAsSolution(ForumPost $post)
    {
        if (!$post->canBeMarkedAsSolutionBy(auth()->user())) {
            abort(403, 'Nu aveți permisiunea să marcați acest post ca soluție.');
        }

        $post->markAsSolution();

        // Mark thread as solved
        $post->thread->update([
            'is_solved' => true,
            'solved_by_id' => auth()->id(),
            'solved_at' => now(),
        ]);

        return back()->with('success', 'Post-ul a fost marcat ca soluție!');
    }

    /**
     * Unmark post as solution.
     */
    public function unmarkAsSolution(ForumPost $post)
    {
        if (!$post->canBeMarkedAsSolutionBy(auth()->user())) {
            abort(403, 'Nu aveți permisiunea să eliminați marcația de soluție.');
        }

        $post->markAsUnsolution();

        // Mark thread as unsolved
        $post->thread->update([
            'is_solved' => false,
            'solved_by_id' => null,
            'solved_at' => null,
        ]);

        return back()->with('success', 'Marcația de soluție a fost eliminată!');
    }
}
