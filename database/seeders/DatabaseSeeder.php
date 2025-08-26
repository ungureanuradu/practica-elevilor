<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create some test users
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

        // Call the seeders
        $this->call([
            CoursesSeeder::class,
            NewsSeeder::class,
            JobsSeeder::class,
            ForumSeeder::class,
            DocumentsSeeder::class,
            GroupsSeeder::class,
            CalendarSeeder::class,
        ]);
    }
}
