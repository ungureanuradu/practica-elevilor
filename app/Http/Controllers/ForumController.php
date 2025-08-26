<?php

namespace App\Http\Controllers;

use App\Models\ForumCategory;
use App\Models\ForumThread;
use App\Models\ForumPost;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ForumController extends Controller
{
    /**
     * Display the forum overview.
     */
    public function index(): Response
    {
        $categories = ForumCategory::withCount(['threads'])
            ->active()
            ->ordered()
            ->get();

        $recentThreads = ForumThread::with(['category', 'author'])
            ->active()
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        $popularThreads = ForumThread::with(['category', 'author'])
            ->active()
            ->orderBy('views_count', 'desc')
            ->limit(5)
            ->get();

        $stats = [
            'total_threads' => ForumThread::active()->count(),
            'total_posts' => ForumPost::active()->count(),
            'total_categories' => ForumCategory::active()->count(),
        ];

        return Inertia::render('Forum/Index', [
            'categories' => $categories,
            'recentThreads' => $recentThreads,
            'popularThreads' => $popularThreads,
            'stats' => $stats,
        ]);
    }

    /**
     * Display threads in a specific category.
     */
    public function category(ForumCategory $category, Request $request): Response
    {
        if (!$category->canBeAccessedBy(auth()->user())) {
            abort(403, 'Nu aveți acces la această categorie.');
        }

        $query = ForumThread::with(['author', 'lastPost'])
            ->where('category_id', $category->id)
            ->active();

        // Filter by type
        if ($request->filled('type')) {
            $query->byType($request->type);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
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
                $query->orderBy('views_count', 'desc');
                break;
            case 'replies':
                $query->orderBy('replies_count', 'desc');
                break;
            case 'latest':
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }

        $threads = $query->paginate(20)->withQueryString();

        return Inertia::render('Forum/Category', [
            'category' => $category,
            'threads' => $threads,
            'filters' => $request->only(['type', 'status', 'search', 'sort']),
        ]);
    }

    /**
     * Search forum content.
     */
    public function search(Request $request): Response
    {
        $request->validate([
            'q' => 'required|string|min:3',
        ]);

        $query = $request->get('q');
        $type = $request->get('type', 'all');

        $results = collect();

        if ($type === 'all' || $type === 'threads') {
            $threads = ForumThread::with(['category', 'author'])
                ->active()
                ->where(function($q) use ($query) {
                    $q->where('title', 'like', "%{$query}%")
                      ->orWhere('content', 'like', "%{$query}%");
                })
                ->orderBy('created_at', 'desc')
                ->limit(10)
                ->get();

            $results = $results->merge($threads->map(function($thread) {
                $thread->type = 'thread';
                return $thread;
            }));
        }

        if ($type === 'all' || $type === 'posts') {
            $posts = ForumPost::with(['thread.category', 'author'])
                ->active()
                ->where('content', 'like', "%{$query}%")
                ->orderBy('created_at', 'desc')
                ->limit(10)
                ->get();

            $results = $results->merge($posts->map(function($post) {
                $post->type = 'post';
                return $post;
            }));
        }

        // Sort by relevance (simple implementation)
        $results = $results->sortByDesc('created_at')->take(20);

        return Inertia::render('Forum/Search', [
            'query' => $query,
            'results' => $results,
            'type' => $type,
        ]);
    }

    /**
     * Display user's forum activity.
     */
    public function myActivity(): Response
    {
        $user = auth()->user();

        $myThreads = ForumThread::with(['category'])
            ->where('author_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        $myPosts = ForumPost::with(['thread.category'])
            ->where('author_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        $likedThreads = $user->forumLikes()
            ->where('likeable_type', ForumThread::class)
            ->with(['likeable.category', 'likeable.author'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get()
            ->pluck('likeable');

        $bookmarkedThreads = $user->forumBookmarks()
            ->where('bookmarkable_type', ForumThread::class)
            ->with(['bookmarkable.category', 'bookmarkable.author'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get()
            ->pluck('bookmarkable');

        return Inertia::render('Forum/MyActivity', [
            'myThreads' => $myThreads,
            'myPosts' => $myPosts,
            'likedThreads' => $likedThreads,
            'bookmarkedThreads' => $bookmarkedThreads,
        ]);
    }
}
