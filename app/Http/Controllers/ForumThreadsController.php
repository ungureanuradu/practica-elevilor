<?php

namespace App\Http\Controllers;

use App\Models\ForumCategory;
use App\Models\ForumThread;
use App\Models\ForumPost;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response;

class ForumThreadsController extends Controller
{
    /**
     * Display a listing of threads.
     */
    public function index(Request $request): Response
    {
        $query = ForumThread::with(['category', 'author', 'lastPost'])
            ->active();

        // Filter by category
        if ($request->filled('category')) {
            $query->byCategory($request->category);
        }

        // Filter by type
        if ($request->filled('type')) {
            $query->byType($request->type);
        }

        // Filter by author
        if ($request->filled('author')) {
            $query->byAuthor($request->author);
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
            });
        }

        // Sort
        $sort = $request->get('sort', 'latest');
        switch ($sort) {
            case 'popular':
                $query->popular();
                break;
            case 'replies':
                $query->orderBy('replies_count', 'desc');
                break;
            case 'views':
                $query->orderBy('views_count', 'desc');
                break;
            case 'latest':
            default:
                $query->recent();
                break;
        }

        $threads = $query->paginate(20)->withQueryString();

        $categories = ForumCategory::active()->ordered()->get();

        return Inertia::render('ForumThreads/Index', [
            'threads' => $threads,
            'categories' => $categories,
            'filters' => $request->only(['category', 'type', 'author', 'search', 'sort']),
        ]);
    }

    /**
     * Show the form for creating a new thread.
     */
    public function create(Request $request): Response
    {
        $categories = ForumCategory::active()->ordered()->get();
        $selectedCategory = $request->get('category');

        return Inertia::render('ForumThreads/Create', [
            'categories' => $categories,
            'selectedCategory' => $selectedCategory,
        ]);
    }

    /**
     * Store a newly created thread.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string|min:10',
            'category_id' => 'required|exists:forum_categories,id',
            'type' => 'required|in:discussion,question,announcement,sticky',
            'tags' => 'nullable|array',
            'tags.*' => 'string|max:50',
        ]);

        $user = auth()->user();
        $category = ForumCategory::findOrFail($request->category_id);

        // Check if user can create threads in this category
        if (!$category->canBeCreatedBy($user)) {
            return back()->withErrors(['category_id' => 'Nu aveți permisiunea să creați thread-uri în această categorie.']);
        }

        $thread = ForumThread::create([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'content' => $request->content,
            'type' => $request->type,
            'category_id' => $request->category_id,
            'author_id' => $user->id,
            'tags' => $request->tags,
        ]);

        // Create the first post
        ForumPost::create([
            'content' => $request->content,
            'thread_id' => $thread->id,
            'author_id' => $user->id,
        ]);

        // Update thread with last post info
        $thread->update([
            'last_post_id' => $thread->posts()->latest()->first()->id,
            'last_reply_at' => now(),
        ]);

        // Update category counts
        $category->updateCounts();

        return redirect()->route('forum-threads.show', $thread)
            ->with('success', 'Thread-ul a fost creat cu succes!');
    }

    /**
     * Display the specified thread.
     */
    public function show(ForumThread $thread): Response
    {
        // Check access
        if (!$thread->category->canBeAccessedBy(auth()->user())) {
            abort(403, 'Nu aveți acces la acest thread.');
        }

        // Increment views
        $thread->incrementViews();

        $thread->load(['category', 'author', 'posts.author', 'posts.replies.author']);

        // Get posts with pagination
        $posts = $thread->posts()
            ->with(['author', 'replies.author'])
            ->whereNull('parent_id') // Only top-level posts
            ->orderBy('created_at', 'asc')
            ->paginate(10);

        return Inertia::render('ForumThreads/Show', [
            'thread' => $thread,
            'posts' => $posts,
        ]);
    }

    /**
     * Show the form for editing the specified thread.
     */
    public function edit(ForumThread $thread): Response
    {
        if (!$thread->canBeEditedBy(auth()->user())) {
            abort(403, 'Nu aveți permisiunea să editați acest thread.');
        }

        $categories = ForumCategory::active()->ordered()->get();

        return Inertia::render('ForumThreads/Edit', [
            'thread' => $thread,
            'categories' => $categories,
        ]);
    }

    /**
     * Update the specified thread.
     */
    public function update(Request $request, ForumThread $thread)
    {
        if (!$thread->canBeEditedBy(auth()->user())) {
            abort(403, 'Nu aveți permisiunea să editați acest thread.');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string|min:10',
            'category_id' => 'required|exists:forum_categories,id',
            'type' => 'required|in:discussion,question,announcement,sticky',
            'tags' => 'nullable|array',
            'tags.*' => 'string|max:50',
        ]);

        $category = ForumCategory::findOrFail($request->category_id);

        // Check if user can create threads in this category
        if (!$category->canBeCreatedBy(auth()->user())) {
            return back()->withErrors(['category_id' => 'Nu aveți permisiunea să creați thread-uri în această categorie.']);
        }

        $thread->update([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'content' => $request->content,
            'category_id' => $request->category_id,
            'type' => $request->type,
            'tags' => $request->tags,
        ]);

        // Update the first post content
        $firstPost = $thread->posts()->orderBy('created_at', 'asc')->first();
        if ($firstPost) {
            $firstPost->update([
                'content' => $request->content,
                'is_edited' => true,
                'edited_by_id' => auth()->id(),
                'edited_at' => now(),
            ]);
        }

        return redirect()->route('forum-threads.show', $thread)
            ->with('success', 'Thread-ul a fost actualizat cu succes!');
    }

    /**
     * Remove the specified thread.
     */
    public function destroy(ForumThread $thread)
    {
        if (!$thread->canBeDeletedBy(auth()->user())) {
            abort(403, 'Nu aveți permisiunea să ștergeți acest thread.');
        }

        $category = $thread->category;
        $thread->delete();

        // Update category counts
        $category->updateCounts();

        return redirect()->route('forum.index')
            ->with('success', 'Thread-ul a fost șters cu succes!');
    }

    /**
     * Like/unlike a thread.
     */
    public function like(ForumThread $thread)
    {
        $user = auth()->user();

        $existingLike = $thread->likes()->where('user_id', $user->id)->first();

        if ($existingLike) {
            $existingLike->delete();
            $thread->decrement('likes_count');
            $message = 'Like-ul a fost eliminat.';
        } else {
            $thread->likes()->create(['user_id' => $user->id]);
            $thread->increment('likes_count');
            $message = 'Thread-ul a fost apreciat!';
        }

        return back()->with('success', $message);
    }

    /**
     * Bookmark/unbookmark a thread.
     */
    public function bookmark(ForumThread $thread, Request $request)
    {
        $user = auth()->user();

        $existingBookmark = $thread->bookmarks()->where('user_id', $user->id)->first();

        if ($existingBookmark) {
            $existingBookmark->delete();
            $message = 'Bookmark-ul a fost eliminat.';
        } else {
            $thread->bookmarks()->create([
                'user_id' => $user->id,
                'notes' => $request->notes,
            ]);
            $message = 'Thread-ul a fost adăugat la bookmark-uri!';
        }

        return back()->with('success', $message);
    }

    /**
     * Mark thread as solved.
     */
    public function markAsSolved(ForumThread $thread, Request $request)
    {
        if (!$thread->canBeEditedBy(auth()->user())) {
            abort(403, 'Nu aveți permisiunea să marcați acest thread ca rezolvat.');
        }

        $request->validate([
            'post_id' => 'required|exists:forum_posts,id',
        ]);

        $post = ForumPost::findOrFail($request->post_id);

        if ($post->thread_id !== $thread->id) {
            return back()->withErrors(['post_id' => 'Post-ul nu aparține acestui thread.']);
        }

        // Mark thread as solved
        $thread->update([
            'is_solved' => true,
            'solved_by_id' => auth()->id(),
            'solved_at' => now(),
        ]);

        // Mark post as solution
        $post->markAsSolution();

        return back()->with('success', 'Thread-ul a fost marcat ca rezolvat!');
    }

    /**
     * Mark thread as unsolved.
     */
    public function markAsUnsolved(ForumThread $thread)
    {
        if (!$thread->canBeEditedBy(auth()->user())) {
            abort(403, 'Nu aveți permisiunea să marcați acest thread ca nerezolvat.');
        }

        $thread->update([
            'is_solved' => false,
            'solved_by_id' => null,
            'solved_at' => null,
        ]);

        // Remove solution from posts
        $thread->posts()->update(['is_solution' => false]);

        return back()->with('success', 'Thread-ul a fost marcat ca nerezolvat!');
    }
}
