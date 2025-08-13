<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

class MembersController extends Controller
{
    /**
     * GET /api/members - listă membri pentru API
     */
    public function index(Request $request)
    {
        $query = User::query()->public();

        // Filtrare pe rol
        if ($request->has('role') && $request->role !== 'all') {
            $query->where('role', $request->role);
        }

        // Search
        if ($request->has('search') && !empty($request->search)) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('name', 'like', "%{$searchTerm}%")
                  ->orWhere('bio', 'like', "%{$searchTerm}%")
                  ->orWhere('school', 'like', "%{$searchTerm}%")
                  ->orWhere('department', 'like', "%{$searchTerm}%")
                  ->orWhere('company_name', 'like', "%{$searchTerm}%");
            });
        }

        // Sortare
        $sortBy = $request->get('sort', 'name');
        $sortOrder = $request->get('order', 'asc');
        
        if (in_array($sortBy, ['name', 'created_at', 'role'])) {
            $query->orderBy($sortBy, $sortOrder);
        } else {
            $query->orderBy('name', 'asc');
        }

        $members = $query->paginate(12);
        
        return UserResource::collection($members);
    }

    /**
     * GET /members - pagina cu toți membrii
     */
    public function page(Request $request)
    {
        return Inertia::render('Members/Index', [
            'filters' => [
                'role' => $request->get('role', 'all'),
                'search' => $request->get('search', ''),
                'sort' => $request->get('sort', 'name'),
                'order' => $request->get('order', 'asc'),
            ],
            'stats' => [
                'total' => User::public()->count(),
                'students' => User::students()->public()->count(),
                'teachers' => User::teachers()->public()->count(),
                'companies' => User::companies()->public()->count(),
            ]
        ]);
    }

    /**
     * GET /members/{user} - profil individual
     */
    public function show(User $user)
    {
        // Verifică dacă profilul e public
        if (!$user->is_public) {
            abort(404);
        }

        return Inertia::render('Members/Show', [
            'member' => new UserResource($user),
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
        ]);
    }
}