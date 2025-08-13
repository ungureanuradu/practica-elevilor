<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Http\Resources\NewsResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;  // ← ADĂUGAT: pentru Route::has()
use Inertia\Inertia;  //

class NewsController extends Controller
{
    /** GET /api/news – feed public */
    public function index()
    {
        $latest = News::with('user')  // ← ADĂUGAT: încarcă relația user
            ->latest('created_at')
            ->take(6)
            ->get();
        
        return NewsResource::collection($latest);
    }

    /** GET /api/news/{news} – public (dacă vrei să afişezi o ştire individuală) */
    public function show(News $news)
    {
        $news->load('user');  // ← Adaugă asta!
        
        return Inertia::render('NewsShow', [
            'news' => new NewsResource($news),
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
        ]);
    }

    /** POST /api/news – necesită autentificare (profesor/admin) */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'nullable|string',
            'body' => 'required|string',
            'published_at' => 'nullable|date',
        ]);

        $news = News::create($data + ['user_id' => $request->user()->id]);
        $news->load('user');  // ← ADĂUGAT: încarcă relația pentru response
        
        return new NewsResource($news);
    }

    /** PUT /api/news/{news} – actualizare */
    public function update(Request $request, News $news)
    {
        $data = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'excerpt' => 'nullable|string',
            'body' => 'sometimes|required|string',
            'published_at' => 'nullable|date',
        ]);

        $news->update($data);
        $news->load('user');  // ← ADĂUGAT: încarcă relația după update
        
        return new NewsResource($news->refresh());
    }

    /** DELETE /api/news/{news} – ştergere */
    public function destroy(News $news)
    {
        $news->delete();
        return response()->noContent();
    }
}