<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Course;
use App\Models\User;
use App\Models\CalendarEvent;
use App\Models\Document;
use App\Models\ForumThread;
use App\Models\ForumPost;

class TeacherDashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        // Get stats for the teacher dashboard
        $stats = [
            'courses' => Course::where('instructor_id', $user->id)->count(),
            'students' => User::students()->count(), // Total students in the system
            'events' => CalendarEvent::where('organizer_id', $user->id)->count(),
            'documents' => Document::where('uploader_id', $user->id)->count(),
        ];

        // Get recent activity
        $recentActivity = collect()
            ->merge(
                Course::where('instructor_id', $user->id)
                    ->latest()
                    ->limit(3)
                    ->get()
                    ->map(function($course) {
                        return [
                            'id' => 'course_' . $course->id,
                            'title' => 'Ai creat cursul: ' . $course->title,
                            'description' => $course->description ? substr($course->description, 0, 100) . '...' : 'Fără descriere',
                            'created_at' => $course->created_at,
                        ];
                    })
            )
            ->merge(
                CalendarEvent::where('organizer_id', $user->id)
                    ->latest()
                    ->limit(3)
                    ->get()
                    ->map(function($event) {
                        return [
                            'id' => 'event_' . $event->id,
                            'title' => 'Ai organizat evenimentul: ' . $event->title,
                            'description' => $event->description ? substr($event->description, 0, 100) . '...' : 'Fără descriere',
                            'created_at' => $event->created_at,
                        ];
                    })
            )
            ->merge(
                Document::where('uploader_id', $user->id)
                    ->with('category')
                    ->latest()
                    ->limit(3)
                    ->get()
                    ->map(function($document) {
                        return [
                            'id' => 'document_' . $document->id,
                            'title' => 'Ai încărcat documentul: ' . $document->title,
                            'description' => 'În categoria: ' . ($document->category->name ?? 'Fără categorie'),
                            'created_at' => $document->created_at,
                        ];
                    })
            )
            ->sortByDesc('created_at')
            ->take(5)
            ->values();

        return Inertia::render('Teacher/Dashboard', [
            'stats' => $stats,
            'recentActivity' => $recentActivity,
        ]);
    }
}