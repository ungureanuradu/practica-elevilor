<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\JobApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class JobApplicationController extends Controller
{
    /**
     * Apply for a job
     */
    public function store(Request $request, Job $job)
    {
        $this->authorize('apply', $job);

        // Check if user already applied
        if ($job->hasUserApplied(Auth::user())) {
            return back()->with('error', 'Ai aplicat deja pentru acest job!');
        }

        $validated = $request->validate([
            'cover_letter' => $job->cover_letter_required ? 'required|string|min:100' : 'nullable|string',
            'cv_file' => $job->cv_required ? 'required|file|mimes:pdf,doc,docx|max:2048' : 'nullable|file|mimes:pdf,doc,docx|max:2048',
            'portfolio_url' => 'nullable|url',
            'answers' => 'nullable|array',
        ]);

        // Handle CV upload
        $cvPath = null;
        if ($request->hasFile('cv_file')) {
            $cvPath = $request->file('cv_file')->store('applications/cv', 'public');
        } elseif ($job->cv_required) {
            // Use user's existing CV if available
            $cvPath = Auth::user()->cv_path;
        }

        $application = JobApplication::create([
            'job_id' => $job->id,
            'applicant_id' => Auth::id(),
            'cover_letter' => $validated['cover_letter'] ?? null,
            'cv_path' => $cvPath,
            'portfolio_url' => $validated['portfolio_url'] ?? null,
            'answers' => $validated['answers'] ?? null,
        ]);

        return redirect()->route('jobs.show', $job)
                        ->with('success', 'Aplicația ta a fost trimisă cu succes!');
    }

    /**
     * Show user's application
     */
    public function show(JobApplication $application)
    {
        $this->authorize('view', $application);

        $application->load(['job.company', 'applicant']);

        return view('job-applications.show', compact('application'));
    }

    /**
     * Update user's application
     */
    public function update(Request $request, JobApplication $application)
    {
        $this->authorize('update', $application);

        if (!$application->canBeUpdated()) {
            return back()->with('error', 'Aplicația nu mai poate fi actualizată!');
        }

        $validated = $request->validate([
            'cover_letter' => 'nullable|string|min:100',
            'cv_file' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
            'portfolio_url' => 'nullable|url',
        ]);

        // Handle CV upload
        if ($request->hasFile('cv_file')) {
            // Delete old CV if exists
            if ($application->cv_path) {
                Storage::disk('public')->delete($application->cv_path);
            }
            $validated['cv_path'] = $request->file('cv_file')->store('applications/cv', 'public');
        }

        $application->update($validated);

        return back()->with('success', 'Aplicația a fost actualizată cu succes!');
    }

    /**
     * Withdraw application
     */
    public function withdraw(JobApplication $application)
    {
        $this->authorize('withdraw', $application);

        if (!$application->canBeWithdrawn()) {
            return back()->with('error', 'Aplicația nu mai poate fi retrasă!');
        }

        $application->delete();

        return redirect()->route('jobs.show', $application->job)
                        ->with('success', 'Aplicația a fost retrasă cu succes!');
    }

    /**
     * Company actions on applications
     */
    public function review(JobApplication $application)
    {
        $this->authorize('review', $application);

        $application->markAsReviewed();

        return back()->with('success', 'Aplicația a fost marcată ca revizuită!');
    }

    public function shortlist(JobApplication $application)
    {
        $this->authorize('review', $application);

        $application->shortlist();

        return back()->with('success', 'Candidatul a fost adăugat pe lista scurtă!');
    }

    public function scheduleInterview(Request $request, JobApplication $application)
    {
        $this->authorize('review', $application);

        $validated = $request->validate([
            'interview_date' => 'required|date|after:today',
            'interview_time' => 'required|date_format:H:i',
        ]);

        $interviewDateTime = $validated['interview_date'] . ' ' . $validated['interview_time'];
        $application->scheduleInterview(new \DateTime($interviewDateTime));

        return back()->with('success', 'Interviul a fost programat cu succes!');
    }

    public function accept(JobApplication $application)
    {
        $this->authorize('review', $application);

        $application->accept();

        return back()->with('success', 'Candidatul a fost acceptat!');
    }

    public function reject(Request $request, JobApplication $application)
    {
        $this->authorize('review', $application);

        $validated = $request->validate([
            'feedback' => 'nullable|string|max:500',
        ]);

        $application->reject($validated['feedback'] ?? null);

        return back()->with('success', 'Candidatul a fost respins!');
    }

    public function addNote(Request $request, JobApplication $application)
    {
        $this->authorize('review', $application);

        $validated = $request->validate([
            'note' => 'required|string|max:500',
        ]);

        $application->addNote($validated['note']);

        return back()->with('success', 'Nota a fost adăugată!');
    }

    /**
     * Show user's applications
     */
    public function myApplications()
    {
        $applications = Auth::user()->jobApplications()
            ->with(['job.company'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('job-applications.my-applications', compact('applications'));
    }

    /**
     * Show company's received applications
     */
    public function receivedApplications()
    {
        $applications = JobApplication::whereHas('job', function($query) {
            $query->where('company_id', Auth::id());
        })
        ->with(['job', 'applicant'])
        ->orderBy('created_at', 'desc')
        ->paginate(20);

        return view('job-applications.received', compact('applications'));
    }
}
