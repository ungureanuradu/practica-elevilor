<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\User;
use Illuminate\Database\Seeder;

class CoursesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get or create a teacher user for courses
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

        // Create sample courses using factory
        Course::factory(5)
            ->published()
            ->free()
            ->create(['instructor_id' => $teacher->id]);

        Course::factory(3)
            ->published()
            ->paid()
            ->create(['instructor_id' => $teacher->id]);

        // Create some specific featured courses
        $featuredCourses = [
            [
                'title' => 'Introducere în Programare cu Python',
                'description' => 'Un curs complet pentru începători care vrei să învețe programare de la zero. Vei învăța conceptele fundamentale ale programării, structuri de date, funcții și programare orientată pe obiecte folosind Python.',
                'excerpt' => 'Învață programare de la zero cu Python - curs complet pentru începători',
                'level' => 'beginner',
                'duration_hours' => 20,
                'is_free' => true,
                'price' => 0,
                'tags' => ['Python', 'Programare', 'Începători'],
                'requirements' => [
                    'Nu sunt necesare cunoștințe anterioare de programare',
                    'Un calculator cu acces la internet',
                    'Motivație pentru învățare'
                ],
                'learning_outcomes' => [
                    'Vei înțelege conceptele fundamentale ale programării',
                    'Vei putea scrie programe Python funcționale',
                    'Vei învăța să rezolvi probleme practice cu programare',
                    'Vei fi pregătit pentru cursuri avansate de programare'
                ],
                'status' => 'published',
                'published_at' => now()->subDays(10),
            ],
            [
                'title' => 'Dezvoltare Web cu Laravel și Vue.js',
                'description' => 'Curs avansat pentru dezvoltarea aplicațiilor web moderne folosind Laravel (backend) și Vue.js (frontend). Vei învăța să construiești aplicații web complete, de la baza de date până la interfața utilizator.',
                'excerpt' => 'Construiește aplicații web moderne cu Laravel și Vue.js',
                'level' => 'intermediate',
                'duration_hours' => 35,
                'is_free' => false,
                'price' => 299.99,
                'tags' => ['Laravel', 'Vue.js', 'PHP', 'JavaScript', 'Web Development'],
                'requirements' => [
                    'Cunoștințe de bază în PHP și JavaScript',
                    'Înțelegerea conceptelor de programare orientată pe obiecte',
                    'Experiență cu HTML și CSS'
                ],
                'learning_outcomes' => [
                    'Vei învăța să construiești aplicații web complete',
                    'Vei înțelege arhitectura MVC',
                    'Vei putea dezvolta API-uri RESTful',
                    'Vei învăța să integrezi frontend cu backend'
                ],
                'status' => 'published',
                'published_at' => now()->subDays(5),
            ],
            [
                'title' => 'Baze de Date și SQL',
                'description' => 'Curs complet despre baze de date relaționale și limbajul SQL. Vei învăța să proiectezi baze de date, să scrii interogări complexe și să optimizezi performanța.',
                'excerpt' => 'Învață să lucrezi cu baze de date relaționale și SQL',
                'level' => 'beginner',
                'duration_hours' => 15,
                'is_free' => true,
                'price' => 0,
                'tags' => ['SQL', 'Baze de Date', 'MySQL', 'PostgreSQL'],
                'requirements' => [
                    'Cunoștințe de bază în utilizarea calculatorului',
                    'Înțelegerea conceptelor de logică'
                ],
                'learning_outcomes' => [
                    'Vei învăța să proiectezi baze de date relaționale',
                    'Vei putea scrie interogări SQL complexe',
                    'Vei înțelege normalizarea bazei de date',
                    'Vei învăța să optimizezi performanța interogărilor'
                ],
                'status' => 'published',
                'published_at' => now()->subDays(15),
            ],
            [
                'title' => 'Machine Learning pentru Începători',
                'description' => 'Introducere în lumea fascinantă a Machine Learning-ului. Vei învăța algoritmi fundamentali, să prelucrezi date și să construiești modele predictive.',
                'excerpt' => 'Descoperă lumea Machine Learning-ului cu Python',
                'level' => 'intermediate',
                'duration_hours' => 40,
                'is_free' => false,
                'price' => 399.99,
                'tags' => ['Machine Learning', 'Python', 'AI', 'Data Science'],
                'requirements' => [
                    'Cunoștințe solide în Python',
                    'Înțelegerea matematicii de bază (algebră, statistică)',
                    'Motivație pentru învățarea conceptelor complexe'
                ],
                'learning_outcomes' => [
                    'Vei învăța algoritmi fundamentali de ML',
                    'Vei putea prelucra și analiza date',
                    'Vei construi modele predictive',
                    'Vei înțelege conceptele de overfitting și underfitting'
                ],
                'status' => 'published',
                'published_at' => now()->subDays(3),
            ],
            [
                'title' => 'Dezvoltare Mobile cu React Native',
                'description' => 'Învață să dezvolți aplicații mobile native pentru iOS și Android folosind React Native. Vei construi aplicații reale și vei învăța să le publici pe app stores.',
                'excerpt' => 'Construiește aplicații mobile native cu React Native',
                'level' => 'advanced',
                'duration_hours' => 30,
                'is_free' => false,
                'price' => 349.99,
                'tags' => ['React Native', 'Mobile Development', 'JavaScript', 'iOS', 'Android'],
                'requirements' => [
                    'Cunoștințe solide în JavaScript și React',
                    'Înțelegerea conceptelor de programare asincronă',
                    'Un Mac pentru dezvoltarea iOS (opțional)'
                ],
                'learning_outcomes' => [
                    'Vei învăța să construiești aplicații mobile native',
                    'Vei înțelege diferențele între iOS și Android',
                    'Vei putea publica aplicații pe app stores',
                    'Vei învăța să optimizezi performanța aplicațiilor mobile'
                ],
                'status' => 'published',
                'published_at' => now()->subDays(7),
            ],
        ];

        foreach ($featuredCourses as $courseData) {
            Course::create(array_merge($courseData, ['instructor_id' => $teacher->id]));
        }
    }
}
