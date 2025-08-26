<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class JobFactory extends Factory
{
    public function definition(): array
    {
        $titles = [
            'Dezvoltator Frontend Junior',
            'Programator Python Intern',
            'Designer UI/UX',
            'Dezvoltator Full Stack',
            'Administrator Sistem',
            'Tester Software',
            'Dezvoltator Mobile',
            'Analist Date',
            'Dezvoltator Backend',
            'DevOps Engineer',
            'Dezvoltator WordPress',
            'Programator Java',
            'Dezvoltator React',
            'Analist Securitate',
            'Dezvoltator .NET',
        ];

        $descriptions = [
            'Căutăm un dezvoltator frontend junior pentru a se alătura echipei noastre. Vei lucra cu tehnologii moderne precum React, Vue.js și CSS3.',
            'Oportunitate excelentă pentru studenți care doresc să învețe programare Python într-un mediu profesional.',
            'Căutăm un designer creativ pentru a dezvolta interfețe moderne și intuitive pentru aplicațiile noastre web.',
            'Dezvoltator full stack cu experiență în PHP, JavaScript și baze de date MySQL.',
            'Administrator de sisteme pentru întreținerea infrastructurii IT a companiei.',
            'Tester software pentru asigurarea calității aplicațiilor noastre.',
            'Dezvoltator mobile pentru aplicații iOS și Android folosind React Native.',
            'Analist de date pentru procesarea și analiza informațiilor companiei.',
            'Dezvoltator backend cu experiență în Laravel și API-uri RESTful.',
            'DevOps engineer pentru automatizarea proceselor de deployment.',
            'Dezvoltator WordPress pentru crearea și întreținerea site-urilor web.',
            'Programator Java pentru aplicații enterprise.',
            'Dezvoltator React pentru aplicații web moderne și interactive.',
            'Analist de securitate pentru protejarea sistemelor informatice.',
            'Dezvoltator .NET pentru aplicații desktop și web.',
        ];

        $requirements = [
            'Cunoștințe de bază în HTML, CSS și JavaScript',
            'Înțelegerea conceptelor de programare orientată pe obiecte',
            'Experiență cu Photoshop și Figma',
            'Cunoștințe în PHP, MySQL și JavaScript',
            'Înțelegerea sistemelor de operare Linux',
            'Atenție la detalii și gândire logică',
            'Cunoștințe în React Native sau Flutter',
            'Aptitudini analitice și de rezolvare a problemelor',
            'Experiență cu Laravel și API-uri',
            'Cunoștințe în Docker și CI/CD',
            'Experiență cu WordPress și PHP',
            'Cunoștințe în Java și Spring Framework',
            'Experiență cu React și Redux',
            'Cunoștințe în securitatea informatică',
            'Experiență cu C# și .NET Framework',
        ];

        $benefits = [
            'Program flexibil și posibilitatea de lucru remote',
            'Mentorat și training continuu',
            'Mediu de lucru modern și relaxat',
            'Salariu competitiv și beneficii sociale',
            'Oportunități de creștere profesională',
            'Echipă tânără și dinamică',
            'Tehnologii moderne și proiecte interesante',
            'Dezvoltare personală și profesională',
            'Work-life balance excelent',
            'Tehnologii de ultimă generație',
            'Libertate creativă și autonomie',
            'Proiecte diverse și provocatoare',
            'Mediu de învățare continuă',
            'Responsabilități și impact real',
            'Colaborare cu echipe internaționale',
        ];

        $locations = [
            'București',
            'Cluj-Napoca',
            'Timișoara',
            'Iași',
            'Craiova',
            'Brașov',
            'Sibiu',
            'Remote',
            'Hibrid',
        ];

        $skills = [
            ['HTML', 'CSS', 'JavaScript'],
            ['Python', 'Django', 'SQL'],
            ['Photoshop', 'Figma', 'Sketch'],
            ['PHP', 'Laravel', 'Vue.js'],
            ['Linux', 'Bash', 'Docker'],
            ['Selenium', 'JUnit', 'TestNG'],
            ['React Native', 'JavaScript', 'Redux'],
            ['SQL', 'Excel', 'Power BI'],
            ['PHP', 'Laravel', 'MySQL'],
            ['Docker', 'Kubernetes', 'AWS'],
            ['WordPress', 'PHP', 'MySQL'],
            ['Java', 'Spring', 'Maven'],
            ['React', 'Redux', 'TypeScript'],
            ['Kali Linux', 'Wireshark', 'Metasploit'],
            ['C#', '.NET', 'SQL Server'],
        ];

        $randomIndex = array_rand($titles);

        return [
            'title' => $titles[$randomIndex],
            'description' => $descriptions[$randomIndex],
            'requirements' => $requirements[$randomIndex],
            'benefits' => $benefits[$randomIndex],
            'type' => fake()->randomElement(['full-time', 'part-time', 'internship', 'mentorship', 'freelance']),
            'level' => fake()->randomElement(['entry', 'junior', 'mid', 'senior']),
            'status' => 'active',
            'location' => fake()->randomElement($locations),
            'remote_ok' => fake()->boolean(70),
            'hybrid_ok' => fake()->boolean(50),
            'salary_min' => fake()->numberBetween(2000, 8000),
            'salary_max' => fake()->numberBetween(8000, 15000),
            'salary_currency' => 'RON',
            'salary_negotiable' => fake()->boolean(80),
            'skills_required' => $skills[$randomIndex],
            'skills_preferred' => fake()->randomElements(['Git', 'Agile', 'Scrum', 'JIRA', 'Postman'], fake()->numberBetween(1, 3)),
            'positions_available' => fake()->numberBetween(1, 3),
            'application_deadline' => fake()->dateTimeBetween('now', '+2 months'),
            'start_date' => fake()->dateTimeBetween('+1 week', '+3 months'),
            'contact_email' => fake()->companyEmail(),
            'contact_phone' => fake()->phoneNumber(),
            'cv_required' => true,
            'cover_letter_required' => fake()->boolean(60),
            'application_instructions' => fake()->optional()->sentence(),
            'company_id' => User::factory()->state(['role' => 'company']),
            'published_at' => fake()->dateTimeBetween('-1 month', 'now'),
        ];
    }

    public function internship(): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => 'internship',
            'level' => 'entry',
            'salary_min' => fake()->numberBetween(1000, 3000),
            'salary_max' => fake()->numberBetween(3000, 5000),
        ]);
    }

    public function fullTime(): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => 'full-time',
            'salary_min' => fake()->numberBetween(5000, 10000),
            'salary_max' => fake()->numberBetween(10000, 20000),
        ]);
    }

    public function remote(): static
    {
        return $this->state(fn (array $attributes) => [
            'remote_ok' => true,
            'location' => 'Remote',
        ]);
    }

    public function entryLevel(): static
    {
        return $this->state(fn (array $attributes) => [
            'level' => 'entry',
            'salary_min' => fake()->numberBetween(2000, 5000),
            'salary_max' => fake()->numberBetween(5000, 8000),
        ]);
    }

    public function senior(): static
    {
        return $this->state(fn (array $attributes) => [
            'level' => 'senior',
            'salary_min' => fake()->numberBetween(10000, 15000),
            'salary_max' => fake()->numberBetween(15000, 25000),
        ]);
    }
}
