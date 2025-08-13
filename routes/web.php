<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\NewsController;  // ← ADAUGĂ ASTA dacă lipsește!
use App\Http\Controllers\EventController;

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

Route::get('/',            fn () => Inertia::render('PublicHomePage'))->name('home');
Route::get('/dashboard',   fn () => Inertia::render('DashboardHome'))
      ->middleware(['auth', 'verified'])
      ->name('dashboard');
Route::get('/members', fn () => Inertia::render('Members/Index'))->name('members');
Route::get('/courses', fn () => Inertia::render('Courses/Index'))->name('courses');
Route::get('/forum', fn () => Inertia::render('Forum/Index'))->name('forum');
Route::get('/jobs', fn () => Inertia::render('Jobs/Index'))->name('jobs');
// În routes/web.php, adaugă:
// Înlocuiește ruta existentă cu:
Route::get('/news/{news}', [NewsController::class, 'show'])->name('news.show');// În routes/web.php:


Route::get('/events/{event}', [EventController::class, 'show'])->name('events.show');

// În routes/api.php:
Route::get('/events', [EventController::class, 'index']);