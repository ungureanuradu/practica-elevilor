<?php

namespace Database\Seeders;

use App\Models\Group;
use App\Models\GroupMember;
use App\Models\GroupTopic;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class GroupsSeeder extends Seeder
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

        // Create sample groups
        $groups = [
            [
                'name' => 'Programatori PHP',
                'description' => 'Grup pentru studenții și profesorii interesați de programarea în PHP. Discutăm despre Laravel, Symfony, și alte framework-uri PHP.',
                'excerpt' => 'Comunitate pentru programatori PHP',
                'type' => 'public',
                'category' => 'academic',
                'tags' => ['PHP', 'Laravel', 'Programare', 'Web Development'],
                'max_members' => 100,
                'owner_id' => $teacher->id,
                'moderator_id' => $teacher->id,
            ],
            [
                'name' => 'Frontend Developers',
                'description' => 'Grup dedicat dezvoltării frontend. Discutăm despre HTML, CSS, JavaScript, React, Vue.js și alte tehnologii frontend.',
                'excerpt' => 'Comunitate pentru dezvoltatori frontend',
                'type' => 'public',
                'category' => 'professional',
                'tags' => ['Frontend', 'JavaScript', 'React', 'Vue.js', 'CSS'],
                'max_members' => 50,
                'owner_id' => $student->id,
                'moderator_id' => $teacher->id,
            ],
            [
                'name' => 'Proiecte Studențești',
                'description' => 'Grup pentru coordonarea și prezentarea proiectelor studențești. Aici studenții pot găsi parteneri pentru proiecte și pot prezenta lucrările lor.',
                'excerpt' => 'Coordonare proiecte studențești',
                'type' => 'public',
                'category' => 'project',
                'tags' => ['Proiecte', 'Studenți', 'Colaborare'],
                'max_members' => 200,
                'owner_id' => $teacher->id,
                'moderator_id' => $teacher->id,
            ],
            [
                'name' => 'Machine Learning Enthusiasts',
                'description' => 'Grup pentru pasionații de Machine Learning și AI. Discutăm despre algoritmi, modele, și aplicații practice ale ML.',
                'excerpt' => 'Comunitate pentru Machine Learning',
                'type' => 'private',
                'category' => 'academic',
                'tags' => ['Machine Learning', 'AI', 'Python', 'Data Science'],
                'max_members' => 75,
                'owner_id' => $teacher->id,
                'moderator_id' => $teacher->id,
            ],
            [
                'name' => 'Mobile Development',
                'description' => 'Grup pentru dezvoltarea aplicațiilor mobile. Discutăm despre React Native, Flutter, iOS, Android și alte tehnologii mobile.',
                'excerpt' => 'Dezvoltare aplicații mobile',
                'type' => 'public',
                'category' => 'professional',
                'tags' => ['Mobile', 'React Native', 'Flutter', 'iOS', 'Android'],
                'max_members' => 60,
                'owner_id' => $student->id,
                'moderator_id' => $student->id,
            ],
            [
                'name' => 'Baze de Date',
                'description' => 'Grup pentru discuții despre baze de date relaționale și NoSQL. MySQL, PostgreSQL, MongoDB, și optimizarea performanței.',
                'excerpt' => 'Discuții despre baze de date',
                'type' => 'public',
                'category' => 'academic',
                'tags' => ['Baze de Date', 'SQL', 'MySQL', 'PostgreSQL', 'MongoDB'],
                'max_members' => 80,
                'owner_id' => $teacher->id,
                'moderator_id' => $teacher->id,
            ],
            [
                'name' => 'Cybersecurity',
                'description' => 'Grup pentru discuții despre securitatea informatică, hacking etic, și protecția datelor.',
                'excerpt' => 'Securitate informatică',
                'type' => 'private',
                'category' => 'professional',
                'tags' => ['Cybersecurity', 'Hacking', 'Securitate', 'Protecție'],
                'max_members' => 40,
                'owner_id' => $teacher->id,
                'moderator_id' => $teacher->id,
            ],
            [
                'name' => 'Gaming & Game Development',
                'description' => 'Grup pentru pasionații de jocuri și dezvoltarea de jocuri. Unity, Unreal Engine, și design de jocuri.',
                'excerpt' => 'Jocuri și dezvoltare de jocuri',
                'type' => 'public',
                'category' => 'hobby',
                'tags' => ['Gaming', 'Game Development', 'Unity', 'Unreal Engine'],
                'max_members' => 90,
                'owner_id' => $student->id,
                'moderator_id' => $student->id,
            ],
        ];

        foreach ($groups as $groupData) {
            $group = Group::create($groupData);
            
            // Add owner as member
            GroupMember::create([
                'group_id' => $group->id,
                'user_id' => $group->owner_id,
                'role' => 'owner',
                'status' => 'active',
                'joined_at' => now(),
                'last_activity_at' => now(),
            ]);

            // Add moderator as member if different from owner
            if ($group->moderator_id && $group->moderator_id !== $group->owner_id) {
                GroupMember::create([
                    'group_id' => $group->id,
                    'user_id' => $group->moderator_id,
                    'role' => 'moderator',
                    'status' => 'active',
                    'joined_at' => now(),
                    'last_activity_at' => now(),
                ]);
            }

            // Add some random members
            $randomMembers = rand(5, 15);
            $addedMembers = 0;
            $maxAttempts = 50; // Prevent infinite loop
            $attempts = 0;
            
            while ($addedMembers < $randomMembers && $attempts < $maxAttempts) {
                $randomUser = User::inRandomOrder()->first();
                if ($randomUser && 
                    $randomUser->id !== $group->owner_id && 
                    $randomUser->id !== $group->moderator_id &&
                    !GroupMember::where('group_id', $group->id)->where('user_id', $randomUser->id)->exists()) {
                    
                    GroupMember::create([
                        'group_id' => $group->id,
                        'user_id' => $randomUser->id,
                        'role' => 'member',
                        'status' => 'active',
                        'joined_at' => now()->subDays(rand(1, 30)),
                        'last_activity_at' => now()->subDays(rand(0, 7)),
                    ]);
                    $addedMembers++;
                }
                $attempts++;
            }

            // Create topics for each group
            $this->createTopicsForGroup($group);
        }

        // Update group counts
        Group::all()->each(function ($group) {
            $group->updateCounts();
        });
    }

    private function createTopicsForGroup($group)
    {
        $topics = [
            [
                'name' => 'Anunțuri',
                'description' => 'Anunțuri importante despre grup',
                'icon' => 'fas fa-bullhorn',
                'color' => '#EF4444',
                'order' => 1,
                'is_pinned' => true,
                'is_public' => true,
            ],
            [
                'name' => 'Discuții Generale',
                'description' => 'Discuții generale despre subiectul grupului',
                'icon' => 'fas fa-comments',
                'color' => '#3B82F6',
                'order' => 2,
                'is_pinned' => false,
                'is_public' => true,
            ],
            [
                'name' => 'Întrebări și Răspunsuri',
                'description' => 'Pune întrebări și găsește răspunsuri',
                'icon' => 'fas fa-question-circle',
                'color' => '#10B981',
                'order' => 3,
                'is_pinned' => false,
                'is_public' => true,
            ],
            [
                'name' => 'Resurse',
                'description' => 'Resurse utile și materiale de studiu',
                'icon' => 'fas fa-book',
                'color' => '#8B5CF6',
                'order' => 4,
                'is_pinned' => false,
                'is_public' => true,
            ],
            [
                'name' => 'Proiecte',
                'description' => 'Discuții despre proiecte și colaborări',
                'icon' => 'fas fa-project-diagram',
                'color' => '#F59E0B',
                'order' => 5,
                'is_pinned' => false,
                'is_public' => true,
            ],
        ];

        foreach ($topics as $topicData) {
            GroupTopic::create(array_merge($topicData, [
                'group_id' => $group->id,
                'slug' => Str::slug($topicData['name']) . '-' . $group->id, // Make slug unique per group
            ]));
        }
    }
}
