<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Course;
use App\Models\JobApplication;
use App\Models\GroupMember;
use App\Models\CalendarEvent;
use App\Models\ForumThread;
use App\Models\ForumPost;

class StudentDashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        // Get stats for the student dashboard
        $stats = [
            'enrolled_courses' => Course::published()->count(), // Total published courses available
            'registered_events' => CalendarEvent::published()->upcoming()->count(), // Upcoming events
            'job_applications' => JobApplication::where('applicant_id', $user->id)->count(),
            'group_memberships' => GroupMember::where('user_id', $user->id)
                ->where('status', 'active')
                ->count(),
        ];

        // Get recent activity
        $recentActivity = collect()
            ->merge(
                ForumThread::where('author_id', $user->id)
                    ->with('category')
                    ->latest()
                    ->limit(3)
                    ->get()
                    ->map(function($thread) {
                        return [
                            'id' => 'thread_' . $thread->id,
                            'title' => 'Ai creat un thread nou: ' . $thread->title,
                            'description' => 'În forumul: ' . ($thread->category->name ?? 'Forum'),
                            'created_at' => $thread->created_at,
                        ];
                    })
            )
            ->merge(
                ForumPost::where('author_id', $user->id)
                    ->with('thread.category')
                    ->latest()
                    ->limit(3)
                    ->get()
                    ->map(function($post) {
                        return [
                            'id' => 'post_' . $post->id,
                            'title' => 'Ai răspuns la: ' . $post->thread->title,
                            'description' => 'În forumul: ' . ($post->thread->category->name ?? 'Forum'),
                            'created_at' => $post->created_at,
                        ];
                    })
            )
            ->sortByDesc('created_at')
            ->take(5)
            ->values();

        return Inertia::render('Student/Dashboard', [
            'stats' => $stats,
            'recentActivity' => $recentActivity,
        ]);
    }
}
