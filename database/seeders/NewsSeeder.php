<?php

namespace Database\Seeders;

use App\Models\News;
use App\Models\User;
use Illuminate\Database\Seeder;

class NewsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get or create a teacher user for news articles
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

        // Create sample news articles
        News::factory(10)
            ->published()
            ->create(['user_id' => $teacher->id]);

        News::factory(5)
            ->recent()
            ->create(['user_id' => $teacher->id]);

        News::factory(3)
            ->featured()
            ->create(['user_id' => $teacher->id]);

        // Create some specific featured news articles
        $featuredNews = [
            [
                'title' => 'Liceul Tehnologic „Vasile Sav" organizează Târgul de Carieră 2024',
                'excerpt' => 'O oportunitate excelentă pentru elevii noștri să se conecteze cu viitorii angajatori și să exploreze diverse cariere.',
                'body' => 'Liceul Tehnologic „Vasile Sav" organizează în data de 15 mai 2024 Târgul de Carieră, un eveniment dedicat elevilor din clasele terminale. Evenimentul va reuni companii din diverse domenii, oferind oportunități de internship, mentorat și angajare directă. Programul include prezentări ale companiilor, workshop-uri interactive și sesiuni de networking. Toți elevii interesați sunt invitați să participe și să exploreze diversele oportunități de carieră disponibile.',
                'published_at' => now()->subDays(2),
            ],
            [
                'title' => 'Rezultatele finale ale olimpiadelor școlare - felicitări elevilor noștri!',
                'excerpt' => 'Elevii noștri au obținut rezultate remarcabile la olimpiadele școlare, demonstrând excelența academică.',
                'body' => 'Felicităm elevii noștri care au obținut rezultate excepționale la olimpiadele școlare din acest an! La olimpiada de informatică, Maria Popescu a obținut locul I la nivel județean, iar la olimpiada de matematică, Andrei Ionescu a câștigat medalia de bronz. Rezultatele acestea reflectă munca depusă atât de elevi, cât și de cadrele didactice. Continuăm să investim în programele de excelență pentru a oferi elevilor noștri cele mai bune oportunități de dezvoltare.',
                'published_at' => now()->subDays(5),
            ],
            [
                'title' => 'Nouă parteneriat cu companii din domeniul IT pentru internship-uri',
                'excerpt' => 'Parteneriate strategice cu companii de top pentru a oferi experiențe practice valoroase.',
                'body' => 'Liceul Tehnologic „Vasile Sav" a semnat parteneriate strategice cu companii de top din domeniul IT pentru a oferi elevilor noștri oportunități de internship valoroase. Parteneriatele includ companii precum Microsoft România, Endava și Accenture, care vor oferi programe de internship plătite pentru elevii din clasele XI și XII. Programul va include mentorat, proiecte practice și posibilitatea de angajare după absolvire. Elevii interesați pot aplica prin platforma școlii.',
                'published_at' => now()->subDays(1),
            ],
        ];

        foreach ($featuredNews as $newsData) {
            News::create(array_merge($newsData, ['user_id' => $teacher->id]));
        }
    }
}
