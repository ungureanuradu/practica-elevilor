<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\GroupMember;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class GroupsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Group::with(['owner', 'moderator', 'activeMembers'])
                     ->active();

        // Apply filters
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhereJsonContains('tags', $search);
            });
        }

        if ($request->filled('category')) {
            $query->byCategory($request->category);
        }

        if ($request->filled('type')) {
            $query->byType($request->type);
        }

        // Apply sorting
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        
        switch ($sortBy) {
            case 'name':
                $query->orderBy('name', $sortOrder);
                break;
            case 'members_count':
                $query->orderBy('members_count', $sortOrder);
                break;
            case 'last_activity':
                $query->orderBy('last_activity_at', $sortOrder);
                break;
            default:
                $query->orderBy('created_at', $sortOrder);
        }

        $groups = $query->paginate(12)->withQueryString();

        // Get user's groups for comparison
        $userGroups = collect();
        if (Auth::check()) {
            $userGroups = Auth::user()->groups->pluck('id');
        }

        return Inertia::render('Groups/Index', [
            'groups' => $groups,
            'userGroups' => $userGroups,
            'filters' => $request->only(['search', 'category', 'type', 'sort_by', 'sort_order']),
            'categories' => [
                'academic' => 'Academic',
                'hobby' => 'Hobby',
                'professional' => 'Profesional',
                'social' => 'Social',
                'study' => 'Studiu',
                'project' => 'Proiect',
                'other' => 'Altul',
            ],
            'types' => [
                'public' => 'Public',
                'private' => 'Privat',
                'secret' => 'Secret',
            ],
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Groups/Create', [
            'categories' => [
                'academic' => 'Academic',
                'hobby' => 'Hobby',
                'professional' => 'Profesional',
                'social' => 'Social',
                'study' => 'Studiu',
                'project' => 'Proiect',
                'other' => 'Altul',
            ],
            'types' => [
                'public' => 'Public',
                'private' => 'Privat',
                'secret' => 'Secret',
            ],
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'excerpt' => 'nullable|string|max:500',
            'type' => 'required|in:public,private,secret',
            'category' => 'required|in:academic,hobby,professional,social,study,project,other',
            'tags' => 'nullable|array',
            'tags.*' => 'string|max:50',
            'max_members' => 'nullable|integer|min:1|max:1000',
            'requires_approval' => 'boolean',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->all();
        $data['owner_id'] = Auth::id();
        $data['moderator_id'] = Auth::id();

        // Handle file uploads
        if ($request->hasFile('avatar')) {
            $data['avatar'] = $request->file('avatar')->store('groups/avatars', 'public');
        }

        if ($request->hasFile('cover_image')) {
            $data['cover_image'] = $request->file('cover_image')->store('groups/covers', 'public');
        }

        $group = Group::create($data);

        // Add creator as owner member
        $group->addMember(Auth::user(), 'owner');

        return redirect()->route('groups.show', $group)
                        ->with('success', 'Grupul a fost creat cu succes!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Group $group)
    {
        $group->load(['owner', 'moderator', 'activeMembers', 'topics']);

        $isMember = false;
        $userRole = null;
        $canEdit = false;
        $canDelete = false;

        if (Auth::check()) {
            $isMember = $group->hasMember(Auth::user());
            $canEdit = $group->canBeEditedBy(Auth::user());
            $canDelete = $group->canBeDeletedBy(Auth::user());
            
            if ($isMember) {
                $membership = $group->groupMembers()->where('user_id', Auth::id())->first();
                $userRole = $membership->role;
            }
        }

        return Inertia::render('Groups/Show', [
            'group' => $group,
            'isMember' => $isMember,
            'userRole' => $userRole,
            'canEdit' => $canEdit,
            'canDelete' => $canDelete,
            'canJoin' => $group->canBeJoinedBy(Auth::user()),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Group $group)
    {
        if (!$group->canBeEditedBy(Auth::user())) {
            abort(403);
        }

        return Inertia::render('Groups/Edit', [
            'group' => $group,
            'categories' => [
                'academic' => 'Academic',
                'hobby' => 'Hobby',
                'professional' => 'Profesional',
                'social' => 'Social',
                'study' => 'Studiu',
                'project' => 'Proiect',
                'other' => 'Altul',
            ],
            'types' => [
                'public' => 'Public',
                'private' => 'Privat',
                'secret' => 'Secret',
            ],
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Group $group)
    {
        if (!$group->canBeEditedBy(Auth::user())) {
            abort(403);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'excerpt' => 'nullable|string|max:500',
            'type' => 'required|in:public,private,secret',
            'category' => 'required|in:academic,hobby,professional,social,study,project,other',
            'tags' => 'nullable|array',
            'tags.*' => 'string|max:50',
            'max_members' => 'nullable|integer|min:1|max:1000',
            'requires_approval' => 'boolean',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->except(['avatar', 'cover_image']);

        // Handle file uploads
        if ($request->hasFile('avatar')) {
            if ($group->avatar) {
                Storage::disk('public')->delete($group->avatar);
            }
            $data['avatar'] = $request->file('avatar')->store('groups/avatars', 'public');
        }

        if ($request->hasFile('cover_image')) {
            if ($group->cover_image) {
                Storage::disk('public')->delete($group->cover_image);
            }
            $data['cover_image'] = $request->file('cover_image')->store('groups/covers', 'public');
        }

        $group->update($data);

        return redirect()->route('groups.show', $group)
                        ->with('success', 'Grupul a fost actualizat cu succes!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Group $group)
    {
        if (!$group->canBeDeletedBy(Auth::user())) {
            abort(403);
        }

        // Delete associated files
        if ($group->avatar) {
            Storage::disk('public')->delete($group->avatar);
        }
        if ($group->cover_image) {
            Storage::disk('public')->delete($group->cover_image);
        }

        $group->delete();

        return redirect()->route('groups.index')
                        ->with('success', 'Grupul a fost șters cu succes!');
    }

    /**
     * Join a group
     */
    public function join(Group $group)
    {
        if (!$group->canBeJoinedBy(Auth::user())) {
            return back()->with('error', 'Nu poți adera la acest grup.');
        }

        $status = $group->requires_approval ? 'pending' : 'active';
        
        GroupMember::create([
            'group_id' => $group->id,
            'user_id' => Auth::id(),
            'role' => 'member',
            'status' => $status,
            'joined_at' => now(),
            'last_activity_at' => now(),
        ]);

        if ($status === 'active') {
            $group->increment('members_count');
        }

        $message = $status === 'pending' 
            ? 'Cererea ta de aderare a fost trimisă și așteaptă aprobare.'
            : 'Ai aderat cu succes la grup!';

        return back()->with('success', $message);
    }

    /**
     * Leave a group
     */
    public function leave(Group $group)
    {
        $membership = $group->groupMembers()->where('user_id', Auth::id())->first();
        
        if (!$membership) {
            return back()->with('error', 'Nu ești membru al acestui grup.');
        }

        if ($membership->role === 'owner') {
            return back()->with('error', 'Proprietarul grupului nu poate părăsi grupul.');
        }

        $membership->delete();
        $group->decrement('members_count');

        return redirect()->route('groups.index')
                        ->with('success', 'Ai părăsit grupul cu succes.');
    }

    /**
     * User's groups
     */
    public function myGroups()
    {
        $groups = Auth::user()->groups()
                    ->with(['owner', 'moderator'])
                    ->orderBy('created_at', 'desc')
                    ->paginate(12);

        return Inertia::render('Groups/MyGroups', [
            'groups' => $groups,
        ]);
    }
}
