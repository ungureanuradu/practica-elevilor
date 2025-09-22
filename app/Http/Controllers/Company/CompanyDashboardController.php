<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Job;
use App\Models\JobApplication;
use App\Models\CalendarEvent;

class CompanyDashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        // Get stats for the company dashboard
        $stats = [
            'active_jobs' => Job::where('company_id', $user->id)
                ->where('status', 'active')
                ->count(),
            'received_applications' => JobApplication::whereHas('job', function($query) use ($user) {
                $query->where('company_id', $user->id);
            })->count(),
            'shortlisted_candidates' => JobApplication::whereHas('job', function($query) use ($user) {
                $query->where('company_id', $user->id);
            })->where('status', 'shortlisted')->count(),
            'participating_events' => CalendarEvent::published()->upcoming()->count(), // Available events
        ];

        // Get recent activity
        $recentActivity = collect()
            ->merge(
                Job::where('company_id', $user->id)
                    ->latest()
                    ->limit(3)
                    ->get()
                    ->map(function($job) {
                        return [
                            'id' => 'job_' . $job->id,
                            'title' => 'Ai publicat jobul: ' . $job->title,
                            'description' => $job->description ? substr($job->description, 0, 100) . '...' : 'Fără descriere',
                            'created_at' => $job->created_at,
                        ];
                    })
            )
            ->merge(
                JobApplication::whereHas('job', function($query) use ($user) {
                    $query->where('company_id', $user->id);
                })
                ->with(['job', 'applicant'])
                ->latest()
                ->limit(3)
                ->get()
                ->map(function($application) {
                    return [
                        'id' => 'application_' . $application->id,
                        'title' => 'Aplicație nouă pentru: ' . $application->job->title,
                        'description' => 'De la: ' . $application->applicant->name,
                        'created_at' => $application->created_at,
                    ];
                })
            )
            ->sortByDesc('created_at')
            ->take(5)
            ->values();

        return Inertia::render('Company/Dashboard', [
            'stats' => $stats,
            'recentActivity' => $recentActivity,
        ]);
    }
}