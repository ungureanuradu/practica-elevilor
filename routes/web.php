<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\CoursesController;
use App\Http\Controllers\JobsController;
use App\Http\Controllers\JobApplicationController;
use App\Http\Controllers\DocumentsController;
use App\Http\Controllers\DocumentCategoriesController;
use App\Http\Controllers\ForumController;
use App\Http\Controllers\ForumThreadsController;
use App\Http\Controllers\ForumPostsController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\CalendarEventsController;
use App\Http\Controllers\CalendarCategoriesController;
use App\Http\Controllers\GroupsController;
use App\Http\Controllers\GroupMembersController;
use App\Http\Controllers\GroupTopicsController;
use App\Http\Controllers\MembersController;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
});

Route::get('/', fn () => Inertia::render('PublicHomePage'))->name('home');
Route::get('/dashboard', fn () => Inertia::render('DashboardHome'))
      ->middleware(['auth', 'verified'])
      ->name('dashboard');

// Legal pages
Route::get('/terms', fn () => Inertia::render('TermsOfService'))->name('terms.show');
Route::get('/policy', fn () => Inertia::render('PrivacyPolicy'))->name('policy.show');

// Public routes (for non-authenticated users)
Route::get('/members', [MembersController::class, 'index'])->name('members.index');
Route::get('/members/{user}', [MembersController::class, 'show'])->name('members.show');
Route::get('/courses', [CoursesController::class, 'index'])->name('courses.index');
Route::get('/courses/{course}', [CoursesController::class, 'show'])->name('courses.show');
Route::get('/forum', [ForumController::class, 'index'])->name('forum.index');
Route::get('/jobs', [JobsController::class, 'index'])->name('jobs.index');
Route::get('/jobs/{job}', [JobsController::class, 'show'])->name('jobs.show');

// Role-based routes for authenticated users
Route::middleware(['auth', 'verified'])->group(function () {
    // Teacher routes
    Route::prefix('teacher')->name('teacher.')->group(function () {
        Route::get('/dashboard', fn () => Inertia::render('Teacher/Dashboard'))->name('dashboard');
        Route::get('/members', [MembersController::class, 'index'])->name('members.index');
        Route::get('/members/{user}', [MembersController::class, 'show'])->name('members.show');
        Route::get('/courses', [CoursesController::class, 'index'])->name('courses.index');
        Route::get('/courses/create', [CoursesController::class, 'create'])->name('courses.create');
        Route::post('/courses', [CoursesController::class, 'store'])->name('courses.store');
        Route::get('/courses/{course}', [CoursesController::class, 'show'])->name('courses.show');
        Route::get('/courses/{course}/edit', [CoursesController::class, 'edit'])->name('courses.edit');
        Route::put('/courses/{course}', [CoursesController::class, 'update'])->name('courses.update');
        Route::delete('/courses/{course}', [CoursesController::class, 'destroy'])->name('courses.destroy');
        Route::get('/forum', [ForumController::class, 'index'])->name('forum.index');
        Route::get('/jobs', [JobsController::class, 'index'])->name('jobs.index');
        Route::get('/jobs/create', [JobsController::class, 'create'])->name('jobs.create');
        Route::post('/jobs', [JobsController::class, 'store'])->name('jobs.store');
        Route::get('/jobs/{job}', [JobsController::class, 'show'])->name('jobs.show');
        Route::get('/jobs/{job}/edit', [JobsController::class, 'edit'])->name('jobs.edit');
        Route::put('/jobs/{job}', [JobsController::class, 'update'])->name('jobs.update');
        Route::delete('/jobs/{job}', [JobsController::class, 'destroy'])->name('jobs.destroy');
        Route::get('/documents', [DocumentsController::class, 'index'])->name('documents.index');
        Route::get('/documents/create', [DocumentsController::class, 'create'])->name('documents.create');
        Route::post('/documents', [DocumentsController::class, 'store'])->name('documents.store');
        Route::get('/documents/{document}', [DocumentsController::class, 'show'])->name('documents.show');
        Route::get('/documents/{document}/edit', [DocumentsController::class, 'edit'])->name('documents.edit');
        Route::put('/documents/{document}', [DocumentsController::class, 'update'])->name('documents.update');
        Route::delete('/documents/{document}', [DocumentsController::class, 'destroy'])->name('documents.destroy');
        Route::get('/calendar', [CalendarController::class, 'index'])->name('calendar.index');
        Route::get('/calendar-events/create', [CalendarEventsController::class, 'create'])->name('calendar-events.create');
        Route::post('/calendar-events', [CalendarEventsController::class, 'store'])->name('calendar-events.store');
        Route::get('/groups', [GroupsController::class, 'index'])->name('groups.index');
        Route::get('/groups/create', [GroupsController::class, 'create'])->name('groups.create');
        Route::post('/groups', [GroupsController::class, 'store'])->name('groups.store');
        Route::get('/groups/{group}', [GroupsController::class, 'show'])->name('groups.show');
        Route::get('/groups/{group}/edit', [GroupsController::class, 'edit'])->name('groups.edit');
        Route::put('/groups/{group}', [GroupsController::class, 'update'])->name('groups.update');
        Route::delete('/groups/{group}', [GroupsController::class, 'destroy'])->name('groups.destroy');
    });

    // Student routes
    Route::prefix('student')->name('student.')->group(function () {
        Route::get('/dashboard', fn () => Inertia::render('Student/Dashboard'))->name('dashboard');
        Route::get('/members', [MembersController::class, 'index'])->name('members.index');
        Route::get('/members/{user}', [MembersController::class, 'show'])->name('members.show');
        Route::get('/courses', [CoursesController::class, 'index'])->name('courses.index');
        Route::get('/courses/{course}', [CoursesController::class, 'show'])->name('courses.show');
        Route::get('/forum', [ForumController::class, 'index'])->name('forum.index');
        Route::get('/forum/threads/create', [ForumThreadsController::class, 'create'])->name('forum-threads.create');
        Route::post('/forum/threads', [ForumThreadsController::class, 'store'])->name('forum-threads.store');
        Route::get('/forum/threads/{thread}', [ForumThreadsController::class, 'show'])->name('forum-threads.show');
        Route::get('/forum/threads/{thread}/edit', [ForumThreadsController::class, 'edit'])->name('forum-threads.edit');
        Route::put('/forum/threads/{thread}', [ForumThreadsController::class, 'update'])->name('forum-threads.update');
        Route::delete('/forum/threads/{thread}', [ForumThreadsController::class, 'destroy'])->name('forum-threads.destroy');
        Route::get('/jobs', [JobsController::class, 'index'])->name('jobs.index');
        Route::get('/jobs/{job}', [JobsController::class, 'show'])->name('jobs.show');
        Route::post('/jobs/{job}/apply', [JobApplicationController::class, 'store'])->name('jobs.apply');
        Route::get('/my-applications', [JobApplicationController::class, 'myApplications'])->name('applications.my');
        Route::get('/documents', [DocumentsController::class, 'index'])->name('documents.index');
        Route::get('/documents/{document}', [DocumentsController::class, 'show'])->name('documents.show');
        Route::get('/calendar', [CalendarController::class, 'index'])->name('calendar.index');
        Route::get('/calendar-events/{event}', [CalendarEventsController::class, 'show'])->name('calendar-events.show');
        Route::get('/groups', [GroupsController::class, 'index'])->name('groups.index');
        Route::get('/groups/{group}', [GroupsController::class, 'show'])->name('groups.show');
        Route::post('/groups/{group}/join', [GroupsController::class, 'join'])->name('groups.join');
        Route::post('/groups/{group}/leave', [GroupsController::class, 'leave'])->name('groups.leave');
    });

    // Company routes
    Route::prefix('company')->name('company.')->group(function () {
        Route::get('/dashboard', fn () => Inertia::render('Company/Dashboard'))->name('dashboard');
        Route::get('/members', [MembersController::class, 'index'])->name('members.index');
        Route::get('/members/{user}', [MembersController::class, 'show'])->name('members.show');
        Route::get('/courses', [CoursesController::class, 'index'])->name('courses.index');
        Route::get('/courses/{course}', [CoursesController::class, 'show'])->name('courses.show');
        Route::get('/forum', [ForumController::class, 'index'])->name('forum.index');
        Route::get('/jobs', [JobsController::class, 'index'])->name('jobs.index');
        Route::get('/jobs/create', [JobsController::class, 'create'])->name('jobs.create');
        Route::post('/jobs', [JobsController::class, 'store'])->name('jobs.store');
        Route::get('/jobs/{job}', [JobsController::class, 'show'])->name('jobs.show');
        Route::get('/jobs/{job}/edit', [JobsController::class, 'edit'])->name('jobs.edit');
        Route::put('/jobs/{job}', [JobsController::class, 'update'])->name('jobs.update');
        Route::delete('/jobs/{job}', [JobsController::class, 'destroy'])->name('jobs.destroy');
        Route::get('/jobs/{job}/applications', [JobsController::class, 'applications'])->name('jobs.applications');
        Route::get('/received-applications', [JobApplicationController::class, 'receivedApplications'])->name('applications.received');
        Route::put('/applications/{application}', [JobApplicationController::class, 'update'])->name('applications.update');
        Route::post('/applications/{application}/review', [JobApplicationController::class, 'review'])->name('applications.review');
        Route::post('/applications/{application}/shortlist', [JobApplicationController::class, 'shortlist'])->name('applications.shortlist');
        Route::post('/applications/{application}/interview', [JobApplicationController::class, 'scheduleInterview'])->name('applications.interview');
        Route::post('/applications/{application}/accept', [JobApplicationController::class, 'accept'])->name('applications.accept');
        Route::get('/calendar', [CalendarController::class, 'index'])->name('calendar.index');
        Route::get('/calendar-events/create', [CalendarEventsController::class, 'create'])->name('calendar-events.create');
        Route::post('/calendar-events', [CalendarEventsController::class, 'store'])->name('calendar-events.store');
    });
});

// Members routes
Route::get('/members', [MembersController::class, 'index'])->name('members.index');
Route::get('/members/{user}', [MembersController::class, 'show'])->name('members.show');

// Courses routes
Route::get('/courses', [CoursesController::class, 'index'])->name('courses.index');
Route::get('/courses/create', [CoursesController::class, 'create'])->middleware(['auth', 'verified'])->name('courses.create');
Route::post('/courses', [CoursesController::class, 'store'])->middleware(['auth', 'verified'])->name('courses.store');
Route::get('/courses/{course}', [CoursesController::class, 'show'])->name('courses.show');
Route::get('/courses/{course}/edit', [CoursesController::class, 'edit'])->middleware(['auth', 'verified'])->name('courses.edit');
Route::put('/courses/{course}', [CoursesController::class, 'update'])->middleware(['auth', 'verified'])->name('courses.update');
Route::delete('/courses/{course}', [CoursesController::class, 'destroy'])->middleware(['auth', 'verified'])->name('courses.destroy');
Route::post('/courses/{course}/publish', [CoursesController::class, 'publish'])->middleware(['auth', 'verified'])->name('courses.publish');
Route::post('/courses/{course}/unpublish', [CoursesController::class, 'unpublish'])->middleware(['auth', 'verified'])->name('courses.unpublish');

// Forum routes
Route::get('/forum', [ForumController::class, 'index'])->name('forum.index');
Route::get('/forum/search', [ForumController::class, 'search'])->name('forum.search');
Route::get('/forum/my-activity', [ForumController::class, 'myActivity'])->middleware(['auth', 'verified'])->name('forum.my-activity');
Route::get('/forum/categories/{category}', [ForumController::class, 'category'])->name('forum.category');

// Forum Threads routes
Route::get('/forum/threads', [ForumThreadsController::class, 'index'])->name('forum-threads.index');
Route::get('/forum/threads/create', [ForumThreadsController::class, 'create'])->middleware(['auth', 'verified'])->name('forum-threads.create');
Route::post('/forum/threads', [ForumThreadsController::class, 'store'])->middleware(['auth', 'verified'])->name('forum-threads.store');
Route::get('/forum/threads/{thread}', [ForumThreadsController::class, 'show'])->name('forum-threads.show');
Route::get('/forum/threads/{thread}/edit', [ForumThreadsController::class, 'edit'])->middleware(['auth', 'verified'])->name('forum-threads.edit');
Route::put('/forum/threads/{thread}', [ForumThreadsController::class, 'update'])->middleware(['auth', 'verified'])->name('forum-threads.update');
Route::delete('/forum/threads/{thread}', [ForumThreadsController::class, 'destroy'])->middleware(['auth', 'verified'])->name('forum-threads.destroy');
Route::post('/forum/threads/{thread}/like', [ForumThreadsController::class, 'like'])->middleware(['auth', 'verified'])->name('forum-threads.like');
Route::post('/forum/threads/{thread}/bookmark', [ForumThreadsController::class, 'bookmark'])->middleware(['auth', 'verified'])->name('forum-threads.bookmark');
Route::post('/forum/threads/{thread}/mark-solved', [ForumThreadsController::class, 'markAsSolved'])->middleware(['auth', 'verified'])->name('forum-threads.mark-solved');
Route::post('/forum/threads/{thread}/mark-unsolved', [ForumThreadsController::class, 'markAsUnsolved'])->middleware(['auth', 'verified'])->name('forum-threads.mark-unsolved');

// Forum Posts routes
Route::get('/forum/posts', [ForumPostsController::class, 'index'])->name('forum-posts.index');
Route::get('/forum/posts/create', [ForumPostsController::class, 'create'])->middleware(['auth', 'verified'])->name('forum-posts.create');
Route::post('/forum/posts', [ForumPostsController::class, 'store'])->middleware(['auth', 'verified'])->name('forum-posts.store');
Route::get('/forum/posts/{post}', [ForumPostsController::class, 'show'])->name('forum-posts.show');
Route::get('/forum/posts/{post}/edit', [ForumPostsController::class, 'edit'])->middleware(['auth', 'verified'])->name('forum-posts.edit');
Route::put('/forum/posts/{post}', [ForumPostsController::class, 'update'])->middleware(['auth', 'verified'])->name('forum-posts.update');
Route::delete('/forum/posts/{post}', [ForumPostsController::class, 'destroy'])->middleware(['auth', 'verified'])->name('forum-posts.destroy');
Route::post('/forum/posts/{post}/like', [ForumPostsController::class, 'like'])->middleware(['auth', 'verified'])->name('forum-posts.like');
Route::post('/forum/posts/{post}/bookmark', [ForumPostsController::class, 'bookmark'])->middleware(['auth', 'verified'])->name('forum-posts.bookmark');
Route::post('/forum/posts/{post}/mark-solution', [ForumPostsController::class, 'markAsSolution'])->middleware(['auth', 'verified'])->name('forum-posts.mark-solution');
Route::post('/forum/posts/{post}/unmark-solution', [ForumPostsController::class, 'unmarkAsSolution'])->middleware(['auth', 'verified'])->name('forum-posts.unmark-solution');

// Documents routes
Route::get('/documents', [DocumentsController::class, 'index'])->name('documents.index');
Route::get('/documents/create', [DocumentsController::class, 'create'])->middleware(['auth', 'verified'])->name('documents.create');
Route::post('/documents', [DocumentsController::class, 'store'])->middleware(['auth', 'verified'])->name('documents.store');
Route::get('/documents/{document}', [DocumentsController::class, 'show'])->name('documents.show');
Route::get('/documents/{document}/edit', [DocumentsController::class, 'edit'])->middleware(['auth', 'verified'])->name('documents.edit');
Route::put('/documents/{document}', [DocumentsController::class, 'update'])->middleware(['auth', 'verified'])->name('documents.update');
Route::delete('/documents/{document}', [DocumentsController::class, 'destroy'])->middleware(['auth', 'verified'])->name('documents.destroy');
Route::get('/documents/{document}/download', [DocumentsController::class, 'download'])->name('documents.download');
Route::get('/documents/{document}/preview', [DocumentsController::class, 'preview'])->name('documents.preview');
Route::post('/documents/{document}/approve', [DocumentsController::class, 'approve'])->middleware(['auth', 'verified'])->name('documents.approve');
Route::get('/my-documents', [DocumentsController::class, 'myDocuments'])->middleware(['auth', 'verified'])->name('documents.my');
Route::get('/documents/pending-approval', [DocumentsController::class, 'pendingApproval'])->middleware(['auth', 'verified'])->name('documents.pending-approval');

// Document Categories routes
Route::get('/document-categories', [DocumentCategoriesController::class, 'index'])->name('document-categories.index');
Route::get('/document-categories/create', [DocumentCategoriesController::class, 'create'])->middleware(['auth', 'verified'])->name('document-categories.create');
Route::post('/document-categories', [DocumentCategoriesController::class, 'store'])->middleware(['auth', 'verified'])->name('document-categories.store');
Route::get('/document-categories/{category}', [DocumentCategoriesController::class, 'show'])->name('document-categories.show');
Route::get('/document-categories/{category}/edit', [DocumentCategoriesController::class, 'edit'])->middleware(['auth', 'verified'])->name('document-categories.edit');
Route::put('/document-categories/{category}', [DocumentCategoriesController::class, 'update'])->middleware(['auth', 'verified'])->name('document-categories.update');
Route::delete('/document-categories/{category}', [DocumentCategoriesController::class, 'destroy'])->middleware(['auth', 'verified'])->name('document-categories.destroy');

// Jobs routes
Route::get('/jobs', [JobsController::class, 'index'])->name('jobs.index');
Route::get('/jobs/create', [JobsController::class, 'create'])->middleware(['auth', 'verified'])->name('jobs.create');
Route::post('/jobs', [JobsController::class, 'store'])->middleware(['auth', 'verified'])->name('jobs.store');
Route::get('/jobs/{job}', [JobsController::class, 'show'])->name('jobs.show');
Route::get('/jobs/{job}/edit', [JobsController::class, 'edit'])->middleware(['auth', 'verified'])->name('jobs.edit');
Route::put('/jobs/{job}', [JobsController::class, 'update'])->middleware(['auth', 'verified'])->name('jobs.update');
Route::delete('/jobs/{job}', [JobsController::class, 'destroy'])->middleware(['auth', 'verified'])->name('jobs.destroy');
Route::post('/jobs/{job}/pause', [JobsController::class, 'pause'])->middleware(['auth', 'verified'])->name('jobs.pause');
Route::post('/jobs/{job}/resume', [JobsController::class, 'resume'])->middleware(['auth', 'verified'])->name('jobs.resume');
Route::post('/jobs/{job}/close', [JobsController::class, 'close'])->middleware(['auth', 'verified'])->name('jobs.close');
Route::get('/jobs/{job}/applications', [JobsController::class, 'applications'])->middleware(['auth', 'verified'])->name('jobs.applications');

// Job Applications routes
Route::post('/jobs/{job}/apply', [JobApplicationController::class, 'store'])->middleware(['auth', 'verified'])->name('jobs.apply');
Route::get('/my-applications', [JobApplicationController::class, 'myApplications'])->middleware(['auth', 'verified'])->name('applications.my');
Route::get('/received-applications', [JobApplicationController::class, 'receivedApplications'])->middleware(['auth', 'verified'])->name('applications.received');
Route::put('/applications/{application}', [JobApplicationController::class, 'update'])->middleware(['auth', 'verified'])->name('applications.update');
Route::delete('/applications/{application}', [JobApplicationController::class, 'withdraw'])->middleware(['auth', 'verified'])->name('applications.withdraw');
Route::post('/applications/{application}/review', [JobApplicationController::class, 'review'])->middleware(['auth', 'verified'])->name('applications.review');
Route::post('/applications/{application}/shortlist', [JobApplicationController::class, 'shortlist'])->middleware(['auth', 'verified'])->name('applications.shortlist');
Route::post('/applications/{application}/interview', [JobApplicationController::class, 'scheduleInterview'])->middleware(['auth', 'verified'])->name('applications.interview');
Route::post('/applications/{application}/accept', [JobApplicationController::class, 'accept'])->middleware(['auth', 'verified'])->name('applications.accept');
Route::post('/applications/{application}/reject', [JobApplicationController::class, 'reject'])->middleware(['auth', 'verified'])->name('applications.reject');
Route::post('/applications/{application}/note', [JobApplicationController::class, 'addNote'])->middleware(['auth', 'verified'])->name('applications.note');

// News routes
Route::get('/news/{news}', [NewsController::class, 'show'])->name('news.show');

// Events routes
Route::get('/events/{event}', [EventController::class, 'show'])->name('events.show');

// Information routes (placeholder)
Route::get('/information', fn () => Inertia::render('Information/Index'))->name('information.index');
Route::get('/information/finding-employer', fn () => Inertia::render('Information/FindingEmployer'))->name('information.finding-employer');
Route::get('/information/employment-documents', fn () => Inertia::render('Information/EmploymentDocuments'))->name('information.employment-documents');
Route::get('/information/internship-guide', fn () => Inertia::render('Information/InternshipGuide'))->name('information.internship-guide');
Route::get('/information/communications', fn () => Inertia::render('Information/Communications'))->name('information.communications');
Route::get('/information/national-exams', fn () => Inertia::render('Information/NationalExams'))->name('information.national-exams');
Route::get('/information/educational-offer', fn () => Inertia::render('Information/EducationalOffer'))->name('information.educational-offer');
Route::get('/information/preparatory-class', fn () => Inertia::render('Information/PreparatoryClass'))->name('information.preparatory-class');
Route::get('/information/human-resources', fn () => Inertia::render('Information/HumanResources'))->name('information.human-resources');
Route::get('/information/schedule', fn () => Inertia::render('Information/Schedule'))->name('information.schedule');

// About routes (placeholder)
Route::get('/about/history', fn () => Inertia::render('About/History'))->name('about.history');
Route::get('/about/mission', fn () => Inertia::render('About/Mission'))->name('about.mission');
Route::get('/about/leadership', fn () => Inertia::render('About/Leadership'))->name('about.leadership');
Route::get('/about/gallery', fn () => Inertia::render('About/Gallery'))->name('about.gallery');

// Resources routes (placeholder)
Route::get('/resources/leadership', fn () => Inertia::render('Resources/Leadership'))->name('resources.leadership');
Route::get('/resources/departments', fn () => Inertia::render('Resources/Departments'))->name('resources.departments');
Route::get('/resources/teaching-staff', fn () => Inertia::render('Resources/TeachingStaff'))->name('resources.teaching-staff');
Route::get('/resources/auxiliary-staff', fn () => Inertia::render('Resources/AuxiliaryStaff'))->name('resources.auxiliary-staff');
Route::get('/resources/committees', fn () => Inertia::render('Resources/Committees'))->name('resources.committees');
Route::get('/resources/board', fn () => Inertia::render('Resources/Board'))->name('resources.board');
Route::get('/resources/student-council', fn () => Inertia::render('Resources/StudentCouncil'))->name('resources.student-council');
Route::get('/resources/parents-association', fn () => Inertia::render('Resources/ParentsAssociation'))->name('resources.parents-association');

// Groups routes
Route::get('/groups', [GroupsController::class, 'index'])->name('groups.index');
Route::get('/groups/create', [GroupsController::class, 'create'])->middleware(['auth', 'verified'])->name('groups.create');
Route::post('/groups', [GroupsController::class, 'store'])->middleware(['auth', 'verified'])->name('groups.store');
Route::get('/groups/{group}', [GroupsController::class, 'show'])->name('groups.show');
Route::get('/groups/{group}/edit', [GroupsController::class, 'edit'])->middleware(['auth', 'verified'])->name('groups.edit');
Route::put('/groups/{group}', [GroupsController::class, 'update'])->middleware(['auth', 'verified'])->name('groups.update');
Route::delete('/groups/{group}', [GroupsController::class, 'destroy'])->middleware(['auth', 'verified'])->name('groups.destroy');
Route::post('/groups/{group}/join', [GroupsController::class, 'join'])->middleware(['auth', 'verified'])->name('groups.join');
Route::post('/groups/{group}/leave', [GroupsController::class, 'leave'])->middleware(['auth', 'verified'])->name('groups.leave');
Route::get('/my-groups', [GroupsController::class, 'myGroups'])->middleware(['auth', 'verified'])->name('groups.my');

// Group Members routes
Route::get('/groups/{group}/members', [GroupMembersController::class, 'index'])->name('group-members.index');
Route::post('/groups/{group}/members', [GroupMembersController::class, 'store'])->middleware(['auth', 'verified'])->name('group-members.store');
Route::put('/groups/{group}/members/{member}', [GroupMembersController::class, 'update'])->middleware(['auth', 'verified'])->name('group-members.update');
Route::delete('/groups/{group}/members/{member}', [GroupMembersController::class, 'destroy'])->middleware(['auth', 'verified'])->name('group-members.destroy');
Route::post('/groups/{group}/members/{member}/approve', [GroupMembersController::class, 'approve'])->middleware(['auth', 'verified'])->name('group-members.approve');
Route::post('/groups/{group}/members/{member}/ban', [GroupMembersController::class, 'ban'])->middleware(['auth', 'verified'])->name('group-members.ban');

// Group Topics routes
Route::get('/groups/{group}/topics', [GroupTopicsController::class, 'index'])->name('group-topics.index');
Route::get('/groups/{group}/topics/create', [GroupTopicsController::class, 'create'])->middleware(['auth', 'verified'])->name('group-topics.create');
Route::post('/groups/{group}/topics', [GroupTopicsController::class, 'store'])->middleware(['auth', 'verified'])->name('group-topics.store');
Route::get('/groups/{group}/topics/{topic}', [GroupTopicsController::class, 'show'])->name('group-topics.show');
Route::get('/groups/{group}/topics/{topic}/edit', [GroupTopicsController::class, 'edit'])->middleware(['auth', 'verified'])->name('group-topics.edit');
Route::put('/groups/{group}/topics/{topic}', [GroupTopicsController::class, 'update'])->middleware(['auth', 'verified'])->name('group-topics.update');
Route::delete('/groups/{group}/topics/{topic}', [GroupTopicsController::class, 'destroy'])->middleware(['auth', 'verified'])->name('group-topics.destroy');

// Calendar routes
Route::get('/calendar', [CalendarController::class, 'index'])->name('calendar.index');
Route::get('/calendar/view', [CalendarController::class, 'view'])->name('calendar.view');
Route::get('/calendar/events', [CalendarController::class, 'events'])->name('calendar.events');
Route::get('/calendar/search', [CalendarController::class, 'search'])->name('calendar.search');
Route::get('/my-events', [CalendarController::class, 'myEvents'])->middleware(['auth', 'verified'])->name('calendar.my-events');

// Calendar Events routes
Route::get('/calendar-events', [CalendarEventsController::class, 'index'])->name('calendar-events.index');
Route::get('/calendar-events/create', [CalendarEventsController::class, 'create'])->middleware(['auth', 'verified'])->name('calendar-events.create');
Route::post('/calendar-events', [CalendarEventsController::class, 'store'])->middleware(['auth', 'verified'])->name('calendar-events.store');
Route::get('/calendar-events/{event}', [CalendarEventsController::class, 'show'])->name('calendar-events.show');
Route::get('/calendar-events/{event}/edit', [CalendarEventsController::class, 'edit'])->middleware(['auth', 'verified'])->name('calendar-events.edit');
Route::put('/calendar-events/{event}', [CalendarEventsController::class, 'update'])->middleware(['auth', 'verified'])->name('calendar-events.update');
Route::delete('/calendar-events/{event}', [CalendarEventsController::class, 'destroy'])->middleware(['auth', 'verified'])->name('calendar-events.destroy');
Route::post('/calendar-events/{event}/publish', [CalendarEventsController::class, 'publish'])->middleware(['auth', 'verified'])->name('calendar-events.publish');
Route::post('/calendar-events/{event}/cancel', [CalendarEventsController::class, 'cancel'])->middleware(['auth', 'verified'])->name('calendar-events.cancel');

// Calendar Categories routes
Route::get('/calendar-categories', [CalendarCategoriesController::class, 'index'])->name('calendar-categories.index');
Route::get('/calendar-categories/create', [CalendarCategoriesController::class, 'create'])->middleware(['auth', 'verified'])->name('calendar-categories.create');
Route::post('/calendar-categories', [CalendarCategoriesController::class, 'store'])->middleware(['auth', 'verified'])->name('calendar-categories.store');
Route::get('/calendar-categories/{category}', [CalendarCategoriesController::class, 'show'])->name('calendar-categories.show');
Route::get('/calendar-categories/{category}/edit', [CalendarCategoriesController::class, 'edit'])->middleware(['auth', 'verified'])->name('calendar-categories.edit');
Route::put('/calendar-categories/{category}', [CalendarCategoriesController::class, 'update'])->middleware(['auth', 'verified'])->name('calendar-categories.update');
Route::delete('/calendar-categories/{category}', [CalendarCategoriesController::class, 'destroy'])->middleware(['auth', 'verified'])->name('calendar-categories.destroy');