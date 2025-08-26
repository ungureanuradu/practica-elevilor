<?php

namespace App\Http\Controllers;

use App\Models\CalendarCategory;
use App\Models\CalendarEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Carbon\Carbon;

class CalendarController extends Controller
{
    /**
     * Display the calendar overview
     */
    public function index(Request $request)
    {
        $query = CalendarEvent::with(['category', 'organizer'])
                             ->published();

        // Apply filters
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%");
            });
        }

        if ($request->filled('category')) {
            $query->byCategory($request->category);
        }

        if ($request->filled('type')) {
            $query->byType($request->type);
        }

        if ($request->filled('date')) {
            $date = Carbon::parse($request->date);
            $query->whereDate('start_date', $date);
        }

        if ($request->filled('period')) {
            switch ($request->period) {
                case 'today':
                    $query->today();
                    break;
                case 'week':
                    $query->thisWeek();
                    break;
                case 'month':
                    $query->thisMonth();
                    break;
                case 'upcoming':
                    $query->upcoming();
                    break;
                case 'past':
                    $query->past();
                    break;
            }
        }

        // Apply sorting
        $sortBy = $request->get('sort_by', 'start_date');
        $sortOrder = $request->get('sort_order', 'asc');
        
        switch ($sortBy) {
            case 'title':
                $query->orderBy('title', $sortOrder);
                break;
            case 'category':
                $query->join('calendar_categories', 'calendar_events.category_id', '=', 'calendar_categories.id')
                      ->orderBy('calendar_categories.name', $sortOrder);
                break;
            case 'organizer':
                $query->join('users', 'calendar_events.organizer_id', '=', 'users.id')
                      ->orderBy('users.name', $sortOrder);
                break;
            default:
                $query->orderBy('start_date', $sortOrder);
        }

        $events = $query->paginate(15)->withQueryString();

        // Get featured events
        $featuredEvents = CalendarEvent::with(['category', 'organizer'])
                                      ->published()
                                      ->featured()
                                      ->upcoming()
                                      ->limit(5)
                                      ->get();

        // Get upcoming events for this week
        $thisWeekEvents = CalendarEvent::with(['category', 'organizer'])
                                      ->published()
                                      ->thisWeek()
                                      ->orderBy('start_date', 'asc')
                                      ->get();

        // Get categories for filter
        $categories = CalendarCategory::active()
                                    ->ordered()
                                    ->get();

        return Inertia::render('Calendar/Index', [
            'events' => $events,
            'featuredEvents' => $featuredEvents,
            'thisWeekEvents' => $thisWeekEvents,
            'categories' => $categories,
            'filters' => $request->only(['search', 'category', 'type', 'date', 'period', 'sort_by', 'sort_order']),
            'types' => [
                'single' => 'Eveniment unic',
                'recurring' => 'Eveniment recurent',
                'all-day' => 'Toată ziua',
            ],
            'periods' => [
                'today' => 'Astăzi',
                'week' => 'Această săptămână',
                'month' => 'Acestă lună',
                'upcoming' => 'Viitoare',
                'past' => 'Trecute',
            ],
        ]);
    }

    /**
     * Display calendar view (monthly/weekly/daily)
     */
    public function view(Request $request)
    {
        $view = $request->get('view', 'month');
        $date = $request->get('date') ? Carbon::parse($request->date) : Carbon::now();

        $events = CalendarEvent::with(['category', 'organizer'])
                              ->published();

        // Filter events based on view
        switch ($view) {
            case 'month':
                $startOfMonth = $date->copy()->startOfMonth()->startOfWeek();
                $endOfMonth = $date->copy()->endOfMonth()->endOfWeek();
                $events->whereBetween('start_date', [$startOfMonth, $endOfMonth]);
                break;
            case 'week':
                $startOfWeek = $date->copy()->startOfWeek();
                $endOfWeek = $date->copy()->endOfWeek();
                $events->whereBetween('start_date', [$startOfWeek, $endOfWeek]);
                break;
            case 'day':
                $events->whereDate('start_date', $date);
                break;
        }

        $events = $events->orderBy('start_date', 'asc')->get();

        // Get categories for legend
        $categories = CalendarCategory::active()
                                    ->ordered()
                                    ->get();

        return Inertia::render('Calendar/View', [
            'view' => $view,
            'date' => $date->format('Y-m-d'),
            'events' => $events,
            'categories' => $categories,
        ]);
    }

    /**
     * Get events for calendar (AJAX)
     */
    public function events(Request $request)
    {
        $start = Carbon::parse($request->start);
        $end = Carbon::parse($request->end);

        $events = CalendarEvent::with(['category', 'organizer'])
                              ->published()
                              ->whereBetween('start_date', [$start, $end])
                              ->orWhereBetween('end_date', [$start, $end])
                              ->orWhere(function ($query) use ($start, $end) {
                                  $query->where('start_date', '<=', $start)
                                        ->where('end_date', '>=', $end);
                              })
                              ->get()
                              ->map(function ($event) {
                                  return [
                                      'id' => $event->id,
                                      'title' => $event->title,
                                      'start' => $event->start_date->format('Y-m-d\TH:i:s'),
                                      'end' => $event->end_date->format('Y-m-d\TH:i:s'),
                                      'allDay' => $event->type === 'all-day',
                                      'url' => route('calendar-events.show', $event),
                                      'backgroundColor' => $event->category->color,
                                      'borderColor' => $event->category->color,
                                      'textColor' => '#ffffff',
                                      'extendedProps' => [
                                          'category' => $event->category->name,
                                          'location' => $event->location,
                                          'organizer' => $event->organizer->name,
                                      ],
                                  ];
                              });

        return response()->json($events);
    }

    /**
     * User's events
     */
    public function myEvents()
    {
        $events = CalendarEvent::with(['category', 'organizer'])
                              ->where('organizer_id', Auth::id())
                              ->orderBy('start_date', 'desc')
                              ->paginate(15);

        return Inertia::render('Calendar/MyEvents', [
            'events' => $events,
        ]);
    }

    /**
     * Search events
     */
    public function search(Request $request)
    {
        $query = $request->get('q');
        
        if (!$query) {
            return redirect()->route('calendar.index');
        }

        $events = CalendarEvent::with(['category', 'organizer'])
                              ->published()
                              ->where(function ($q) use ($query) {
                                  $q->where('title', 'like', "%{$query}%")
                                    ->orWhere('description', 'like', "%{$query}%")
                                    ->orWhere('location', 'like', "%{$query}%");
                              })
                              ->orderBy('start_date', 'asc')
                              ->paginate(15)
                              ->withQueryString();

        return Inertia::render('Calendar/Search', [
            'events' => $events,
            'query' => $query,
        ]);
    }
}
