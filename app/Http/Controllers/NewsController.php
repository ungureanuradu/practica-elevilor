<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Http\Resources\NewsResource;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    /** GET /api/news  – feed public */
    public function index()
    {
        $latest = News::latest('created_at')->take(6)->get();

        return NewsResource::collection($latest);
    }

    /** GET /api/news/{news} – public (dacă vrei să afişezi o ştire individuală) */
    public function show(News $news)
    {
        return new NewsResource($news);
    }

    /** POST /api/news – necesită autentificare (profesor/admin) */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title'        => 'required|string|max:255',
            'excerpt'      => 'nullable|string',
            'body'         => 'required|string',
            'published_at' => 'nullable|date',
        ]);

        $news = News::create($data + ['user_id' => $request->user()->id]);

        return new NewsResource($news);
    }

    /** PUT /api/news/{news} – actualizare */
    public function update(Request $request, News $news)
    {
        $data = $request->validate([
            'title'        => 'sometimes|required|string|max:255',
            'excerpt'      => 'nullable|string',
            'body'         => 'sometimes|required|string',
            'published_at' => 'nullable|date',
        ]);

        $news->update($data);

        return new NewsResource($news->refresh());
    }

    /** DELETE /api/news/{news} – ştergere */
    public function destroy(News $news)
    {
        $news->delete();

        return response()->noContent();
    }
}
