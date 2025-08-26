<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\DocumentCategory;
use App\Models\DocumentVersion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response;

class DocumentsController extends Controller
{
    /**
     * Display a listing of documents.
     */
    public function index(Request $request): Response
    {
        $query = Document::with(['category', 'uploader'])
            ->published()
            ->orderBy('published_at', 'desc');

        // Filter by category
        if ($request->filled('category')) {
            $query->byCategory($request->category);
        }

        // Filter by type
        if ($request->filled('type')) {
            $query->byType($request->type);
        }

        // Filter by uploader
        if ($request->filled('uploader')) {
            $query->byUploader($request->uploader);
        }

        // Filter by tags
        if ($request->filled('tags')) {
            $query->byTags($request->tags);
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('excerpt', 'like', "%{$search}%");
            });
        }

        // Sort
        $sort = $request->get('sort', 'recent');
        switch ($sort) {
            case 'popular':
                $query->popular();
                break;
            case 'most_viewed':
                $query->mostViewed();
                break;
            case 'recent':
            default:
                $query->recent();
                break;
        }

        $documents = $query->paginate(12)->withQueryString();

        $categories = DocumentCategory::active()->ordered()->get();
        $types = Document::select('type')->distinct()->pluck('type');

        return Inertia::render('Documents/Index', [
            'documents' => $documents,
            'categories' => $categories,
            'types' => $types,
            'filters' => $request->only(['category', 'type', 'uploader', 'tags', 'search', 'sort']),
        ]);
    }

    /**
     * Show the form for creating a new document.
     */
    public function create(): Response
    {
        $categories = DocumentCategory::active()->ordered()->get();

        return Inertia::render('Documents/Create', [
            'categories' => $categories,
        ]);
    }

    /**
     * Store a newly created document.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'excerpt' => 'nullable|string|max:500',
            'category_id' => 'required|exists:document_categories,id',
            'tags' => 'nullable|array',
            'tags.*' => 'string|max:50',
            'access_level' => 'required|in:public,students,teachers,authenticated',
            'is_downloadable' => 'boolean',
            'requires_approval' => 'boolean',
            'file' => 'required|file|max:10240', // 10MB max
        ]);

        $user = auth()->user();
        $category = DocumentCategory::findOrFail($request->category_id);

        // Check if user can upload to this category
        if (!$category->canBeUploadedToBy($user)) {
            return back()->withErrors(['category_id' => 'Nu aveți permisiunea să încărcați documente în această categorie.']);
        }

        // Handle file upload
        $file = $request->file('file');
        $fileName = Str::slug($request->title) . '.' . $file->getClientOriginalExtension();
        $filePath = $file->storeAs('documents/' . $file->getClientOriginalExtension(), $fileName, 'public');

        // Determine document type
        $type = $this->getDocumentType($file->getClientOriginalExtension());

        // Create document
        $document = Document::create([
            'title' => $request->title,
            'description' => $request->description,
            'excerpt' => $request->excerpt,
            'type' => $type,
            'category_id' => $request->category_id,
            'uploader_id' => $user->id,
            'access_level' => $request->access_level,
            'is_downloadable' => $request->is_downloadable ?? true,
            'requires_approval' => $request->requires_approval ?? false,
            'tags' => $request->tags,
            'file_size' => $file->getSize(),
            'file_extension' => $file->getClientOriginalExtension(),
            'mime_type' => $file->getMimeType(),
            'status' => $request->requires_approval ? 'draft' : 'published',
            'published_at' => $request->requires_approval ? null : now(),
        ]);

        // Create version
        DocumentVersion::create([
            'version_number' => '1.0',
            'file_path' => $filePath,
            'file_name' => $fileName,
            'file_size' => $file->getSize(),
            'file_extension' => $file->getClientOriginalExtension(),
            'mime_type' => $file->getMimeType(),
            'change_notes' => 'Versiunea inițială',
            'document_id' => $document->id,
            'uploader_id' => $user->id,
            'is_current' => true,
        ]);

        // Update category counts
        $category->updateCounts();

        return redirect()->route('documents.show', $document)
            ->with('success', 'Documentul a fost încărcat cu succes!');
    }

    /**
     * Display the specified document.
     */
    public function show(Document $document): Response
    {
        // Check access
        if (!$document->canBeAccessedBy(auth()->user())) {
            abort(403, 'Nu aveți acces la acest document.');
        }

        // Increment views
        $document->incrementViews();

        $document->load(['category', 'uploader', 'approvedBy', 'currentVersion']);

        return Inertia::render('Documents/Show', [
            'document' => $document,
        ]);
    }

    /**
     * Show the form for editing the specified document.
     */
    public function edit(Document $document): Response
    {
        if (!$document->canBeEditedBy(auth()->user())) {
            abort(403, 'Nu aveți permisiunea să editați acest document.');
        }

        $document->load(['category', 'currentVersion']);
        $categories = DocumentCategory::active()->ordered()->get();

        return Inertia::render('Documents/Edit', [
            'document' => $document,
            'categories' => $categories,
        ]);
    }

    /**
     * Update the specified document.
     */
    public function update(Request $request, Document $document)
    {
        if (!$document->canBeEditedBy(auth()->user())) {
            abort(403, 'Nu aveți permisiunea să editați acest document.');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'excerpt' => 'nullable|string|max:500',
            'category_id' => 'required|exists:document_categories,id',
            'tags' => 'nullable|array',
            'tags.*' => 'string|max:50',
            'access_level' => 'required|in:public,students,teachers,authenticated',
            'is_downloadable' => 'boolean',
            'file' => 'nullable|file|max:10240', // 10MB max
        ]);

        $category = DocumentCategory::findOrFail($request->category_id);

        // Check if user can upload to this category
        if (!$category->canBeUploadedToBy(auth()->user())) {
            return back()->withErrors(['category_id' => 'Nu aveți permisiunea să încărcați documente în această categorie.']);
        }

        $updateData = [
            'title' => $request->title,
            'description' => $request->description,
            'excerpt' => $request->excerpt,
            'category_id' => $request->category_id,
            'access_level' => $request->access_level,
            'is_downloadable' => $request->is_downloadable ?? true,
            'tags' => $request->tags,
        ];

        // Handle new file upload
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = Str::slug($request->title) . '.' . $file->getClientOriginalExtension();
            $filePath = $file->storeAs('documents/' . $file->getClientOriginalExtension(), $fileName, 'public');

            $type = $this->getDocumentType($file->getClientOriginalExtension());

            $updateData = array_merge($updateData, [
                'type' => $type,
                'file_size' => $file->getSize(),
                'file_extension' => $file->getClientOriginalExtension(),
                'mime_type' => $file->getMimeType(),
            ]);

            // Create new version
            DocumentVersion::create([
                'version_number' => $this->getNextVersionNumber($document),
                'file_path' => $filePath,
                'file_name' => $fileName,
                'file_size' => $file->getSize(),
                'file_extension' => $file->getClientOriginalExtension(),
                'mime_type' => $file->getMimeType(),
                'change_notes' => $request->change_notes ?? 'Actualizare document',
                'document_id' => $document->id,
                'uploader_id' => auth()->id(),
                'is_current' => true,
            ]);

            // Remove current flag from other versions
            $document->versions()->where('id', '!=', $document->versions()->latest()->first()->id)
                ->update(['is_current' => false]);
        }

        $document->update($updateData);

        // Update category counts
        $category->updateCounts();

        return redirect()->route('documents.show', $document)
            ->with('success', 'Documentul a fost actualizat cu succes!');
    }

    /**
     * Remove the specified document.
     */
    public function destroy(Document $document)
    {
        if (!$document->canBeDeletedBy(auth()->user())) {
            abort(403, 'Nu aveți permisiunea să ștergeți acest document.');
        }

        // Delete all versions
        foreach ($document->versions as $version) {
            Storage::disk('public')->delete($version->file_path);
        }
        $document->versions()->delete();

        // Delete document
        $document->delete();

        // Update category counts
        $document->category->updateCounts();

        return redirect()->route('documents.index')
            ->with('success', 'Documentul a fost șters cu succes!');
    }

    /**
     * Download the document.
     */
    public function download(Document $document)
    {
        if (!$document->canBeDownloadedBy(auth()->user())) {
            abort(403, 'Nu aveți permisiunea să descărcați acest document.');
        }

        $currentVersion = $document->currentVersion;
        if (!$currentVersion) {
            abort(404, 'Documentul nu a fost găsit.');
        }

        // Increment download count
        $document->incrementDownloads();

        return Storage::disk('public')->download($currentVersion->file_path, $currentVersion->file_name);
    }

    /**
     * Download a specific version of the document.
     */
    public function downloadVersion(Document $document, DocumentVersion $version)
    {
        if (!$document->canBeDownloadedBy(auth()->user())) {
            abort(403, 'Nu aveți permisiunea să descărcați acest document.');
        }

        if ($version->document_id !== $document->id) {
            abort(404, 'Versiunea nu a fost găsită.');
        }

        // Increment download count
        $document->incrementDownloads();

        return Storage::disk('public')->download($version->file_path, $version->file_name);
    }

    /**
     * Preview the document (for images and PDFs).
     */
    public function preview(Document $document)
    {
        if (!$document->canBeAccessedBy(auth()->user())) {
            abort(403, 'Nu aveți acces la acest document.');
        }

        $currentVersion = $document->currentVersion;
        if (!$currentVersion) {
            abort(404, 'Documentul nu a fost găsit.');
        }

        if (!in_array($document->type, ['image', 'pdf'])) {
            abort(400, 'Acest tip de document nu poate fi previzualizat.');
        }

        return Storage::disk('public')->response($currentVersion->file_path);
    }

    /**
     * Approve a document (for teachers).
     */
    public function approve(Document $document)
    {
        $user = auth()->user();
        
        if (!$user->isTeacher()) {
            abort(403, 'Doar profesorii pot aproba documente.');
        }

        $document->approve($user);
        $document->publish();

        return back()->with('success', 'Documentul a fost aprobat și publicat cu succes!');
    }

    /**
     * Get user's documents.
     */
    public function myDocuments(Request $request): Response
    {
        $user = auth()->user();
        
        $query = Document::with(['category'])
            ->where('uploader_id', $user->id)
            ->orderBy('created_at', 'desc');

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $documents = $query->paginate(12)->withQueryString();

        return Inertia::render('Documents/MyDocuments', [
            'documents' => $documents,
            'filters' => $request->only(['status']),
        ]);
    }

    /**
     * Get documents pending approval (for teachers).
     */
    public function pendingApproval(Request $request): Response
    {
        $user = auth()->user();
        
        if (!$user->isTeacher()) {
            abort(403, 'Doar profesorii pot vedea documentele în așteptare.');
        }

        $query = Document::with(['category', 'uploader'])
            ->where('status', 'draft')
            ->where('requires_approval', true)
            ->orderBy('created_at', 'desc');

        $documents = $query->paginate(12)->withQueryString();

        return Inertia::render('Documents/PendingApproval', [
            'documents' => $documents,
        ]);
    }

    /**
     * Helper method to determine document type from extension.
     */
    private function getDocumentType(string $extension): string
    {
        $extension = strtolower($extension);
        
        $typeMap = [
            'pdf' => 'pdf',
            'doc' => 'doc',
            'docx' => 'docx',
            'ppt' => 'ppt',
            'pptx' => 'pptx',
            'xls' => 'xls',
            'xlsx' => 'xlsx',
            'txt' => 'txt',
            'zip' => 'zip',
            'rar' => 'rar',
            'jpg' => 'image',
            'jpeg' => 'image',
            'png' => 'image',
            'gif' => 'image',
            'mp4' => 'video',
            'avi' => 'video',
            'mp3' => 'audio',
            'wav' => 'audio',
        ];

        return $typeMap[$extension] ?? 'other';
    }

    /**
     * Helper method to get next version number.
     */
    private function getNextVersionNumber(Document $document): string
    {
        $latestVersion = $document->versions()->latest()->first();
        
        if (!$latestVersion) {
            return '1.0';
        }

        $versionParts = explode('.', $latestVersion->version_number);
        $major = (int) $versionParts[0];
        $minor = isset($versionParts[1]) ? (int) $versionParts[1] : 0;

        return ($major + 1) . '.0';
    }
}
