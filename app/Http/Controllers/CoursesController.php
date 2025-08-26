<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Chapter;
use App\Models\Module;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class CoursesController extends Controller
{
    /**
     * Display a listing of courses
     */
    public function index(Request $request)
    {
        $query = Course::with(['instructor', 'chapters']);

        // Filter by status
        if ($request->has('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        } else {
            $query->published(); // Show only published courses by default
        }

        // Filter by level
        if ($request->has('level') && $request->level !== 'all') {
            $query->byLevel($request->level);
        }

        // Filter by price
        if ($request->has('price') && $request->price === 'free') {
            $query->free();
        } elseif ($request->has('price') && $request->price === 'paid') {
            $query->paid();
        }

        // Search
        if ($request->has('search') && !empty($request->search)) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('title', 'like', "%{$searchTerm}%")
                  ->orWhere('description', 'like', "%{$searchTerm}%")
                  ->orWhere('excerpt', 'like', "%{$searchTerm}%");
            });
        }

        // Sort
        $sortBy = $request->get('sort', 'created_at');
        $sortOrder = $request->get('order', 'desc');
        
        if (in_array($sortBy, ['title', 'created_at', 'published_at', 'price'])) {
            $query->orderBy($sortBy, $sortOrder);
        } else {
            $query->orderBy('created_at', 'desc');
        }

        $courses = $query->paginate(12);

        return Inertia::render('Courses/Index', [
            'courses' => $courses,
            'filters' => [
                'status' => $request->get('status', 'published'),
                'level' => $request->get('level', 'all'),
                'price' => $request->get('price', 'all'),
                'search' => $request->get('search', ''),
                'sort' => $request->get('sort', 'created_at'),
                'order' => $request->get('order', 'desc'),
            ],
            'stats' => [
                'total' => Course::published()->count(),
                'free' => Course::published()->free()->count(),
                'paid' => Course::published()->paid()->count(),
            ]
        ]);
    }

    /**
     * Show the form for creating a new course
     */
    public function create()
    {
        $this->authorize('create', Course::class);

        return Inertia::render('Courses/Create');
    }

    /**
     * Store a newly created course
     */
    public function store(Request $request)
    {
        $this->authorize('create', Course::class);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'excerpt' => 'nullable|string|max:500',
            'level' => 'required|in:beginner,intermediate,advanced',
            'duration_hours' => 'nullable|integer|min:0',
            'max_students' => 'nullable|integer|min:1',
            'price' => 'nullable|numeric|min:0',
            'is_free' => 'boolean',
            'tags' => 'nullable|array',
            'requirements' => 'nullable|array',
            'learning_outcomes' => 'nullable|array',
            'thumbnail' => 'nullable|image|max:2048',
        ]);

        // Handle thumbnail upload
        if ($request->hasFile('thumbnail')) {
            $validated['thumbnail'] = $request->file('thumbnail')->store('courses/thumbnails', 'public');
        }

        $validated['instructor_id'] = Auth::id();
        $validated['status'] = 'draft';

        $course = Course::create($validated);

        return redirect()->route('courses.show', $course)
                        ->with('success', 'Cursul a fost creat cu succes!');
    }

    /**
     * Display the specified course
     */
    public function show(Course $course)
    {
        $course->load(['instructor', 'chapters.modules']);

        return Inertia::render('Courses/Show', [
            'course' => $course,
            'canEdit' => Auth::user()?->id === $course->instructor_id,
            'canAccess' => $course->canBeAccessedBy(Auth::user()),
        ]);
    }

    /**
     * Show the form for editing the specified course
     */
    public function edit(Course $course)
    {
        $this->authorize('update', $course);

        $course->load(['chapters.modules']);

        return Inertia::render('Courses/Edit', [
            'course' => $course,
        ]);
    }

    /**
     * Update the specified course
     */
    public function update(Request $request, Course $course)
    {
        $this->authorize('update', $course);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'excerpt' => 'nullable|string|max:500',
            'level' => 'required|in:beginner,intermediate,advanced',
            'duration_hours' => 'nullable|integer|min:0',
            'max_students' => 'nullable|integer|min:1',
            'price' => 'nullable|numeric|min:0',
            'is_free' => 'boolean',
            'tags' => 'nullable|array',
            'requirements' => 'nullable|array',
            'learning_outcomes' => 'nullable|array',
            'thumbnail' => 'nullable|image|max:2048',
        ]);

        // Handle thumbnail upload
        if ($request->hasFile('thumbnail')) {
            // Delete old thumbnail
            if ($course->thumbnail) {
                Storage::disk('public')->delete($course->thumbnail);
            }
            $validated['thumbnail'] = $request->file('thumbnail')->store('courses/thumbnails', 'public');
        }

        $course->update($validated);

        return redirect()->route('courses.show', $course)
                        ->with('success', 'Cursul a fost actualizat cu succes!');
    }

    /**
     * Remove the specified course
     */
    public function destroy(Course $course)
    {
        $this->authorize('delete', $course);

        // Delete thumbnail
        if ($course->thumbnail) {
            Storage::disk('public')->delete($course->thumbnail);
        }

        $course->delete();

        return redirect()->route('courses.index')
                        ->with('success', 'Cursul a fost șters cu succes!');
    }

    /**
     * Publish a course
     */
    public function publish(Course $course)
    {
        $this->authorize('update', $course);

        $course->update([
            'status' => 'published',
            'published_at' => now(),
        ]);

        return back()->with('success', 'Cursul a fost publicat cu succes!');
    }

    /**
     * Unpublish a course
     */
    public function unpublish(Course $course)
    {
        $this->authorize('update', $course);

        $course->update([
            'status' => 'draft',
            'published_at' => null,
        ]);

        return back()->with('success', 'Cursul a fost retras din publicare!');
    }
}
