<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\JobApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class JobsController extends Controller
{
    /**
     * Display a listing of jobs
     */
    public function index(Request $request)
    {
        $query = Job::with(['company']);

        // Filter by status
        if ($request->has('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        } else {
            $query->active()->published()->notExpired();
        }

        // Filter by type
        if ($request->has('type') && $request->type !== 'all') {
            $query->byType($request->type);
        }

        // Filter by level
        if ($request->has('level') && $request->level !== 'all') {
            $query->byLevel($request->level);
        }

        // Filter by location
        if ($request->has('location') && !empty($request->location)) {
            $query->byLocation($request->location);
        }

        // Filter by remote/hybrid
        if ($request->has('work_type')) {
            switch ($request->work_type) {
                case 'remote':
                    $query->remote();
                    break;
                case 'hybrid':
                    $query->hybrid();
                    break;
            }
        }

        // Search
        if ($request->has('search') && !empty($request->search)) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('title', 'like', "%{$searchTerm}%")
                  ->orWhere('description', 'like', "%{$searchTerm}%")
                  ->orWhere('requirements', 'like', "%{$searchTerm}%")
                  ->orWhere('location', 'like', "%{$searchTerm}%");
            });
        }

        // Sort
        $sortBy = $request->get('sort', 'published_at');
        $sortOrder = $request->get('order', 'desc');
        
        if (in_array($sortBy, ['title', 'created_at', 'published_at', 'salary_min'])) {
            $query->orderBy($sortBy, $sortOrder);
        } else {
            $query->orderBy('published_at', 'desc');
        }

        $jobs = $query->paginate(12);

        return Inertia::render('Jobs/Index', [
            'jobs' => $jobs,
            'filters' => [
                'status' => $request->get('status', 'active'),
                'type' => $request->get('type', 'all'),
                'level' => $request->get('level', 'all'),
                'location' => $request->get('location', ''),
                'work_type' => $request->get('work_type', 'all'),
                'search' => $request->get('search', ''),
                'sort' => $request->get('sort', 'published_at'),
                'order' => $request->get('order', 'desc'),
            ],
            'stats' => [
                'total' => Job::active()->published()->count(),
                'internships' => Job::active()->published()->byType('internship')->count(),
                'full_time' => Job::active()->published()->byType('full-time')->count(),
                'remote' => Job::active()->published()->remote()->count(),
            ]
        ]);
    }

    /**
     * Show the form for creating a new job
     */
    public function create()
    {
        $this->authorize('create', Job::class);

        return Inertia::render('Jobs/Create');
    }

    /**
     * Store a newly created job
     */
    public function store(Request $request)
    {
        $this->authorize('create', Job::class);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'requirements' => 'nullable|string',
            'benefits' => 'nullable|string',
            'type' => 'required|in:full-time,part-time,internship,mentorship,freelance',
            'level' => 'required|in:entry,junior,mid,senior',
            'location' => 'nullable|string|max:255',
            'remote_ok' => 'boolean',
            'hybrid_ok' => 'boolean',
            'salary_min' => 'nullable|numeric|min:0',
            'salary_max' => 'nullable|numeric|min:0|gte:salary_min',
            'salary_currency' => 'required|string|size:3',
            'salary_negotiable' => 'boolean',
            'skills_required' => 'nullable|array',
            'skills_preferred' => 'nullable|array',
            'positions_available' => 'required|integer|min:1',
            'application_deadline' => 'nullable|date|after:today',
            'start_date' => 'nullable|date|after:today',
            'contact_email' => 'nullable|email',
            'contact_phone' => 'nullable|string',
            'application_url' => 'nullable|url',
            'cv_required' => 'boolean',
            'cover_letter_required' => 'boolean',
            'application_instructions' => 'nullable|string',
        ]);

        $validated['company_id'] = Auth::id();
        $validated['status'] = 'active';
        $validated['published_at'] = now();

        $job = Job::create($validated);

        return redirect()->route('jobs.show', $job)
                        ->with('success', 'Jobul a fost creat cu succes!');
    }

    /**
     * Display the specified job
     */
    public function show(Job $job)
    {
        $job->load(['company', 'applications']);

        $userApplication = null;
        if (Auth::check()) {
            $userApplication = $job->getUserApplication(Auth::user());
        }

        return Inertia::render('Jobs/Show', [
            'job' => $job,
            'userApplication' => $userApplication,
            'canEdit' => Auth::user()?->id === $job->company_id,
            'canApply' => Auth::check() && Auth::user()->isStudent() && $job->canBeAppliedTo() && !$job->hasUserApplied(Auth::user()),
        ]);
    }

    /**
     * Show the form for editing the specified job
     */
    public function edit(Job $job)
    {
        $this->authorize('update', $job);

        return Inertia::render('Jobs/Edit', [
            'job' => $job,
        ]);
    }

    /**
     * Update the specified job
     */
    public function update(Request $request, Job $job)
    {
        $this->authorize('update', $job);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'requirements' => 'nullable|string',
            'benefits' => 'nullable|string',
            'type' => 'required|in:full-time,part-time,internship,mentorship,freelance',
            'level' => 'required|in:entry,junior,mid,senior',
            'location' => 'nullable|string|max:255',
            'remote_ok' => 'boolean',
            'hybrid_ok' => 'boolean',
            'salary_min' => 'nullable|numeric|min:0',
            'salary_max' => 'nullable|numeric|min:0|gte:salary_min',
            'salary_currency' => 'required|string|size:3',
            'salary_negotiable' => 'boolean',
            'skills_required' => 'nullable|array',
            'skills_preferred' => 'nullable|array',
            'positions_available' => 'required|integer|min:1',
            'application_deadline' => 'nullable|date|after:today',
            'start_date' => 'nullable|date|after:today',
            'contact_email' => 'nullable|email',
            'contact_phone' => 'nullable|string',
            'application_url' => 'nullable|url',
            'cv_required' => 'boolean',
            'cover_letter_required' => 'boolean',
            'application_instructions' => 'nullable|string',
        ]);

        $job->update($validated);

        return redirect()->route('jobs.show', $job)
                        ->with('success', 'Jobul a fost actualizat cu succes!');
    }

    /**
     * Remove the specified job
     */
    public function destroy(Job $job)
    {
        $this->authorize('delete', $job);

        $job->delete();

        return redirect()->route('jobs.index')
                        ->with('success', 'Jobul a fost șters cu succes!');
    }

    /**
     * Pause a job
     */
    public function pause(Job $job)
    {
        $this->authorize('update', $job);

        $job->update(['status' => 'paused']);

        return back()->with('success', 'Jobul a fost pus pe pauză!');
    }

    /**
     * Resume a job
     */
    public function resume(Job $job)
    {
        $this->authorize('update', $job);

        $job->update(['status' => 'active']);

        return back()->with('success', 'Jobul a fost reactivat!');
    }

    /**
     * Close a job
     */
    public function close(Job $job)
    {
        $this->authorize('update', $job);

        $job->update(['status' => 'closed']);

        return back()->with('success', 'Jobul a fost închis!');
    }

    /**
     * Show job applications for a company
     */
    public function applications(Job $job)
    {
        $this->authorize('viewApplications', $job);

        $applications = $job->applications()
            ->with(['applicant'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return Inertia::render('Jobs/Applications', [
            'job' => $job,
            'applications' => $applications,
        ]);
    }
}
