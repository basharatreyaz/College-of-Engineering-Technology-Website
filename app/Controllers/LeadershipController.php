<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Services\View;

class LeadershipController
{
    /**
     * Retrieve leadership profile data dynamically from site_settings.
     */
    private function getLeaderData(string $role): ?array
    {
        $role = strtolower(trim($role));

        $leaders = [
            'chairman' => [
                'role_key' => 'chairman',
                'route' => '/chairmans-message',
                'title' => "From the Chairman's Desk",
                'nav_label' => "Chairman's Message",
                'page_title' => "Chairman's Message | Kashmir College of Engineering & Technology",
                'meta_description' => "Official address and institutional vision from Er. Raja Aijaz Ali (Retd. IPS / IGP), Chairman of Kashmir College of Engineering & Technology Srinagar.",
                'badge' => 'FOUNDATION & GOVERNING COUNCIL',
                'theme_color' => '#1E3A8A',
                'badge_color' => '#1E3A8A',
                'name' => setting('chairman_name', 'Er. Raja Aijaz Ali (Retd. IPS / IGP)'),
                'designation' => setting('chairman_designation', 'Chairman, Kashmir College of Engineering & Technology'),
                'qualifications' => 'B.E. (Electronics & Communication Engineering), Former IGP, J&K',
                'photo' => setting('chairman_photo', 'assets/images/faculty-hod-cse.jpg'),
                'default_photo' => 'assets/images/chairman-portrait.svg',
                'quote' => setting('chairman_quote', 'Drawing from my engineering background and understanding the hardships students face when traveling outside the valley, KCET was established to provide state-of-the-art technical education right here in Kashmir.'),
                'message' => setting('chairman_message', 'Kashmir College of Engineering & Technology was established with a singular, resolute mission: to build a premier institution of technical excellence within the Kashmir valley so that aspiring engineering students do not have to endure the hardships of traveling outside the region to attain high-quality accredited technical education. Having served in public administration and holding a background in engineering, I envisioned KCET as a center of rigorous academic inquiry, cutting-edge computing laboratories, and ethical leadership. With our modern campus in Ranbirgarh, distinguished faculty, and approval from AICTE alongside affiliation with the University of Kashmir, we provide an inspiring environment where youth can realize their highest engineering ambitions.'),
                'office' => 'Office of the Chairman',
                'email' => 'chairman@kcet.edu.in',
                'phone' => setting('phone_primary', '+91 88994 12793'),
                'tenure' => 'Founder & Chairman, KCET',
                'focus_pillars' => [
                    'Democratizing accredited engineering education across Jammu & Kashmir',
                    'Eliminating the need for local students to travel outside the valley for quality B.Tech degrees',
                    'Strategic capital investment in high-performance computing, AI, and testing workshops',
                    'Ethical corporate governance, student scholarships, and long-term institutional vision'
                ]
            ],
            'director' => [
                'role_key' => 'director',
                'route' => '/directors-message',
                'title' => "From the Director's Desk",
                'nav_label' => "Director's Message",
                'page_title' => "Director's Message | Kashmir College of Engineering & Technology",
                'meta_description' => "Official address by Er. Raja Minad Aijaz, Director of Kashmir College of Engineering & Technology Srinagar on campus infrastructure and development.",
                'badge' => 'CAMPUS STEWARDSHIP & ADMINISTRATION',
                'theme_color' => '#0D5C4A',
                'badge_color' => '#0D5C4A',
                'name' => setting('director_name', 'Er. Raja Minad Aijaz'),
                'designation' => setting('director_designation', 'Director / Director of Administration, KCET'),
                'qualifications' => 'B.E. (Engineering)',
                'photo' => setting('director_photo', 'assets/images/faculty-hod-ai.jpg'),
                'default_photo' => 'assets/images/director-portrait.svg',
                'quote' => setting('director_quote', 'Having experienced the challenges of pursuing an engineering degree away from home, our mission is to provide students at KCET with a world-class, supportive, and career-driven technical learning ecosystem.'),
                'message' => setting('director_message', 'At KCET, our focus is on creating a holistic academic and infrastructural environment where engineering students can thrive. From high-performance computing centers and specialized Artificial Intelligence laboratories to reliable campus transit routes and rich collegiate resources, every facility at Ranbirgarh is purpose-built to empower students. We maintain strong industry alignment and outcome-based pedagogical standards under AICTE and University of Kashmir guidelines, preparing our graduates for premier technical careers and global postgraduate opportunities.'),
                'office' => 'Directorate of Administration',
                'email' => 'administration@kcet.edu.in',
                'phone' => setting('phone_primary', '+91 88994 12793'),
                'tenure' => 'Directorate of Campus Operations & Infrastructure',
                'focus_pillars' => [
                    'Lush 100+ kanal green campus equipped with fiber-optic networks and smart lecture halls',
                    'Modern student transit fleets covering all suburban and district routes of Srinagar',
                    'Advanced engineering laboratories, AI workstations, and digital collegiate library',
                    'Robust safety compliance, fire safety grids, and dedicated anti-ragging measures'
                ]
            ],
            'principal' => [
                'role_key' => 'principal',
                'route' => '/principals-message',
                'title' => "From the Principal's Desk",
                'nav_label' => "Principal's Message",
                'page_title' => "Principal's Message | Kashmir College of Engineering & Technology",
                'meta_description' => "Academic message from Dr. Syed Jalal Ahmad, Principal of KCET Srinagar on pedagogical excellence, outcome-based curricula, and student achievements.",
                'badge' => 'ACADEMIC LEADERSHIP & PROFESSORATE',
                'theme_color' => '#C98A2C',
                'badge_color' => '#C98A2C',
                'name' => setting('principal_name', 'Dr. Syed Jalal Ahmad'),
                'designation' => setting('principal_designation', 'Principal & Professor of Engineering'),
                'qualifications' => setting('principal_qualifications', 'Ph.D. (IIT Delhi), M.Tech, B.E.'),
                'photo' => setting('principal_photo', 'assets/images/principal-portrait.svg'),
                'default_photo' => 'assets/images/principal-portrait.svg',
                'quote' => setting('principal_quote', 'Engineering education at KCET is deeply grounded in hands-on scientific enquiry, ethical problem-solving, and outcome-based pedagogical rigor. We prepare engineers not merely for examinations, but to solve real infrastructure and technological challenges of Jammu & Kashmir and the world.'),
                'message' => setting('principal_message', 'Since its inception, Kashmir College of Engineering & Technology has stood as a beacon of high-quality technical education in Srinagar. Situated across a lush 100+ kanal green campus, our institution provides an ideal environment where academic curiosity meets state-of-the-art laboratory experimentation. With approval from AICTE and affiliation to the prestigious University of Kashmir, our curriculum continually integrates modern computational frameworks, artificial intelligence paradigms, sustainable civil designs, and advanced electronics. We welcome aspiring engineers to join our vibrant academic community.'),
                'office' => 'Office of the Principal',
                'email' => 'principal@kcet.edu.in',
                'phone' => setting('phone_primary', '+91 194 249 1234'),
                'tenure' => 'Academic Dean & Principal',
                'focus_pillars' => [
                    'Strict compliance with AICTE guidelines and University of Kashmir curriculum ordinances',
                    'Outcome-Based Education (OBE) model with intensive practical laboratory experiments',
                    'High-impact undergraduate research in Himalayan geology, AI, and resilient logistics',
                    'Industry internships, expert masterclasses, and vibrant campus placement training'
                ]
            ]
        ];

        return $leaders[$role] ?? null;
    }

    public function chairman(): void
    {
        $this->renderRole('chairman');
    }

    public function director(): void
    {
        $this->renderRole('director');
    }

    public function principal(): void
    {
        $this->renderRole('principal');
    }

    public function show(string $role): void
    {
        $normalized = strtolower(trim($role));
        if (in_array($normalized, ['chairman', 'chairmans-message'], true)) {
            $this->renderRole('chairman');
            return;
        }
        if (in_array($normalized, ['director', 'directors-message'], true)) {
            $this->renderRole('director');
            return;
        }
        if (in_array($normalized, ['principal', 'principals-message'], true)) {
            $this->renderRole('principal');
            return;
        }

        (new PageController())->notFound();
    }

    private function renderRole(string $roleKey): void
    {
        $leader = $this->getLeaderData($roleKey);
        if (!$leader) {
            (new PageController())->notFound();
            return;
        }

        $allLeaders = [
            'chairman' => $this->getLeaderData('chairman'),
            'director' => $this->getLeaderData('director'),
            'principal' => $this->getLeaderData('principal')
        ];

        View::render('pages.leadership.show', [
            'leader' => $leader,
            'allLeaders' => $allLeaders,
            'pageTitle' => $leader['page_title'],
            'metaDescription' => $leader['meta_description']
        ]);
    }
}
