<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class MembersController extends Controller
{
    /**
     * Display a listing of the members.
     */
    public function index(Request $request)
    {
        $query = User::query()->public();

        // Apply filters
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('bio', 'like', "%{$search}%")
                  ->orWhere('school', 'like', "%{$search}%")
                  ->orWhere('department', 'like', "%{$search}%")
                  ->orWhere('company_name', 'like', "%{$search}%")
                  ->orWhere('skills', 'like', "%{$search}%")
                  ->orWhere('specializations', 'like', "%{$search}%");
            });
        }

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        if ($request->filled('department')) {
            $query->where('department', $request->department);
        }

        // Apply sorting
        $sortBy = $request->get('sort_by', 'name');
        $sortOrder = $request->get('sort_order', 'asc');
        
        switch ($sortBy) {
            case 'name':
                $query->orderBy('name', $sortOrder);
                break;
            case 'created_at':
                $query->orderBy('created_at', $sortOrder);
                break;
            case 'role':
                $query->orderBy('role', $sortOrder);
                break;
            default:
                $query->orderBy('name', 'asc');
        }

        $members = $query->paginate(12)->withQueryString();

        // Get statistics
        $stats = [
            'total' => User::public()->count(),
            'students' => User::students()->public()->count(),
            'teachers' => User::teachers()->public()->count(),
            'companies' => User::companies()->public()->count(),
        ];

        return Inertia::render('Members/Index', [
            'members' => $members,
            'stats' => $stats,
            'filters' => $request->only(['search', 'role', 'department', 'sort_by', 'sort_order']),
        ]);
    }

    /**
     * Display the specified member.
     */
    public function show(User $user)
    {
        // Check if profile is public
        if (!$user->is_public) {
            abort(404);
        }

        return Inertia::render('Members/Show', [
            'member' => $user,
        ]);
    }
}