<?php

namespace Database\Seeders;

use App\Models\Job;
use App\Models\User;
use Illuminate\Database\Seeder;

class JobsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get or create company users
        $companies = [
            [
                'name' => 'TechCorp Solutions',
                'email' => 'hr@techcorp.ro',
                'role' => 'company',
                'company_name' => 'TechCorp Solutions',
                'company_type' => 'Software Development',
                'company_size' => 75,
                'website' => 'https://techcorp.ro',
                'company_description' => 'Companie de dezvoltare software cu focus pe soluții moderne și inovatoare.',
            ],
            [
                'name' => 'Digital Innovations',
                'email' => 'careers@digitalinnovations.ro',
                'role' => 'company',
                'company_name' => 'Digital Innovations',
                'company_type' => 'Web Development',
                'company_size' => 35,
                'website' => 'https://digitalinnovations.ro',
                'company_description' => 'Agenție de dezvoltare web specializată în crearea de experiențe digitale excepționale.',
            ],
            [
                'name' => 'StartupHub',
                'email' => 'jobs@startuphub.ro',
                'role' => 'company',
                'company_name' => 'StartupHub',
                'company_type' => 'Technology',
                'company_size' => 15,
                'website' => 'https://startuphub.ro',
                'company_description' => 'Startup inovativ în domeniul tehnologiei, focusat pe soluții creative și moderne.',
            ],
        ];

        foreach ($companies as $companyData) {
            User::firstOrCreate(
                ['email' => $companyData['email']],
                array_merge($companyData, [
                    'password' => bcrypt('password'),
                    'email_verified_at' => now(),
                ])
            );
        }

        // Get company users
        $companyUsers = User::where('role', 'company')->get();

        // Create sample jobs using factory
        foreach ($companyUsers as $company) {
            // Create 3-5 jobs per company
            $jobCount = rand(3, 5);
            
            Job::factory($jobCount)
                ->create(['company_id' => $company->id]);

            // Create some specific job types
            Job::factory()->internship()->create(['company_id' => $company->id]);
            Job::factory()->fullTime()->create(['company_id' => $company->id]);
            Job::factory()->remote()->create(['company_id' => $company->id]);
        }

        // Create some specific featured jobs
        $featuredJobs = [
            [
                'title' => 'Dezvoltator Frontend Intern',
                'description' => 'Oportunitate excelentă pentru studenți pasionați de dezvoltare web. Vei învăța să lucrezi cu React, Vue.js și tehnologii moderne într-un mediu profesional și prietenos.',
                'requirements' => 'Cunoștințe de bază în HTML, CSS și JavaScript. Motivație pentru învățare și dorința de a dezvolta aplicații web moderne.',
                'benefits' => 'Mentorat personalizat, program flexibil, posibilitatea de lucru remote, proiecte reale și oportunități de angajare după internship.',
                'type' => 'internship',
                'level' => 'entry',
                'location' => 'București',
                'remote_ok' => true,
                'hybrid_ok' => true,
                'salary_min' => 2000,
                'salary_max' => 3500,
                'skills_required' => ['HTML', 'CSS', 'JavaScript'],
                'skills_preferred' => ['React', 'Git', 'Responsive Design'],
                'positions_available' => 2,
                'application_deadline' => now()->addMonths(1),
                'start_date' => now()->addWeeks(2),
                'cv_required' => true,
                'cover_letter_required' => true,
                'application_instructions' => 'Te rugăm să incluzi în cover letter motivația ta pentru această poziție și ce proiecte personale ai dezvoltat.',
            ],
            [
                'title' => 'Dezvoltator Full Stack Junior',
                'description' => 'Căutăm un dezvoltator full stack junior pentru a se alătura echipei noastre. Vei lucra cu tehnologii moderne precum Laravel, Vue.js și MySQL.',
                'requirements' => 'Cunoștințe în PHP, MySQL și JavaScript. Înțelegerea conceptelor de programare orientată pe obiecte și arhitectura MVC.',
                'benefits' => 'Salariu competitiv, program flexibil, tehnologii moderne, oportunități de creștere profesională și echipă tânără și dinamică.',
                'type' => 'full-time',
                'level' => 'junior',
                'location' => 'Cluj-Napoca',
                'remote_ok' => false,
                'hybrid_ok' => true,
                'salary_min' => 6000,
                'salary_max' => 9000,
                'skills_required' => ['PHP', 'Laravel', 'MySQL', 'JavaScript'],
                'skills_preferred' => ['Vue.js', 'Git', 'Docker'],
                'positions_available' => 1,
                'application_deadline' => now()->addWeeks(3),
                'start_date' => now()->addWeeks(4),
                'cv_required' => true,
                'cover_letter_required' => false,
            ],
            [
                'title' => 'Dezvoltator Mobile Remote',
                'description' => 'Oportunitate pentru dezvoltatori mobile pasionați de React Native. Vei lucra la aplicații mobile moderne pentru iOS și Android.',
                'requirements' => 'Cunoștințe în React Native sau Flutter. Experiență cu JavaScript și înțelegerea conceptelor de dezvoltare mobile.',
                'benefits' => 'Lucru complet remote, program flexibil, tehnologii moderne, proiecte diverse și libertate creativă.',
                'type' => 'full-time',
                'level' => 'mid',
                'location' => 'Remote',
                'remote_ok' => true,
                'hybrid_ok' => false,
                'salary_min' => 8000,
                'salary_max' => 12000,
                'skills_required' => ['React Native', 'JavaScript', 'Redux'],
                'skills_preferred' => ['TypeScript', 'Firebase', 'App Store Connect'],
                'positions_available' => 1,
                'application_deadline' => now()->addWeeks(2),
                'start_date' => now()->addWeeks(3),
                'cv_required' => true,
                'cover_letter_required' => true,
                'application_instructions' => 'Te rugăm să incluzi link-uri către aplicațiile mobile pe care le-ai dezvoltat.',
            ],
            [
                'title' => 'DevOps Engineer',
                'description' => 'Căutăm un DevOps engineer pentru a automatiza procesele de deployment și a întreține infrastructura cloud a companiei.',
                'requirements' => 'Cunoștințe în Docker, Kubernetes și AWS. Experiență cu sisteme Linux și scripting Bash.',
                'benefits' => 'Salariu competitiv, tehnologii de ultimă generație, responsabilități și impact real, colaborare cu echipe internaționale.',
                'type' => 'full-time',
                'level' => 'senior',
                'location' => 'Timișoara',
                'remote_ok' => true,
                'hybrid_ok' => true,
                'salary_min' => 12000,
                'salary_max' => 18000,
                'skills_required' => ['Docker', 'Kubernetes', 'AWS', 'Linux'],
                'skills_preferred' => ['Terraform', 'Jenkins', 'Prometheus'],
                'positions_available' => 1,
                'application_deadline' => now()->addWeeks(4),
                'start_date' => now()->addWeeks(6),
                'cv_required' => true,
                'cover_letter_required' => true,
            ],
            [
                'title' => 'Designer UI/UX Intern',
                'description' => 'Oportunitate pentru studenți pasionați de design. Vei învăța să creezi interfețe moderne și intuitive pentru aplicațiile web.',
                'requirements' => 'Cunoștințe de bază în Photoshop sau Figma. Simț artistic și atenție la detalii.',
                'benefits' => 'Mentorat de designeri experimentați, proiecte reale, portofoliu profesional și oportunități de angajare.',
                'type' => 'internship',
                'level' => 'entry',
                'location' => 'Iași',
                'remote_ok' => false,
                'hybrid_ok' => true,
                'salary_min' => 1500,
                'salary_max' => 2500,
                'skills_required' => ['Photoshop', 'Figma'],
                'skills_preferred' => ['Sketch', 'Adobe XD', 'Prototyping'],
                'positions_available' => 1,
                'application_deadline' => now()->addWeeks(2),
                'start_date' => now()->addWeeks(3),
                'cv_required' => true,
                'cover_letter_required' => true,
                'application_instructions' => 'Te rugăm să incluzi portofoliul tău cu exemple de design.',
            ],
        ];

        foreach ($featuredJobs as $jobData) {
            $company = $companyUsers->random();
            Job::create(array_merge($jobData, [
                'company_id' => $company->id,
                'status' => 'active',
                'published_at' => now()->subDays(rand(1, 30)),
                'contact_email' => $company->email,
                'contact_phone' => fake()->phoneNumber(),
            ]));
        }
    }
}
