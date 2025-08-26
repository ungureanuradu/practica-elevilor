<?php

namespace Database\Seeders;

use App\Models\CalendarCategory;
use App\Models\CalendarEvent;
use App\Models\User;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class CalendarSeeder extends Seeder
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

        // Create calendar categories
        $categories = [
            [
                'name' => 'Cursuri și Seminarii',
                'description' => 'Evenimente educaționale, cursuri și seminarii',
                'color' => '#3B82F6',
                'icon' => 'fas fa-chalkboard-teacher',
                'order' => 1,
                'access_level' => 'public',
            ],
            [
                'name' => 'Workshop-uri',
                'description' => 'Workshop-uri practice și hands-on',
                'color' => '#10B981',
                'icon' => 'fas fa-tools',
                'order' => 2,
                'access_level' => 'public',
            ],
            [
                'name' => 'Evenimente Sociale',
                'description' => 'Evenimente sociale și networking',
                'color' => '#F59E0B',
                'icon' => 'fas fa-users',
                'order' => 3,
                'access_level' => 'public',
            ],
            [
                'name' => 'Competiții',
                'description' => 'Competiții de programare și hackathon-uri',
                'color' => '#EF4444',
                'icon' => 'fas fa-trophy',
                'order' => 4,
                'access_level' => 'students',
            ],
            [
                'name' => 'Prezentări',
                'description' => 'Prezentări de proiecte și lucrări',
                'color' => '#8B5CF6',
                'icon' => 'fas fa-presentation',
                'order' => 5,
                'access_level' => 'public',
            ],
            [
                'name' => 'Întâlniri Administrative',
                'description' => 'Întâlniri administrative și organizatorice',
                'color' => '#6B7280',
                'icon' => 'fas fa-briefcase',
                'order' => 6,
                'access_level' => 'teachers',
            ],
        ];

        $createdCategories = [];
        foreach ($categories as $categoryData) {
            $category = CalendarCategory::create($categoryData);
            $createdCategories[] = $category;
        }

        // Create sample calendar events
        $events = [
            // Cursuri și Seminarii
            [
                'title' => 'Introducere în Laravel Framework',
                'description' => 'Curs introductiv despre Laravel Framework pentru începători. Vom învăța conceptele de bază, MVC, routing, și Eloquent ORM.',
                'excerpt' => 'Curs introductiv Laravel Framework',
                'location' => 'Sala 101, Liceul Tehnologic',
                'type' => 'single',
                'status' => 'published',
                'is_featured' => true,
                'requires_registration' => true,
                'max_participants' => 30,
                'start_date' => Carbon::now()->addDays(3)->setTime(14, 0),
                'end_date' => Carbon::now()->addDays(3)->setTime(16, 0),
                'organizer_id' => $teacher->id,
                'category_id' => $createdCategories[0]->id,
            ],
            [
                'title' => 'Vue.js pentru Frontend Development',
                'description' => 'Workshop practic despre Vue.js. Vom construi o aplicație completă folosind Vue 3 și Composition API.',
                'excerpt' => 'Workshop Vue.js practic',
                'location' => 'Laboratorul de Informatică',
                'type' => 'single',
                'status' => 'published',
                'is_featured' => false,
                'requires_registration' => true,
                'max_participants' => 20,
                'start_date' => Carbon::now()->addDays(7)->setTime(10, 0),
                'end_date' => Carbon::now()->addDays(7)->setTime(13, 0),
                'organizer_id' => $teacher->id,
                'category_id' => $createdCategories[1]->id,
            ],
            [
                'title' => 'Database Design și SQL',
                'description' => 'Seminariu despre designul bazelor de date și optimizarea query-urilor SQL.',
                'excerpt' => 'Design baze de date și SQL',
                'location' => 'Sala 203',
                'type' => 'single',
                'status' => 'published',
                'is_featured' => false,
                'requires_registration' => false,
                'start_date' => Carbon::now()->addDays(10)->setTime(15, 30),
                'end_date' => Carbon::now()->addDays(10)->setTime(17, 30),
                'organizer_id' => $teacher->id,
                'category_id' => $createdCategories[0]->id,
            ],
            // Evenimente Sociale
            [
                'title' => 'Networking Evening pentru Studenți',
                'description' => 'O seară de networking pentru studenții de informatică. Oportunitate de a cunoaște alți studenți și profesioniști din domeniu.',
                'excerpt' => 'Networking pentru studenți',
                'location' => 'Cafeneaua Studențească',
                'type' => 'single',
                'status' => 'published',
                'is_featured' => true,
                'requires_registration' => true,
                'max_participants' => 50,
                'start_date' => Carbon::now()->addDays(5)->setTime(18, 0),
                'end_date' => Carbon::now()->addDays(5)->setTime(21, 0),
                'organizer_id' => $student->id,
                'category_id' => $createdCategories[2]->id,
            ],
            // Competiții
            [
                'title' => 'Hackathon 2024 - Inovație în Educație',
                'description' => 'Competiție de programare de 24 de ore. Echipele vor dezvolta soluții inovatoare pentru îmbunătățirea educației prin tehnologie.',
                'excerpt' => 'Hackathon 24h - Inovație în Educație',
                'location' => 'Centrul de Conferințe',
                'type' => 'all-day',
                'status' => 'published',
                'is_featured' => true,
                'requires_registration' => true,
                'max_participants' => 100,
                'start_date' => Carbon::now()->addDays(14)->setTime(9, 0),
                'end_date' => Carbon::now()->addDays(15)->setTime(9, 0),
                'organizer_id' => $teacher->id,
                'category_id' => $createdCategories[3]->id,
            ],
            [
                'title' => 'Competiția de Algoritmi',
                'description' => 'Competiție de algoritmi pentru studenți. Probleme de dificultate variabilă, de la începători la avansați.',
                'excerpt' => 'Competiție algoritmi pentru studenți',
                'location' => 'Laboratorul de Informatică',
                'type' => 'single',
                'status' => 'published',
                'is_featured' => false,
                'requires_registration' => true,
                'max_participants' => 40,
                'start_date' => Carbon::now()->addDays(12)->setTime(14, 0),
                'end_date' => Carbon::now()->addDays(12)->setTime(17, 0),
                'organizer_id' => $teacher->id,
                'category_id' => $createdCategories[3]->id,
            ],
            // Prezentări
            [
                'title' => 'Prezentarea Proiectelor de Licență',
                'description' => 'Prezentarea proiectelor de licență ale studenților din anul terminal. Oportunitate de a vedea proiecte inovatoare.',
                'excerpt' => 'Prezentare proiecte licență',
                'location' => 'Aula Mare',
                'type' => 'single',
                'status' => 'published',
                'is_featured' => true,
                'requires_registration' => false,
                'start_date' => Carbon::now()->addDays(8)->setTime(10, 0),
                'end_date' => Carbon::now()->addDays(8)->setTime(16, 0),
                'organizer_id' => $teacher->id,
                'category_id' => $createdCategories[4]->id,
            ],
            // Evenimente recurente
            [
                'title' => 'Clubul de Programare - Săptămânal',
                'description' => 'Întâlnirea săptămânală a clubului de programare. Discutăm despre proiecte, tehnologii noi și rezolvăm probleme împreună.',
                'excerpt' => 'Club programare săptămânal',
                'location' => 'Sala 105',
                'type' => 'recurring',
                'status' => 'published',
                'is_featured' => false,
                'requires_registration' => false,
                'start_date' => Carbon::now()->next(Carbon::FRIDAY)->setTime(16, 0),
                'end_date' => Carbon::now()->next(Carbon::FRIDAY)->setTime(18, 0),
                'recurrence_rules' => [
                    'frequency' => 'weekly',
                    'interval' => 1,
                    'by_day' => ['FR'],
                    'until' => Carbon::now()->addMonths(6)->format('Y-m-d'),
                ],
                'organizer_id' => $student->id,
                'category_id' => $createdCategories[2]->id,
            ],
            // Evenimente din trecut
            [
                'title' => 'Workshop Git și GitHub',
                'description' => 'Workshop despre controlul versiunilor cu Git și colaborarea pe GitHub.',
                'excerpt' => 'Workshop Git și GitHub',
                'location' => 'Laboratorul de Informatică',
                'type' => 'single',
                'status' => 'published',
                'is_featured' => false,
                'requires_registration' => false,
                'start_date' => Carbon::now()->subDays(5)->setTime(14, 0),
                'end_date' => Carbon::now()->subDays(5)->setTime(16, 0),
                'organizer_id' => $teacher->id,
                'category_id' => $createdCategories[1]->id,
            ],
            [
                'title' => 'Întâlnirea Consiliului Profesoral',
                'description' => 'Întâlnirea lunară a consiliului profesoral pentru discutarea problemelor administrative.',
                'excerpt' => 'Consiliu profesoral lunar',
                'location' => 'Sala Consiliului',
                'type' => 'single',
                'status' => 'published',
                'is_featured' => false,
                'requires_registration' => false,
                'start_date' => Carbon::now()->subDays(2)->setTime(9, 0),
                'end_date' => Carbon::now()->subDays(2)->setTime(11, 0),
                'organizer_id' => $teacher->id,
                'category_id' => $createdCategories[5]->id,
            ],
        ];

        foreach ($events as $eventData) {
            CalendarEvent::create($eventData);
        }

        // Update category counts
        CalendarCategory::all()->each(function ($category) {
            $category->updateCounts();
        });

        echo "Calendar data seeded successfully!\n";
        echo "Created " . count($createdCategories) . " categories and " . count($events) . " events.\n";
    }
}
