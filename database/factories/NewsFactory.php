<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\News>
 */
class NewsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $titles = [
            'Liceul Tehnologic „Vasile Sav" organizează Târgul de Carieră 2024',
            'Rezultatele finale ale olimpiadelor școlare - felicitări elevilor noștri!',
            'Nouă parteneriat cu companii din domeniul IT pentru internship-uri',
            'Programul de mentorat pentru elevii din clasele terminale',
            'Workshop-uri de pregătire pentru examenele naționale',
            'Expoziția de proiecte tehnice - inovație și creativitate',
            'Colaborare cu Universitatea Tehnică pentru programe de excelență',
            'Campania de recrutare pentru anul școlar 2024-2025',
            'Rezultatele concursului de programare „Code Masters"',
            'Sesiunea de informare pentru părinți - orientare profesională',
            'Nouă laboratoare de informatică și robotică',
            'Participarea la competiții internaționale de tehnologie',
            'Programul de schimburi internaționale pentru elevi',
            'Sesiunea de certificări IT pentru elevii din anul terminal',
            'Colaborarea cu asociațiile de părinți pentru activități extracurriculare'
        ];

        $excerpts = [
            'O oportunitate excelentă pentru elevii noștri să se conecteze cu viitorii angajatori și să exploreze diverse cariere.',
            'Elevii noștri au obținut rezultate remarcabile la olimpiadele școlare, demonstrând excelența academică.',
            'Parteneriate strategice cu companii de top pentru a oferi experiențe practice valoroase.',
            'Programul de mentorat oferă suport personalizat pentru planificarea carierei.',
            'Workshop-uri specializate pentru pregătirea optimă a elevilor pentru examenele naționale.',
            'Elevii prezintă proiecte inovatoare care demonstrează abilitățile tehnice dobândite.',
            'Colaborarea cu universitățile oferă oportunități de dezvoltare academică avansată.',
            'Informații complete despre procesul de înscriere pentru anul școlar următor.',
            'Competiția de programare a pus în evidență talentele tehnice ale elevilor noștri.',
            'Sesiunea oferă părinților informații valoroase pentru orientarea profesională a copiilor.',
            'Laboratoarele moderne oferă condiții optime pentru învățarea tehnologiilor actuale.',
            'Participarea la competiții internaționale demonstrează nivelul de excelență al școlii.',
            'Programul de schimburi oferă experiențe interculturale valoroase.',
            'Certificările IT oferă avantaje competitive pe piața muncii.',
            'Colaborarea cu părinții asigură o abordare integrată a educației.'
        ];

        $bodies = [
            'Liceul Tehnologic „Vasile Sav" organizează în data de 15 mai 2024 Târgul de Carieră, un eveniment dedicat elevilor din clasele terminale. Evenimentul va reuni companii din diverse domenii, oferind oportunități de internship, mentorat și angajare directă. Programul include prezentări ale companiilor, workshop-uri interactive și sesiuni de networking. Toți elevii interesați sunt invitați să participe și să exploreze diversele oportunități de carieră disponibile.',
            
            'Felicităm elevii noștri care au obținut rezultate excepționale la olimpiadele școlare din acest an! La olimpiada de informatică, Maria Popescu a obținut locul I la nivel județean, iar la olimpiada de matematică, Andrei Ionescu a câștigat medalia de bronz. Rezultatele acestea reflectă munca depusă atât de elevi, cât și de cadrele didactice. Continuăm să investim în programele de excelență pentru a oferi elevilor noștri cele mai bune oportunități de dezvoltare.',
            
            'Liceul Tehnologic „Vasile Sav" a semnat parteneriate strategice cu companii de top din domeniul IT pentru a oferi elevilor noștri oportunități de internship valoroase. Parteneriatele includ companii precum Microsoft România, Endava și Accenture, care vor oferi programe de internship plătite pentru elevii din clasele XI și XII. Programul va include mentorat, proiecte practice și posibilitatea de angajare după absolvire. Elevii interesați pot aplica prin platforma școlii.',
            
            'Programul de mentorat pentru elevii din clasele terminale a fost lansat cu succes în această lună. Programul oferă suport personalizat pentru planificarea carierei, incluzând consiliere profesională, pregătire pentru interviuri și dezvoltarea abilităților soft. Mentorii sunt profesioniști cu experiență din diverse domenii, care își oferă timpul voluntar pentru a ghida elevii noștri. Programul se desfășoară în grupuri mici și individual, asigurând o abordare personalizată.',
            
            'Workshop-urile de pregătire pentru examenele naționale au început în această săptămână, oferind elevilor noștri suport specializat pentru examenele de bacalaureat. Programul include sesiuni de pregătire pentru toate materiile obligatorii, precum și pentru materiile de profil. Workshop-urile sunt conduse de profesori cu experiență în pregătirea pentru examene și includ materiale de studiu actualizate, teste practice și strategii de rezolvare a problemelor. Toți elevii din clasele terminale sunt invitați să participe.',
            
            'Expoziția de proiecte tehnice a fost un succes răsunător, demonstrând inovația și creativitatea elevilor noștri. Proiectele prezentate au inclus aplicații mobile, sisteme de automatizare, proiecte de robotică și soluții pentru probleme reale din comunitate. Juriu format din profesori și reprezentanți ai companiilor partenere a evaluat proiectele, iar câștigătorii au primit premii și oportunități de dezvoltare. Expoziția a fost deschisă publicului și a atras atenția multor vizitatori.',
            
            'Colaborarea cu Universitatea Tehnică din Iași a fost extinsă pentru a include programe de excelență pentru elevii noștri. Programul oferă cursuri universitare anticipate, mentorat academic și oportunități de cercetare pentru elevii cu rezultate excepționale. Colaborarea include și programe de formare continuă pentru cadrele didactice, asigurând actualizarea constantă a metodelor de predare. Elevii participanți vor primi credite universitare și vor avea avantaje la admiterea în facultate.',
            
            'Campania de recrutare pentru anul școlar 2024-2025 a fost lansată cu succes, oferind informații complete despre programele educaționale disponibile. Campania include prezentări în școlile din județ, zile deschise la liceu și materiale informative pentru părinți și elevi. Programele oferite includ specializări în informatică, mecanică, electrică și electronică, toate cu focus pe pregătirea pentru cariere tehnice moderne. Procesul de înscriere va începe în luna mai.',
            
            'Competiția de programare „Code Masters" a pus în evidență talentele tehnice ale elevilor noștri. Competiția a inclus probleme de algoritmică, dezvoltare web și programare orientată pe obiecte. Câștigătorii au demonstrat abilități excepționale de rezolvare a problemelor și creativitate în abordarea sarcinilor. Premiile au inclus echipamente IT, cursuri de specializare și oportunități de internship. Competiția va fi organizată anual, oferind elevilor oportunități constante de dezvoltare.',
            
            'Sesiunea de informare pentru părinți despre orientarea profesională a fost organizată cu succes, oferind informații valoroase despre opțiunile de carieră disponibile pentru elevii noștri. Sesiunea a inclus prezentări despre tendințele pieței muncii, programele educaționale disponibile și oportunitățile de dezvoltare profesională. Părinții au avut ocazia să întrebe întrebări și să primească consiliere personalizată. Sesiunea va fi organizată trimestrial pentru a oferi informații actualizate.',
            
            'Nouă laboratoare de informatică și robotică au fost inaugurate în această lună, oferind elevilor noștri condiții optime pentru învățarea tehnologiilor actuale. Laboratoarele sunt echipate cu calculatoare de ultimă generație, plăci de dezvoltare Arduino și Raspberry Pi, precum și cu echipamente de robotică. Laboratoarele vor fi folosite pentru cursurile de programare, robotică și electronică, oferind elevilor experiențe practice valoroase.',
            
            'Participarea la competiții internaționale demonstrează nivelul de excelență al școlii și oferă elevilor noștri oportunități de dezvoltare la nivel global. În acest an, elevii noștri au participat la competiții precum International Olympiad in Informatics, European Robotics Challenge și WorldSkills Competition. Rezultatele obținute demonstrează calitatea educației oferite și deschid oportunități de colaborare internațională.',
            
            'Programul de schimburi internaționale oferă elevilor noștri experiențe interculturale valoroase și oportunități de dezvoltare personală și profesională. Programul include schimburi cu școli din Europa și Statele Unite, oferind elevilor ocazia să învețe în medii educaționale diferite și să dezvolde abilități de comunicare interculturală. Schimburile includ și proiecte collaborative și activități culturale.',
            
            'Certificările IT oferă elevilor noștri avantaje competitive pe piața muncii și demonstrează competențele tehnice dobândite. Programul de certificări include cursuri pentru Microsoft Office Specialist, Adobe Certified Associate și Cisco IT Essentials. Certificările sunt recunoscute internațional și oferă elevilor credibilitate pe piața muncii. Programul este gratuit pentru toți elevii și include materiale de studiu și examene practice.',
            
            'Colaborarea cu asociațiile de părinți asigură o abordare integrată a educației și oferă suport pentru activitățile extracurriculare. Asociațiile de părinți participă activ la planificarea și organizarea activităților școlare, oferind suport financiar și logistic pentru proiecte educaționale. Colaborarea include și programe de formare pentru părinți și activități de voluntariat în comunitate.'
        ];

        $randomIndex = array_rand($titles);
        
        return [
            'title' => $titles[$randomIndex],
            'excerpt' => $excerpts[$randomIndex],
            'body' => $bodies[$randomIndex],
            'user_id' => User::factory()->state(['role' => 'teacher']),
            'published_at' => fake()->dateTimeBetween('-6 months', 'now'),
        ];
    }

    /**
     * Indicate that the news is published.
     */
    public function published(): static
    {
        return $this->state(fn (array $attributes) => [
            'published_at' => fake()->dateTimeBetween('-6 months', 'now'),
        ]);
    }

    /**
     * Indicate that the news is recent (last 30 days).
     */
    public function recent(): static
    {
        return $this->state(fn (array $attributes) => [
            'published_at' => fake()->dateTimeBetween('-30 days', 'now'),
        ]);
    }

    /**
     * Indicate that the news is featured.
     */
    public function featured(): static
    {
        return $this->state(fn (array $attributes) => [
            'published_at' => fake()->dateTimeBetween('-7 days', 'now'),
        ]);
    }
}
