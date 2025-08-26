<?php

namespace Database\Seeders;

use App\Models\Document;
use App\Models\DocumentCategory;
use App\Models\DocumentVersion;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DocumentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get or create users
        $teacher = User::firstOrCreate(
            ['email' => 'profesor@example.com'],
            [
                'name' => 'Profesor Test',
                'role' => 'teacher',
                'department' => 'Informatică',
                'title' => 'Profesor',
                'specializations' => ['PHP', 'Laravel', 'Vue.js'],
                'password' => bcrypt('password'),
                'email_verified_at' => now(),
            ]
        );

        $student = User::firstOrCreate(
            ['email' => 'student@example.com'],
            [
                'name' => 'Student Test',
                'role' => 'student',
                'school' => 'Liceul Tehnologic „Vasile Sav"',
                'year_of_study' => 'Clasa a XII-a',
                'skills' => ['HTML', 'CSS', 'JavaScript'],
                'password' => bcrypt('password'),
                'email_verified_at' => now(),
            ]
        );

        // Create document categories
        $categories = [
            [
                'name' => 'Cursuri și Materiale',
                'slug' => 'cursuri-materiale',
                'description' => 'Cursuri, prezentări și materiale educaționale pentru diferite materii',
                'icon' => 'fas fa-book',
                'color' => '#3B82F6',
                'order' => 1,
                'access_level' => 'public',
            ],
            [
                'name' => 'Proiecte Studențești',
                'slug' => 'proiecte-studentesti',
                'description' => 'Proiecte realizate de studenți în cadrul cursurilor și activităților extracurriculare',
                'icon' => 'fas fa-project-diagram',
                'color' => '#10B981',
                'order' => 2,
                'access_level' => 'public',
            ],
            [
                'name' => 'Tutoriale și Ghiduri',
                'slug' => 'tutoriale-ghiduri',
                'description' => 'Tutoriale pas cu pas, ghiduri practice și resurse de învățare',
                'icon' => 'fas fa-graduation-cap',
                'color' => '#8B5CF6',
                'order' => 3,
                'access_level' => 'public',
            ],
            [
                'name' => 'Documente Administrative',
                'slug' => 'documente-administrative',
                'description' => 'Formulare, regulamente și documente administrative ale școlii',
                'icon' => 'fas fa-file-alt',
                'color' => '#F59E0B',
                'order' => 4,
                'access_level' => 'public',
            ],
            [
                'name' => 'Resurse pentru Carieră',
                'slug' => 'resurse-cariera',
                'description' => 'CV-uri, scrisori de intenție, ghiduri pentru interviuri și resurse pentru carieră',
                'icon' => 'fas fa-briefcase',
                'color' => '#EF4444',
                'order' => 5,
                'access_level' => 'students',
            ],
            [
                'name' => 'Bibliotecă Digitală',
                'slug' => 'biblioteca-digitala',
                'description' => 'Cărți digitale, articole și resurse bibliografice pentru studiu',
                'icon' => 'fas fa-university',
                'color' => '#06B6D4',
                'order' => 6,
                'access_level' => 'public',
            ],
            [
                'name' => 'Software și Instrumente',
                'slug' => 'software-instrumente',
                'description' => 'Software educațional, instrumente de dezvoltare și utilitare',
                'icon' => 'fas fa-tools',
                'color' => '#84CC16',
                'order' => 7,
                'access_level' => 'public',
            ],
            [
                'name' => 'Evenimente și Activități',
                'slug' => 'evenimente-activitati',
                'description' => 'Materiale și documente legate de evenimente școlare și activități extracurriculare',
                'icon' => 'fas fa-calendar-alt',
                'color' => '#EC4899',
                'order' => 8,
                'access_level' => 'public',
            ],
        ];

        foreach ($categories as $categoryData) {
            DocumentCategory::create($categoryData);
        }

        // Get categories for creating documents
        $cursuriCategory = DocumentCategory::where('slug', 'cursuri-materiale')->first();
        $proiecteCategory = DocumentCategory::where('slug', 'proiecte-studentesti')->first();
        $tutorialeCategory = DocumentCategory::where('slug', 'tutoriale-ghiduri')->first();
        $administrativeCategory = DocumentCategory::where('slug', 'documente-administrative')->first();
        $carieraCategory = DocumentCategory::where('slug', 'resurse-cariera')->first();
        $bibliotecaCategory = DocumentCategory::where('slug', 'biblioteca-digitala')->first();

        // Create sample documents
        $documents = [
            [
                'title' => 'Introducere în Programare cu Python',
                'description' => 'Curs complet pentru începători în programare cu Python. Include concepte fundamentale, exemple practice și exerciții.',
                'excerpt' => 'Curs de bază pentru învățarea programării cu Python',
                'type' => 'pdf',
                'category_id' => $cursuriCategory->id,
                'uploader_id' => $teacher->id,
                'tags' => ['Python', 'Programare', 'Începător'],
                'is_featured' => true,
                'status' => 'published',
                'published_at' => now()->subDays(10),
                'approved_at' => now()->subDays(10),
                'approved_by_id' => $teacher->id,
            ],
            [
                'title' => 'Ghid Practic Laravel pentru Începători',
                'description' => 'Ghid pas cu pas pentru dezvoltarea aplicațiilor web cu Laravel. Include exemple practice și proiecte complete.',
                'excerpt' => 'Ghid complet pentru învățarea framework-ului Laravel',
                'type' => 'pdf',
                'category_id' => $tutorialeCategory->id,
                'uploader_id' => $teacher->id,
                'tags' => ['Laravel', 'PHP', 'Web Development'],
                'is_featured' => true,
                'status' => 'published',
                'published_at' => now()->subDays(5),
                'approved_at' => now()->subDays(5),
                'approved_by_id' => $teacher->id,
            ],
            [
                'title' => 'Proiect: Aplicație Web de Management al Bibliotecii',
                'description' => 'Proiect realizat de studenți pentru managementul unei biblioteci. Include documentația completă și codul sursă.',
                'excerpt' => 'Proiect complet de aplicație web pentru bibliotecă',
                'type' => 'zip',
                'category_id' => $proiecteCategory->id,
                'uploader_id' => $student->id,
                'tags' => ['Proiect', 'Web Development', 'Laravel'],
                'status' => 'published',
                'published_at' => now()->subDays(3),
                'approved_at' => now()->subDays(3),
                'approved_by_id' => $teacher->id,
            ],
            [
                'title' => 'Template CV pentru Studenți IT',
                'description' => 'Template profesional pentru CV-uri în domeniul IT. Include exemple și sfaturi pentru redactare.',
                'excerpt' => 'Template CV profesional pentru studenții IT',
                'type' => 'docx',
                'category_id' => $carieraCategory->id,
                'uploader_id' => $teacher->id,
                'tags' => ['CV', 'Template', 'IT'],
                'status' => 'published',
                'published_at' => now()->subDays(7),
                'approved_at' => now()->subDays(7),
                'approved_by_id' => $teacher->id,
            ],
            [
                'title' => 'Regulamentul Intern al Școlii',
                'description' => 'Regulamentul intern actualizat al Liceului Tehnologic „Vasile Sav". Include toate normele și regulile școlare.',
                'excerpt' => 'Regulamentul intern al școlii',
                'type' => 'pdf',
                'category_id' => $administrativeCategory->id,
                'uploader_id' => $teacher->id,
                'tags' => ['Regulament', 'Administrativ'],
                'status' => 'published',
                'published_at' => now()->subDays(15),
                'approved_at' => now()->subDays(15),
                'approved_by_id' => $teacher->id,
            ],
            [
                'title' => 'Carte: Algoritmi și Structuri de Date',
                'description' => 'Carte digitală despre algoritmi și structuri de date. Include exemple practice și implementări în C++.',
                'excerpt' => 'Carte completă despre algoritmi și structuri de date',
                'type' => 'pdf',
                'category_id' => $bibliotecaCategory->id,
                'uploader_id' => $teacher->id,
                'tags' => ['Algoritmi', 'Structuri de Date', 'C++'],
                'status' => 'published',
                'published_at' => now()->subDays(20),
                'approved_at' => now()->subDays(20),
                'approved_by_id' => $teacher->id,
            ],
            [
                'title' => 'Prezentare: Introducere în Machine Learning',
                'description' => 'Prezentare despre conceptele fundamentale ale Machine Learning-ului. Include exemple și aplicații practice.',
                'excerpt' => 'Prezentare despre Machine Learning',
                'type' => 'pptx',
                'category_id' => $cursuriCategory->id,
                'uploader_id' => $teacher->id,
                'tags' => ['Machine Learning', 'AI', 'Prezentare'],
                'status' => 'published',
                'published_at' => now()->subDays(2),
                'approved_at' => now()->subDays(2),
                'approved_by_id' => $teacher->id,
            ],
            [
                'title' => 'Proiect: Aplicație Mobile de Note',
                'description' => 'Aplicație mobile pentru gestionarea notelor realizată cu React Native. Include documentația și codul sursă.',
                'excerpt' => 'Aplicație mobile pentru gestionarea notelor',
                'type' => 'zip',
                'category_id' => $proiecteCategory->id,
                'uploader_id' => $student->id,
                'tags' => ['Mobile', 'React Native', 'Proiect'],
                'status' => 'published',
                'published_at' => now()->subDays(1),
                'approved_at' => now()->subDays(1),
                'approved_by_id' => $teacher->id,
            ],
        ];

        foreach ($documents as $documentData) {
            $document = Document::create($documentData);
            
            // Create a version for each document
            $this->createVersionForDocument($document, $teacher);
        }

        // Update category counts
        DocumentCategory::all()->each(function ($category) {
            $category->updateCounts();
        });
    }

    private function createVersionForDocument($document, $teacher)
    {
        $fileSizes = [
            'pdf' => 2048576, // 2MB
            'docx' => 1048576, // 1MB
            'zip' => 5242880, // 5MB
            'pptx' => 3145728, // 3MB
        ];

        $fileSize = $fileSizes[$document->type] ?? 1048576;
        $fileName = Str::slug($document->title) . '.' . $document->type;
        $filePath = 'documents/' . $document->type . '/' . $fileName;

        DocumentVersion::create([
            'version_number' => '1.0',
            'file_path' => $filePath,
            'file_name' => $fileName,
            'file_size' => $fileSize,
            'file_extension' => $document->type,
            'mime_type' => $this->getMimeType($document->type),
            'change_notes' => 'Versiunea inițială',
            'document_id' => $document->id,
            'uploader_id' => $teacher->id,
            'is_current' => true,
        ]);
    }

    private function getMimeType($extension): string
    {
        return match($extension) {
            'pdf' => 'application/pdf',
            'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'zip' => 'application/zip',
            'pptx' => 'application/vnd.openxmlformats-officedocument.presentationml.presentation',
            default => 'application/octet-stream'
        };
    }
}
