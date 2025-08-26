<?php

namespace App\Http\Controllers;

use App\Models\DocumentCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response;

class DocumentCategoriesController extends Controller
{
    /**
     * Display a listing of document categories.
     */
    public function index(): Response
    {
        $categories = DocumentCategory::withCount('documents')
            ->active()
            ->ordered()
            ->get();

        return Inertia::render('DocumentCategories/Index', [
            'categories' => $categories,
        ]);
    }

    /**
     * Show the form for creating a new document category.
     */
    public function create(): Response
    {
        return Inertia::render('DocumentCategories/Create');
    }

    /**
     * Store a newly created document category.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:document_categories,name',
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:100',
            'color' => 'nullable|string|max:7',
            'order' => 'nullable|integer|min:0',
            'access_level' => 'required|in:public,students,teachers,authenticated',
            'is_active' => 'boolean',
            'is_public' => 'boolean',
        ]);

        DocumentCategory::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'icon' => $request->icon,
            'color' => $request->color,
            'order' => $request->order ?? 0,
            'access_level' => $request->access_level,
            'is_active' => $request->is_active ?? true,
            'is_public' => $request->is_public ?? true,
        ]);

        return redirect()->route('document-categories.index')
            ->with('success', 'Categoria a fost creată cu succes!');
    }

    /**
     * Display the specified document category.
     */
    public function show(DocumentCategory $category): Response
    {
        if (!$category->canBeAccessedBy(auth()->user())) {
            abort(403, 'Nu aveți acces la această categorie.');
        }

        $category->load(['documents' => function($query) {
            $query->published()->orderBy('published_at', 'desc');
        }]);

        return Inertia::render('DocumentCategories/Show', [
            'category' => $category,
        ]);
    }

    /**
     * Show the form for editing the specified document category.
     */
    public function edit(DocumentCategory $category): Response
    {
        return Inertia::render('DocumentCategories/Edit', [
            'category' => $category,
        ]);
    }

    /**
     * Update the specified document category.
     */
    public function update(Request $request, DocumentCategory $category)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:document_categories,name,' . $category->id,
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:100',
            'color' => 'nullable|string|max:7',
            'order' => 'nullable|integer|min:0',
            'access_level' => 'required|in:public,students,teachers,authenticated',
            'is_active' => 'boolean',
            'is_public' => 'boolean',
        ]);

        $category->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'icon' => $request->icon,
            'color' => $request->color,
            'order' => $request->order ?? 0,
            'access_level' => $request->access_level,
            'is_active' => $request->is_active ?? true,
            'is_public' => $request->is_public ?? true,
        ]);

        return redirect()->route('document-categories.show', $category)
            ->with('success', 'Categoria a fost actualizată cu succes!');
    }

    /**
     * Remove the specified document category.
     */
    public function destroy(DocumentCategory $category)
    {
        // Check if category has documents
        if ($category->documents()->count() > 0) {
            return back()->withErrors(['category' => 'Nu se poate șterge categoria deoarece conține documente.']);
        }

        $category->delete();

        return redirect()->route('document-categories.index')
            ->with('success', 'Categoria a fost ștearsă cu succes!');
    }
}
