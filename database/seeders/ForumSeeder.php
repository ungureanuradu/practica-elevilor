<?php

namespace Database\Seeders;

use App\Models\ForumCategory;
use App\Models\ForumThread;
use App\Models\ForumPost;
use App\Models\User;
use Illuminate\Database\Seeder;

class ForumSeeder extends Seeder
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

        // Create forum categories
        $categories = [
            [
                'name' => 'Programare Generală',
                'slug' => 'programare-generala',
                'description' => 'Discuții generale despre programare, algoritmi și structuri de date',
                'icon' => 'fas fa-code',
                'color' => '#3B82F6',
                'order' => 1,
                'access_level' => 'public',
            ],
            [
                'name' => 'Web Development',
                'slug' => 'web-development',
                'description' => 'HTML, CSS, JavaScript, PHP, Laravel, Vue.js și alte tehnologii web',
                'icon' => 'fas fa-globe',
                'color' => '#10B981',
                'order' => 2,
                'access_level' => 'public',
            ],
            [
                'name' => 'Mobile Development',
                'slug' => 'mobile-development',
                'description' => 'Dezvoltarea aplicațiilor mobile cu React Native, Flutter, etc.',
                'icon' => 'fas fa-mobile-alt',
                'color' => '#8B5CF6',
                'order' => 3,
                'access_level' => 'public',
            ],
            [
                'name' => 'Baze de Date',
                'slug' => 'baze-de-date',
                'description' => 'SQL, MySQL, PostgreSQL, MongoDB și alte sisteme de baze de date',
                'icon' => 'fas fa-database',
                'color' => '#F59E0B',
                'order' => 4,
                'access_level' => 'public',
            ],
            [
                'name' => 'Design & UI/UX',
                'slug' => 'design-ui-ux',
                'description' => 'Design grafic, interfețe utilizator și experiența utilizatorului',
                'icon' => 'fas fa-palette',
                'color' => '#EC4899',
                'order' => 5,
                'access_level' => 'public',
            ],
            [
                'name' => 'Carieră & Joburi',
                'slug' => 'cariera-joburi',
                'description' => 'Sfaturi pentru carieră, interviuri, CV-uri și oportunități de joburi',
                'icon' => 'fas fa-briefcase',
                'color' => '#EF4444',
                'order' => 6,
                'access_level' => 'public',
            ],
            [
                'name' => 'Proiecte & Portofoliu',
                'slug' => 'proiecte-portofoliu',
                'description' => 'Prezentarea proiectelor personale și portofoliului',
                'icon' => 'fas fa-project-diagram',
                'color' => '#06B6D4',
                'order' => 7,
                'access_level' => 'public',
            ],
            [
                'name' => 'Anunțuri Școlare',
                'slug' => 'anunturi-scolare',
                'description' => 'Anunțuri oficiale de la școală, evenimente și activități',
                'icon' => 'fas fa-bullhorn',
                'color' => '#84CC16',
                'order' => 8,
                'access_level' => 'public',
            ],
            [
                'name' => 'Întrebări & Ajutor',
                'slug' => 'intrebari-ajutor',
                'description' => 'Întrebări despre programare și cereri de ajutor',
                'icon' => 'fas fa-question-circle',
                'color' => '#F97316',
                'order' => 9,
                'access_level' => 'public',
            ],
            [
                'name' => 'Resurse & Tutoriale',
                'slug' => 'resurse-tutoriale',
                'description' => 'Link-uri utile, tutoriale și resurse educaționale',
                'icon' => 'fas fa-book',
                'color' => '#6366F1',
                'order' => 10,
                'access_level' => 'public',
            ],
        ];

        foreach ($categories as $categoryData) {
            ForumCategory::create($categoryData);
        }

        // Get categories for creating threads
        $webDevCategory = ForumCategory::where('slug', 'web-development')->first();
        $programmingCategory = ForumCategory::where('slug', 'programare-generala')->first();
        $careerCategory = ForumCategory::where('slug', 'cariera-joburi')->first();
        $questionsCategory = ForumCategory::where('slug', 'intrebari-ajutor')->first();
        $announcementsCategory = ForumCategory::where('slug', 'anunturi-scolare')->first();

        // Create sample threads
        $threads = [
            [
                'title' => 'Cum să încep cu Laravel?',
                'content' => 'Salut! Sunt student în clasa a XII-a și vreau să învăț Laravel. Am cunoștințe de bază în PHP și MySQL. Cum ar trebui să încep? Ce resurse îmi recomandați?',
                'type' => 'question',
                'category_id' => $webDevCategory->id,
                'author_id' => $student->id,
                'tags' => ['Laravel', 'PHP', 'Începător'],
            ],
            [
                'title' => 'Cele mai bune practici în dezvoltarea web modernă',
                'content' => 'Văd că mulți studenți întreabă despre dezvoltarea web. Să discutăm despre cele mai importante practici și tehnologii pe care ar trebui să le învețe un dezvoltator web în 2024.',
                'type' => 'discussion',
                'category_id' => $webDevCategory->id,
                'author_id' => $teacher->id,
                'tags' => ['Web Development', 'Practici', '2024'],
                'is_featured' => true,
            ],
            [
                'title' => 'Cum să îmi fac un CV atractiv pentru joburi în IT?',
                'content' => 'Sunt aproape de absolvire și vreau să îmi fac un CV care să mă ajute să găsesc un job în domeniul IT. Ce ar trebui să includ? Cum să îl structuraz?',
                'type' => 'question',
                'category_id' => $careerCategory->id,
                'author_id' => $student->id,
                'tags' => ['CV', 'Joburi', 'IT'],
            ],
            [
                'title' => 'Workshop: Introducere în React și Vue.js',
                'content' => 'Vă anunț că în săptămâna viitoare vom organiza un workshop despre framework-urile moderne JavaScript. Vom învăța conceptele de bază ale React și Vue.js prin exemple practice.',
                'type' => 'announcement',
                'category_id' => $announcementsCategory->id,
                'author_id' => $teacher->id,
                'tags' => ['Workshop', 'React', 'Vue.js'],
                'status' => 'pinned',
            ],
            [
                'title' => 'Problema cu algoritmul de sortare',
                'content' => 'Am o problemă cu implementarea algoritmului QuickSort. Codul meu nu funcționează corect pentru anumite cazuri. Poate cineva să mă ajute să identific problema?',
                'type' => 'question',
                'category_id' => $programmingCategory->id,
                'author_id' => $student->id,
                'tags' => ['Algoritmi', 'QuickSort', 'Probleme'],
            ],
            [
                'title' => 'Resurse gratuite pentru învățarea programării',
                'content' => 'Am găsit niște resurse excelente și gratuite pentru învățarea programării. Să le împărtășesc cu voi și să discutăm despre care sunt cele mai utile.',
                'type' => 'discussion',
                'category_id' => $questionsCategory->id,
                'author_id' => $teacher->id,
                'tags' => ['Resurse', 'Gratuite', 'Învățare'],
            ],
        ];

        foreach ($threads as $threadData) {
            $thread = ForumThread::create($threadData);
            
            // Create some replies for each thread
            $this->createRepliesForThread($thread, $teacher, $student);
        }

        // Update category counts
        ForumCategory::all()->each(function ($category) {
            $category->updateCounts();
        });
    }

    private function createRepliesForThread($thread, $teacher, $student)
    {
        $replies = [
            [
                'content' => 'Pentru început, îți recomand să înveți conceptele de bază ale PHP și să înțelegi MVC. Apoi poți începe cu tutorialele oficiale Laravel.',
                'author_id' => $teacher->id,
            ],
            [
                'content' => 'Mulțumesc pentru sfat! Am început deja cu tutorialele oficiale și sunt foarte clare.',
                'author_id' => $student->id,
            ],
            [
                'content' => 'Nu uita să practici prin proiecte mici. Încearcă să faci un blog simplu cu Laravel.',
                'author_id' => $teacher->id,
            ],
        ];

        foreach ($replies as $replyData) {
            ForumPost::create(array_merge($replyData, [
                'thread_id' => $thread->id,
            ]));
        }

        // Update thread counts
        $thread->updateCounts();
    }
}
