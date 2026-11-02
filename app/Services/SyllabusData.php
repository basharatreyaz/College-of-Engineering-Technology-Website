<?php
declare(strict_types=1);

namespace App\Services;

class SyllabusData
{
    public static function getCommonFirstYearSemesters(): array
    {
        return [
            1 => [
                'semester' => 1,
                'name' => 'Semester I (1st Year Foundation)',
                'year' => '1st Year',
                'credits' => '19.5 Credits',
                'file' => 'assets/files/syllabus-common-sem-1.pdf',
                'core_subjects' => [
                    ['code' => 'BSC-101', 'title' => 'Engineering Mathematics-I (Calculus & Linear Algebra)', 'credits' => 4, 'type' => 'Theory'],
                    ['code' => 'BSC-102', 'title' => 'Engineering Physics (Electromagnetism & Wave Optics)', 'credits' => 4, 'type' => 'Theory'],
                    ['code' => 'ESC-101', 'title' => 'Basic Electrical Engineering (AC/DC & Machines)', 'credits' => 4, 'type' => 'Theory'],
                    ['code' => 'ESC-102', 'title' => 'Engineering Graphics & CAD Drafting', 'credits' => 3, 'type' => 'Theory/Drawing'],
                    ['code' => 'BSC-103P', 'title' => 'Engineering Physics Practical Laboratory', 'credits' => 1.5, 'type' => 'Practical'],
                    ['code' => 'ESC-103P', 'title' => 'Basic Electrical Engineering Lab', 'credits' => 1, 'type' => 'Practical'],
                    ['code' => 'MC-101', 'title' => 'Environmental Sciences & Ecology', 'credits' => 0, 'type' => 'Audit'],
                ]
            ],
            2 => [
                'semester' => 2,
                'name' => 'Semester II (1st Year Foundation)',
                'year' => '1st Year',
                'credits' => '20.5 Credits',
                'file' => 'assets/files/syllabus-common-sem-2.pdf',
                'core_subjects' => [
                    ['code' => 'BSC-104', 'title' => 'Engineering Mathematics-II (ODEs & Vector Calculus)', 'credits' => 4, 'type' => 'Theory'],
                    ['code' => 'BSC-105', 'title' => 'Engineering Chemistry (Polymers & Spectroscopy)', 'credits' => 4, 'type' => 'Theory'],
                    ['code' => 'ESC-104', 'title' => 'Programming for Problem Solving with C', 'credits' => 4, 'type' => 'Theory'],
                    ['code' => 'ESC-105', 'title' => 'Workshop & Manufacturing Practices (Carpentry/Welding)', 'credits' => 3, 'type' => 'Practical'],
                    ['code' => 'HSMC-101', 'title' => 'English for Technical Communication & Soft Skills', 'credits' => 2, 'type' => 'Humanities'],
                    ['code' => 'ESC-106P', 'title' => 'Programming for Problem Solving Lab in C', 'credits' => 1.5, 'type' => 'Practical'],
                    ['code' => 'BSC-106P', 'title' => 'Engineering Chemistry Laboratory', 'credits' => 1.5, 'type' => 'Practical'],
                ]
            ],
        ];
    }

    public static function getBranches(): array
    {
        $common1stYear = self::getCommonFirstYearSemesters();

        return [
            'ai' => [
                'code' => 'AI',
                'name' => 'Artificial Intelligence Engineering',
                'short_name' => 'B.Tech AI',
                'degree' => 'B.Tech (Honours / Regular)',
                'icon' => 'fa-solid fa-brain',
                'badge_color' => '#6366F1',
                'intake' => 60,
                'duration' => '4 Years (8 Semesters)',
                'curriculum_scheme' => 'AICTE Model Curriculum & University of Kashmir Scheme 2026',
                'description' => 'Comprehensive curriculum spanning Machine Learning, Deep Neural Networks, Natural Language Processing, Computer Vision, Generative AI, Reinforcement Learning, and MLOps.',
                'full_syllabus_file' => 'assets/files/syllabus-ai.pdf',
                'semesters' => $common1stYear + [
                    3 => [
                        'semester' => 3,
                        'name' => 'Semester III (2nd Year Core)',
                        'year' => '2nd Year',
                        'credits' => '21 Credits',
                        'file' => 'assets/files/syllabus-ai-sem-3.pdf',
                        'core_subjects' => [
                            ['code' => 'AI-301', 'title' => 'Discrete Mathematics & Graph Theory', 'credits' => 4, 'type' => 'Theory'],
                            ['code' => 'AI-302', 'title' => 'Data Structures & Algorithms in C++', 'credits' => 4, 'type' => 'Theory'],
                            ['code' => 'AI-303', 'title' => 'Digital Electronics & Logic Design', 'credits' => 3, 'type' => 'Theory'],
                            ['code' => 'AI-304', 'title' => 'Python Programming for Data Science & AI', 'credits' => 3, 'type' => 'Theory'],
                            ['code' => 'AI-305', 'title' => 'Computer Organization & Architecture', 'credits' => 3, 'type' => 'Theory'],
                            ['code' => 'AI-306P', 'title' => 'Data Structures Practical Laboratory', 'credits' => 2, 'type' => 'Practical'],
                            ['code' => 'AI-307P', 'title' => 'Python AI Development & NumPy Lab', 'credits' => 2, 'type' => 'Practical'],
                        ]
                    ],
                    4 => [
                        'semester' => 4,
                        'name' => 'Semester IV (2nd Year Core)',
                        'year' => '2nd Year',
                        'credits' => '22 Credits',
                        'file' => 'assets/files/syllabus-ai-sem-4.pdf',
                        'core_subjects' => [
                            ['code' => 'AI-401', 'title' => 'Linear Algebra & Statistics for Machine Learning', 'credits' => 4, 'type' => 'Theory'],
                            ['code' => 'AI-402', 'title' => 'Database Management Systems & NoSQL', 'credits' => 4, 'type' => 'Theory'],
                            ['code' => 'AI-403', 'title' => 'Operating Systems & System Programming', 'credits' => 3, 'type' => 'Theory'],
                            ['code' => 'AI-404', 'title' => 'Foundations of AI & State-Space Search', 'credits' => 4, 'type' => 'Theory'],
                            ['code' => 'AI-405', 'title' => 'Object-Oriented Software Engineering', 'credits' => 3, 'type' => 'Theory'],
                            ['code' => 'AI-406P', 'title' => 'AI Problem Solving & Heuristic Search Lab', 'credits' => 2, 'type' => 'Practical'],
                            ['code' => 'AI-407P', 'title' => 'Relational DBMS & SQL Lab', 'credits' => 2, 'type' => 'Practical'],
                        ]
                    ],
                    5 => [
                        'semester' => 5,
                        'name' => 'Semester V (3rd Year Advanced)',
                        'year' => '3rd Year',
                        'credits' => '22 Credits',
                        'file' => 'assets/files/syllabus-ai-sem-5.pdf',
                        'core_subjects' => [
                            ['code' => 'AI-501', 'title' => 'Machine Learning: Supervised & Unsupervised', 'credits' => 4, 'type' => 'Theory'],
                            ['code' => 'AI-502', 'title' => 'Knowledge Representation & Automated Reasoning', 'credits' => 3, 'type' => 'Theory'],
                            ['code' => 'AI-503', 'title' => 'Formal Languages & Automata Theory', 'credits' => 3, 'type' => 'Theory'],
                            ['code' => 'AI-504', 'title' => 'Computer Networks & Distributed Protocols', 'credits' => 3, 'type' => 'Theory'],
                            ['code' => 'AI-PE1', 'title' => 'Professional Elective I: Optimization for AI', 'credits' => 3, 'type' => 'Elective'],
                            ['code' => 'AI-505P', 'title' => 'Machine Learning Lab (PyTorch & Scikit-Learn)', 'credits' => 2, 'type' => 'Practical'],
                            ['code' => 'AI-506P', 'title' => 'Prolog & Semantic Web Lab', 'credits' => 2, 'type' => 'Practical'],
                            ['code' => 'HS-501', 'title' => 'Principles of Management & Economics', 'credits' => 2, 'type' => 'Humanities'],
                        ]
                    ],
                    6 => [
                        'semester' => 6,
                        'name' => 'Semester VI (3rd Year Advanced)',
                        'year' => '3rd Year',
                        'credits' => '22 Credits',
                        'file' => 'assets/files/syllabus-ai-sem-6.pdf',
                        'core_subjects' => [
                            ['code' => 'AI-601', 'title' => 'Deep Learning & Neural Network Architectures', 'credits' => 4, 'type' => 'Theory'],
                            ['code' => 'AI-602', 'title' => 'Computer Vision & Image Understanding', 'credits' => 4, 'type' => 'Theory'],
                            ['code' => 'AI-603', 'title' => 'Reinforcement Learning & Multi-Agent Systems', 'credits' => 3, 'type' => 'Theory'],
                            ['code' => 'AI-604', 'title' => 'Cloud Computing, Big Data & MLOps', 'credits' => 3, 'type' => 'Theory'],
                            ['code' => 'AI-PE2', 'title' => 'Professional Elective II: Natural Language Processing', 'credits' => 3, 'type' => 'Elective'],
                            ['code' => 'AI-605P', 'title' => 'Deep Learning & Computer Vision Lab', 'credits' => 2, 'type' => 'Practical'],
                            ['code' => 'AI-606P', 'title' => 'MLOps Pipelines & Cloud Deployment Lab', 'credits' => 2, 'type' => 'Practical'],
                        ]
                    ],
                    7 => [
                        'semester' => 7,
                        'name' => 'Semester VII (4th Year Specialization)',
                        'year' => '4th Year',
                        'credits' => '19 Credits',
                        'file' => 'assets/files/syllabus-ai-sem-7.pdf',
                        'core_subjects' => [
                            ['code' => 'AI-701', 'title' => 'Generative AI, Large Language Models & Diffusion', 'credits' => 4, 'type' => 'Theory'],
                            ['code' => 'AI-702', 'title' => 'AI Ethics, Safety & Explainable AI (XAI)', 'credits' => 3, 'type' => 'Theory'],
                            ['code' => 'AI-PE3', 'title' => 'Professional Elective III: Edge AI & TinyML', 'credits' => 3, 'type' => 'Elective'],
                            ['code' => 'OE-701', 'title' => 'Open Elective I: Cyber Security & Threat Intelligence', 'credits' => 3, 'type' => 'Open Elective'],
                            ['code' => 'AI-703P', 'title' => 'Capstone Project Stage-I & Research Defense', 'credits' => 4, 'type' => 'Project'],
                            ['code' => 'AI-704I', 'title' => 'Industry Summer Internship Seminar', 'credits' => 2, 'type' => 'Internship'],
                        ]
                    ],
                    8 => [
                        'semester' => 8,
                        'name' => 'Semester VIII (4th Year Capstone)',
                        'year' => '4th Year',
                        'credits' => '16 Credits',
                        'file' => 'assets/files/syllabus-ai-sem-8.pdf',
                        'core_subjects' => [
                            ['code' => 'AI-801', 'title' => 'Major Capstone Project Stage-II (Prototype Defense)', 'credits' => 10, 'type' => 'Project'],
                            ['code' => 'AI-PE4', 'title' => 'Professional Elective IV: Autonomous Systems', 'credits' => 3, 'type' => 'Elective'],
                            ['code' => 'OE-801', 'title' => 'Open Elective II: Intellectual Property & Startups', 'credits' => 3, 'type' => 'Open Elective'],
                            ['code' => 'AI-802V', 'title' => 'Comprehensive Technical Viva-Voce', 'credits' => 2, 'type' => 'Viva'],
                        ]
                    ],
                ]
            ],

            'ce' => [
                'code' => 'CE',
                'name' => 'Computer Engineering',
                'short_name' => 'B.Tech CE',
                'degree' => 'B.Tech in Computer Engineering',
                'icon' => 'fa-solid fa-laptop-code',
                'badge_color' => '#0284C7',
                'intake' => 60,
                'duration' => '4 Years (8 Semesters)',
                'curriculum_scheme' => 'AICTE Model Curriculum & University of Kashmir Scheme 2026',
                'description' => 'Rigorous computing curriculum integrating Data Structures, Operating Systems, Computer Architecture, Compiler Design, Web Engineering, and Cloud Security.',
                'full_syllabus_file' => 'assets/files/syllabus-ce.pdf',
                'semesters' => $common1stYear + [
                    3 => [
                        'semester' => 3,
                        'name' => 'Semester III (2nd Year Core)',
                        'year' => '2nd Year',
                        'credits' => '21 Credits',
                        'file' => 'assets/files/syllabus-ce-sem-3.pdf',
                        'core_subjects' => [
                            ['code' => 'CE-301', 'title' => 'Discrete Mathematics & Structures', 'credits' => 4, 'type' => 'Theory'],
                            ['code' => 'CE-302', 'title' => 'Data Structures & Algorithms', 'credits' => 4, 'type' => 'Theory'],
                            ['code' => 'CE-303', 'title' => 'Digital Electronics & Logic Design', 'credits' => 3, 'type' => 'Theory'],
                            ['code' => 'CE-304', 'title' => 'Object-Oriented Programming with Java', 'credits' => 3, 'type' => 'Theory'],
                            ['code' => 'CE-305', 'title' => 'Computer Organization & Architecture', 'credits' => 3, 'type' => 'Theory'],
                            ['code' => 'CE-306P', 'title' => 'Data Structures Practical Lab', 'credits' => 2, 'type' => 'Practical'],
                            ['code' => 'CE-307P', 'title' => 'Java Programming Lab', 'credits' => 2, 'type' => 'Practical'],
                        ]
                    ],
                    4 => [
                        'semester' => 4,
                        'name' => 'Semester IV (2nd Year Core)',
                        'year' => '2nd Year',
                        'credits' => '22 Credits',
                        'file' => 'assets/files/syllabus-ce-sem-4.pdf',
                        'core_subjects' => [
                            ['code' => 'CE-401', 'title' => 'Design & Analysis of Algorithms', 'credits' => 4, 'type' => 'Theory'],
                            ['code' => 'CE-402', 'title' => 'Operating Systems & Kernel Concepts', 'credits' => 4, 'type' => 'Theory'],
                            ['code' => 'CE-403', 'title' => 'Database Management Systems', 'credits' => 4, 'type' => 'Theory'],
                            ['code' => 'CE-404', 'title' => 'Theory of Computation & Automata', 'credits' => 3, 'type' => 'Theory'],
                            ['code' => 'CE-405', 'title' => 'Software Engineering & UML Modeling', 'credits' => 3, 'type' => 'Theory'],
                            ['code' => 'CE-406P', 'title' => 'Linux Shell & OS Lab', 'credits' => 2, 'type' => 'Practical'],
                            ['code' => 'CE-407P', 'title' => 'Database Design & SQL Lab', 'credits' => 2, 'type' => 'Practical'],
                        ]
                    ],
                    5 => [
                        'semester' => 5,
                        'name' => 'Semester V (3rd Year Advanced)',
                        'year' => '3rd Year',
                        'credits' => '22 Credits',
                        'file' => 'assets/files/syllabus-ce-sem-5.pdf',
                        'core_subjects' => [
                            ['code' => 'CE-501', 'title' => 'Computer Networks & TCP/IP Protocol Suite', 'credits' => 4, 'type' => 'Theory'],
                            ['code' => 'CE-502', 'title' => 'Compiler Design & Lexical Analysis', 'credits' => 4, 'type' => 'Theory'],
                            ['code' => 'CE-503', 'title' => 'Microprocessors & Microcontrollers (x86/ARM)', 'credits' => 3, 'type' => 'Theory'],
                            ['code' => 'CE-504', 'title' => 'Web Technologies & Full-Stack Development', 'credits' => 3, 'type' => 'Theory'],
                            ['code' => 'CE-PE1', 'title' => 'Professional Elective I: Data Mining & Warehousing', 'credits' => 3, 'type' => 'Elective'],
                            ['code' => 'CE-505P', 'title' => 'Computer Networks & Socket Lab', 'credits' => 2, 'type' => 'Practical'],
                            ['code' => 'CE-506P', 'title' => 'Full-Stack Web Engineering Lab', 'credits' => 2, 'type' => 'Practical'],
                        ]
                    ],
                    6 => [
                        'semester' => 6,
                        'name' => 'Semester VI (3rd Year Advanced)',
                        'year' => '3rd Year',
                        'credits' => '22 Credits',
                        'file' => 'assets/files/syllabus-ce-sem-6.pdf',
                        'core_subjects' => [
                            ['code' => 'CE-601', 'title' => 'Information & Network Security', 'credits' => 4, 'type' => 'Theory'],
                            ['code' => 'CE-602', 'title' => 'Cloud Computing & Virtualization Infrastructure', 'credits' => 4, 'type' => 'Theory'],
                            ['code' => 'CE-603', 'title' => 'Artificial Intelligence & Expert Systems', 'credits' => 3, 'type' => 'Theory'],
                            ['code' => 'CE-PE2', 'title' => 'Professional Elective II: Internet of Things (IoT)', 'credits' => 3, 'type' => 'Elective'],
                            ['code' => 'CE-604P', 'title' => 'Cryptography & Security Tools Lab', 'credits' => 2, 'type' => 'Practical'],
                            ['code' => 'CE-605P', 'title' => 'Cloud Services & DevOps Lab', 'credits' => 2, 'type' => 'Practical'],
                        ]
                    ],
                    7 => [
                        'semester' => 7,
                        'name' => 'Semester VII (4th Year Specialization)',
                        'year' => '4th Year',
                        'credits' => '19 Credits',
                        'file' => 'assets/files/syllabus-ce-sem-7.pdf',
                        'core_subjects' => [
                            ['code' => 'CE-701', 'title' => 'Distributed Systems & Microservices', 'credits' => 4, 'type' => 'Theory'],
                            ['code' => 'CE-702', 'title' => 'Machine Learning Foundations', 'credits' => 4, 'type' => 'Theory'],
                            ['code' => 'CE-PE3', 'title' => 'Professional Elective III: Mobile App Development', 'credits' => 3, 'type' => 'Elective'],
                            ['code' => 'OE-701', 'title' => 'Open Elective I: Engineering Economics & Finance', 'credits' => 3, 'type' => 'Open Elective'],
                            ['code' => 'CE-703P', 'title' => 'Capstone Project Stage-I & Specification Defense', 'credits' => 4, 'type' => 'Project'],
                            ['code' => 'CE-704I', 'title' => 'Industry Summer Internship Seminar', 'credits' => 2, 'type' => 'Internship'],
                        ]
                    ],
                    8 => [
                        'semester' => 8,
                        'name' => 'Semester VIII (4th Year Capstone)',
                        'year' => '4th Year',
                        'credits' => '16 Credits',
                        'file' => 'assets/files/syllabus-ce-sem-8.pdf',
                        'core_subjects' => [
                            ['code' => 'CE-801', 'title' => 'Major Capstone Project Stage-II (Working Product)', 'credits' => 10, 'type' => 'Project'],
                            ['code' => 'CE-PE4', 'title' => 'Professional Elective IV: Blockchain Technologies', 'credits' => 3, 'type' => 'Elective'],
                            ['code' => 'OE-801', 'title' => 'Open Elective II: Cyber Laws & Intellectual Property', 'credits' => 3, 'type' => 'Open Elective'],
                            ['code' => 'CE-802V', 'title' => 'Comprehensive Technical Viva-Voce', 'credits' => 2, 'type' => 'Viva'],
                        ]
                    ],
                ]
            ],

            'civil' => [
                'code' => 'CIVIL',
                'name' => 'Civil Engineering',
                'short_name' => 'B.Tech Civil',
                'degree' => 'B.Tech in Civil Engineering',
                'icon' => 'fa-solid fa-helmet-safety',
                'badge_color' => '#D97706',
                'intake' => 60,
                'duration' => '4 Years (8 Semesters)',
                'curriculum_scheme' => 'AICTE Model Curriculum & University of Kashmir Scheme 2026',
                'description' => 'Solid foundation in Structural Analysis, Concrete Technology, Geotechnical Engineering, Transportation, Environmental Systems, and Earthquake-Resistant Design.',
                'full_syllabus_file' => 'assets/files/syllabus-civil.pdf',
                'semesters' => $common1stYear + [
                    3 => [
                        'semester' => 3,
                        'name' => 'Semester III (2nd Year Core)',
                        'year' => '2nd Year',
                        'credits' => '21 Credits',
                        'file' => 'assets/files/syllabus-civil-sem-3.pdf',
                        'core_subjects' => [
                            ['code' => 'CV-301', 'title' => 'Engineering Mathematics-III (PDEs & Statistics)', 'credits' => 4, 'type' => 'Theory'],
                            ['code' => 'CV-302', 'title' => 'Mechanics of Solids (Strength of Materials)', 'credits' => 4, 'type' => 'Theory'],
                            ['code' => 'CV-303', 'title' => 'Fluid Mechanics & Open Channel Hydraulics', 'credits' => 4, 'type' => 'Theory'],
                            ['code' => 'CV-304', 'title' => 'Surveying-I: Principles, Chain & Levelling', 'credits' => 3, 'type' => 'Theory'],
                            ['code' => 'CV-305', 'title' => 'Building Materials & Construction Tech', 'credits' => 3, 'type' => 'Theory'],
                            ['code' => 'CV-306P', 'title' => 'Surveying Field Practice Lab', 'credits' => 2, 'type' => 'Practical'],
                            ['code' => 'CV-307P', 'title' => 'Civil Material Testing Lab', 'credits' => 2, 'type' => 'Practical'],
                        ]
                    ],
                    4 => [
                        'semester' => 4,
                        'name' => 'Semester IV (2nd Year Core)',
                        'year' => '2nd Year',
                        'credits' => '22 Credits',
                        'file' => 'assets/files/syllabus-civil-sem-4.pdf',
                        'core_subjects' => [
                            ['code' => 'CV-401', 'title' => 'Structural Analysis-I (Determinate Structures)', 'credits' => 4, 'type' => 'Theory'],
                            ['code' => 'CV-402', 'title' => 'Hydraulic Engineering & Pipe Networks', 'credits' => 4, 'type' => 'Theory'],
                            ['code' => 'CV-403', 'title' => 'Surveying-II: Total Station & GIS Intro', 'credits' => 3, 'type' => 'Theory'],
                            ['code' => 'CV-404', 'title' => 'Concrete Technology & Mix Proportioning', 'credits' => 3, 'type' => 'Theory'],
                            ['code' => 'CV-405', 'title' => 'Engineering Geology & Rock Mechanics', 'credits' => 3, 'type' => 'Theory'],
                            ['code' => 'CV-406P', 'title' => 'Concrete Testing & Quality Control Lab', 'credits' => 2, 'type' => 'Practical'],
                            ['code' => 'CV-407P', 'title' => 'Fluid Mechanics & Machinery Lab', 'credits' => 2, 'type' => 'Practical'],
                        ]
                    ],
                    5 => [
                        'semester' => 5,
                        'name' => 'Semester V (3rd Year Advanced)',
                        'year' => '3rd Year',
                        'credits' => '22 Credits',
                        'file' => 'assets/files/syllabus-civil-sem-5.pdf',
                        'core_subjects' => [
                            ['code' => 'CV-501', 'title' => 'Structural Analysis-II (Indeterminate Structures)', 'credits' => 4, 'type' => 'Theory'],
                            ['code' => 'CV-502', 'title' => 'Design of Reinforced Concrete Structures (IS 456)', 'credits' => 4, 'type' => 'Theory'],
                            ['code' => 'CV-503', 'title' => 'Geotechnical Engineering-I (Soil Mechanics)', 'credits' => 4, 'type' => 'Theory'],
                            ['code' => 'CV-504', 'title' => 'Hydrology & Water Resources Engineering', 'credits' => 3, 'type' => 'Theory'],
                            ['code' => 'CV-PE1', 'title' => 'Professional Elective I: Environmental Impact Assessment', 'credits' => 3, 'type' => 'Elective'],
                            ['code' => 'CV-505P', 'title' => 'Soil Mechanics & Geotechnical Lab', 'credits' => 2, 'type' => 'Practical'],
                            ['code' => 'CV-506P', 'title' => 'RCC Structural Design & Drafting Lab', 'credits' => 2, 'type' => 'Practical'],
                        ]
                    ],
                    6 => [
                        'semester' => 6,
                        'name' => 'Semester VI (3rd Year Advanced)',
                        'year' => '3rd Year',
                        'credits' => '22 Credits',
                        'file' => 'assets/files/syllabus-civil-sem-6.pdf',
                        'core_subjects' => [
                            ['code' => 'CV-601', 'title' => 'Design of Steel Structures (IS 800)', 'credits' => 4, 'type' => 'Theory'],
                            ['code' => 'CV-602', 'title' => 'Geotechnical Engineering-II (Foundation Design)', 'credits' => 4, 'type' => 'Theory'],
                            ['code' => 'CV-603', 'title' => 'Transportation Engineering-I (Highway Engineering)', 'credits' => 4, 'type' => 'Theory'],
                            ['code' => 'CV-604', 'title' => 'Environmental Engineering-I (Water Supply)', 'credits' => 3, 'type' => 'Theory'],
                            ['code' => 'CV-PE2', 'title' => 'Professional Elective II: Irrigation Engineering', 'credits' => 3, 'type' => 'Elective'],
                            ['code' => 'CV-605P', 'title' => 'Highway & Transportation Materials Lab', 'credits' => 2, 'type' => 'Practical'],
                            ['code' => 'CV-606P', 'title' => 'Environmental Engineering & Water Testing Lab', 'credits' => 2, 'type' => 'Practical'],
                        ]
                    ],
                    7 => [
                        'semester' => 7,
                        'name' => 'Semester VII (4th Year Specialization)',
                        'year' => '4th Year',
                        'credits' => '19 Credits',
                        'file' => 'assets/files/syllabus-civil-sem-7.pdf',
                        'core_subjects' => [
                            ['code' => 'CV-701', 'title' => 'Transportation Engineering-II (Airports & Harbors)', 'credits' => 3, 'type' => 'Theory'],
                            ['code' => 'CV-702', 'title' => 'Environmental Engineering-II (Wastewater Treatment)', 'credits' => 3, 'type' => 'Theory'],
                            ['code' => 'CV-703', 'title' => 'Estimating, Costing & Valuation', 'credits' => 3, 'type' => 'Theory'],
                            ['code' => 'CV-PE3', 'title' => 'Professional Elective III: Earthquake Resistant Design', 'credits' => 3, 'type' => 'Elective'],
                            ['code' => 'OE-701', 'title' => 'Open Elective I: Disaster Management & Mitigation', 'credits' => 3, 'type' => 'Open Elective'],
                            ['code' => 'CV-704P', 'title' => 'Capstone Project Stage-I & Site Reconnaissance', 'credits' => 4, 'type' => 'Project'],
                            ['code' => 'CV-705I', 'title' => 'Industrial Site Training Evaluation', 'credits' => 2, 'type' => 'Internship'],
                        ]
                    ],
                    8 => [
                        'semester' => 8,
                        'name' => 'Semester VIII (4th Year Capstone)',
                        'year' => '4th Year',
                        'credits' => '16 Credits',
                        'file' => 'assets/files/syllabus-civil-sem-8.pdf',
                        'core_subjects' => [
                            ['code' => 'CV-801', 'title' => 'Major Capstone Project Stage-II (Infrastructure Design)', 'credits' => 10, 'type' => 'Project'],
                            ['code' => 'CV-PE4', 'title' => 'Professional Elective IV: Construction Project Management', 'credits' => 3, 'type' => 'Elective'],
                            ['code' => 'OE-801', 'title' => 'Open Elective II: Urban Planning & Smart Infrastructure', 'credits' => 3, 'type' => 'Open Elective'],
                            ['code' => 'CV-802V', 'title' => 'Comprehensive Technical Viva-Voce', 'credits' => 2, 'type' => 'Viva'],
                        ]
                    ],
                ]
            ],

            'it' => [
                'code' => 'IT',
                'name' => 'Information Technology',
                'short_name' => 'B.Tech IT',
                'degree' => 'B.Tech in Information Technology',
                'icon' => 'fa-solid fa-network-wired',
                'badge_color' => '#0D9488',
                'intake' => 60,
                'duration' => '4 Years (8 Semesters)',
                'curriculum_scheme' => 'AICTE Model Curriculum & University of Kashmir Scheme 2026',
                'description' => 'Curriculum focused on Enterprise Systems, Software Development Frameworks, Database Systems, Network Architecture, Cloud Services, and Cyber Security.',
                'full_syllabus_file' => 'assets/files/syllabus-it.pdf',
                'semesters' => $common1stYear + [
                    3 => [
                        'semester' => 3,
                        'name' => 'Semester III (2nd Year Core)',
                        'year' => '2nd Year',
                        'credits' => '21 Credits',
                        'file' => 'assets/files/syllabus-it-sem-3.pdf',
                        'core_subjects' => [
                            ['code' => 'IT-301', 'title' => 'Discrete Mathematical Structures', 'credits' => 4, 'type' => 'Theory'],
                            ['code' => 'IT-302', 'title' => 'Data Structures & Algorithms', 'credits' => 4, 'type' => 'Theory'],
                            ['code' => 'IT-303', 'title' => 'Digital Electronics & Logic Design', 'credits' => 3, 'type' => 'Theory'],
                            ['code' => 'IT-304', 'title' => 'Object-Oriented Methodology using Java', 'credits' => 3, 'type' => 'Theory'],
                            ['code' => 'IT-305', 'title' => 'Principles of Communication Systems', 'credits' => 3, 'type' => 'Theory'],
                            ['code' => 'IT-306P', 'title' => 'Data Structures Practical Lab', 'credits' => 2, 'type' => 'Practical'],
                            ['code' => 'IT-307P', 'title' => 'Java Programming Lab', 'credits' => 2, 'type' => 'Practical'],
                        ]
                    ],
                    4 => [
                        'semester' => 4,
                        'name' => 'Semester IV (2nd Year Core)',
                        'year' => '2nd Year',
                        'credits' => '22 Credits',
                        'file' => 'assets/files/syllabus-it-sem-4.pdf',
                        'core_subjects' => [
                            ['code' => 'IT-401', 'title' => 'Computer Organization & Microprocessors', 'credits' => 4, 'type' => 'Theory'],
                            ['code' => 'IT-402', 'title' => 'Database Management Systems', 'credits' => 4, 'type' => 'Theory'],
                            ['code' => 'IT-403', 'title' => 'Design & Analysis of Algorithms', 'credits' => 4, 'type' => 'Theory'],
                            ['code' => 'IT-404', 'title' => 'Operating Systems Concepts & POSIX', 'credits' => 3, 'type' => 'Theory'],
                            ['code' => 'IT-405', 'title' => 'Software Engineering Principles', 'credits' => 3, 'type' => 'Theory'],
                            ['code' => 'IT-406P', 'title' => 'DBMS & SQL Practical Lab', 'credits' => 2, 'type' => 'Practical'],
                            ['code' => 'IT-407P', 'title' => 'Shell Scripting & OS Lab', 'credits' => 2, 'type' => 'Practical'],
                        ]
                    ],
                    5 => [
                        'semester' => 5,
                        'name' => 'Semester V (3rd Year Advanced)',
                        'year' => '3rd Year',
                        'credits' => '22 Credits',
                        'file' => 'assets/files/syllabus-it-sem-5.pdf',
                        'core_subjects' => [
                            ['code' => 'IT-501', 'title' => 'Computer Communication Networks', 'credits' => 4, 'type' => 'Theory'],
                            ['code' => 'IT-502', 'title' => 'Formal Languages & Automata Theory', 'credits' => 3, 'type' => 'Theory'],
                            ['code' => 'IT-503', 'title' => 'Web Development Frameworks (React/Node.js)', 'credits' => 3, 'type' => 'Theory'],
                            ['code' => 'IT-504', 'title' => 'Information Storage & Big Data', 'credits' => 3, 'type' => 'Theory'],
                            ['code' => 'IT-PE1', 'title' => 'Professional Elective I: Cyber Forensics & Investigation', 'credits' => 3, 'type' => 'Elective'],
                            ['code' => 'IT-505P', 'title' => 'Web Engineering & Frameworks Lab', 'credits' => 2, 'type' => 'Practical'],
                            ['code' => 'IT-506P', 'title' => 'Computer Networks & Packet Lab', 'credits' => 2, 'type' => 'Practical'],
                        ]
                    ],
                    6 => [
                        'semester' => 6,
                        'name' => 'Semester VI (3rd Year Advanced)',
                        'year' => '3rd Year',
                        'credits' => '22 Credits',
                        'file' => 'assets/files/syllabus-it-sem-6.pdf',
                        'core_subjects' => [
                            ['code' => 'IT-601', 'title' => 'Information & Cryptographic Security', 'credits' => 4, 'type' => 'Theory'],
                            ['code' => 'IT-602', 'title' => 'Software Project Management & Agile Methodologies', 'credits' => 3, 'type' => 'Theory'],
                            ['code' => 'IT-603', 'title' => 'Mobile Computing & Wireless Networks', 'credits' => 3, 'type' => 'Theory'],
                            ['code' => 'IT-604', 'title' => 'Data Science & Analytics with Python', 'credits' => 4, 'type' => 'Theory'],
                            ['code' => 'IT-PE2', 'title' => 'Professional Elective II: Enterprise Resource Planning (ERP)', 'credits' => 3, 'type' => 'Elective'],
                            ['code' => 'IT-605P', 'title' => 'Mobile App Development Lab', 'credits' => 2, 'type' => 'Practical'],
                            ['code' => 'IT-606P', 'title' => 'Data Science & Visualization Lab', 'credits' => 2, 'type' => 'Practical'],
                        ]
                    ],
                    7 => [
                        'semester' => 7,
                        'name' => 'Semester VII (4th Year Specialization)',
                        'year' => '4th Year',
                        'credits' => '19 Credits',
                        'file' => 'assets/files/syllabus-it-sem-7.pdf',
                        'core_subjects' => [
                            ['code' => 'IT-701', 'title' => 'Cloud Computing & Virtualized Services', 'credits' => 4, 'type' => 'Theory'],
                            ['code' => 'IT-702', 'title' => 'Big Data Technologies & Hadoop Ecosystem', 'credits' => 3, 'type' => 'Theory'],
                            ['code' => 'IT-PE3', 'title' => 'Professional Elective III: DevOps & CI/CD Pipelines', 'credits' => 3, 'type' => 'Elective'],
                            ['code' => 'OE-701', 'title' => 'Open Elective I: IT Laws & Patenting', 'credits' => 3, 'type' => 'Open Elective'],
                            ['code' => 'IT-703P', 'title' => 'Capstone Project Stage-I', 'credits' => 4, 'type' => 'Project'],
                            ['code' => 'IT-704I', 'title' => 'Industrial Summer Internship Evaluation', 'credits' => 2, 'type' => 'Internship'],
                        ]
                    ],
                    8 => [
                        'semester' => 8,
                        'name' => 'Semester VIII (4th Year Capstone)',
                        'year' => '4th Year',
                        'credits' => '16 Credits',
                        'file' => 'assets/files/syllabus-it-sem-8.pdf',
                        'core_subjects' => [
                            ['code' => 'IT-801', 'title' => 'Major Capstone Project Stage-II (Enterprise Deployment)', 'credits' => 10, 'type' => 'Project'],
                            ['code' => 'IT-PE4', 'title' => 'Professional Elective IV: Artificial Intelligence & Deep Learning', 'credits' => 3, 'type' => 'Elective'],
                            ['code' => 'OE-801', 'title' => 'Open Elective II: Human-Computer Interaction (HCI)', 'credits' => 3, 'type' => 'Open Elective'],
                            ['code' => 'IT-802V', 'title' => 'Comprehensive Technical Viva-Voce', 'credits' => 2, 'type' => 'Viva'],
                        ]
                    ],
                ]
            ],

            'ece' => [
                'code' => 'ECE',
                'name' => 'Electronics & Communication Engineering',
                'short_name' => 'B.Tech ECE',
                'degree' => 'B.Tech in Electronics & Communication',
                'icon' => 'fa-solid fa-microchip',
                'badge_color' => '#8B5CF6',
                'intake' => 60,
                'duration' => '4 Years (8 Semesters)',
                'curriculum_scheme' => 'AICTE Model Curriculum & University of Kashmir Scheme 2026',
                'description' => 'Comprehensive engineering study of Analog & Digital Electronics, Signals, Microprocessors, VLSI Design, Antenna & Microwaves, Optical Fibers, and 5G Communications.',
                'full_syllabus_file' => 'assets/files/syllabus-ece.pdf',
                'semesters' => $common1stYear + [
                    3 => [
                        'semester' => 3,
                        'name' => 'Semester III (2nd Year Core)',
                        'year' => '2nd Year',
                        'credits' => '21 Credits',
                        'file' => 'assets/files/syllabus-ece-sem-3.pdf',
                        'core_subjects' => [
                            ['code' => 'EC-301', 'title' => 'Mathematics-III (Complex Variables & Transforms)', 'credits' => 4, 'type' => 'Theory'],
                            ['code' => 'EC-302', 'title' => 'Electronic Devices & Circuit Theory', 'credits' => 4, 'type' => 'Theory'],
                            ['code' => 'EC-303', 'title' => 'Network Analysis & Synthesis', 'credits' => 4, 'type' => 'Theory'],
                            ['code' => 'EC-304', 'title' => 'Signals & Linear Systems', 'credits' => 3, 'type' => 'Theory'],
                            ['code' => 'EC-305', 'title' => 'Digital System Design with Verilog HDL', 'credits' => 3, 'type' => 'Theory'],
                            ['code' => 'EC-306P', 'title' => 'Analog Electronics Circuits Lab', 'credits' => 2, 'type' => 'Practical'],
                            ['code' => 'EC-307P', 'title' => 'Digital Logic & HDL Simulation Lab', 'credits' => 2, 'type' => 'Practical'],
                        ]
                    ],
                    4 => [
                        'semester' => 4,
                        'name' => 'Semester IV (2nd Year Core)',
                        'year' => '2nd Year',
                        'credits' => '22 Credits',
                        'file' => 'assets/files/syllabus-ece-sem-4.pdf',
                        'core_subjects' => [
                            ['code' => 'EC-401', 'title' => 'Analog Communication Systems (AM, FM, PM)', 'credits' => 4, 'type' => 'Theory'],
                            ['code' => 'EC-402', 'title' => 'Linear Integrated Circuits & Op-Amps', 'credits' => 4, 'type' => 'Theory'],
                            ['code' => 'EC-403', 'title' => 'Electromagnetic Field Theory (EMFT)', 'credits' => 4, 'type' => 'Theory'],
                            ['code' => 'EC-404', 'title' => 'Microprocessor & Microcontrollers (8085/8086)', 'credits' => 3, 'type' => 'Theory'],
                            ['code' => 'EC-405', 'title' => 'Probability Theory & Stochastic Processes', 'credits' => 3, 'type' => 'Theory'],
                            ['code' => 'EC-406P', 'title' => 'Analog Communication Practical Lab', 'credits' => 2, 'type' => 'Practical'],
                            ['code' => 'EC-407P', 'title' => 'Linear Integrated Circuits Lab', 'credits' => 2, 'type' => 'Practical'],
                        ]
                    ],
                    5 => [
                        'semester' => 5,
                        'name' => 'Semester V (3rd Year Advanced)',
                        'year' => '3rd Year',
                        'credits' => '22 Credits',
                        'file' => 'assets/files/syllabus-ece-sem-5.pdf',
                        'core_subjects' => [
                            ['code' => 'EC-501', 'title' => 'Digital Communication Systems (QPSK, QAM)', 'credits' => 4, 'type' => 'Theory'],
                            ['code' => 'EC-502', 'title' => 'Digital Signal Processing (DSP & Filter Design)', 'credits' => 4, 'type' => 'Theory'],
                            ['code' => 'EC-503', 'title' => 'Control Systems Engineering', 'credits' => 3, 'type' => 'Theory'],
                            ['code' => 'EC-504', 'title' => 'Embedded Systems & ARM Cortex Architecture', 'credits' => 3, 'type' => 'Theory'],
                            ['code' => 'EC-PE1', 'title' => 'Professional Elective I: Electronic Instrumentation', 'credits' => 3, 'type' => 'Elective'],
                            ['code' => 'EC-505P', 'title' => 'Digital Communication & DSP Lab', 'credits' => 2, 'type' => 'Practical'],
                            ['code' => 'EC-506P', 'title' => 'Embedded Systems & ARM Lab', 'credits' => 2, 'type' => 'Practical'],
                        ]
                    ],
                    6 => [
                        'semester' => 6,
                        'name' => 'Semester VI (3rd Year Advanced)',
                        'year' => '3rd Year',
                        'credits' => '22 Credits',
                        'file' => 'assets/files/syllabus-ece-sem-6.pdf',
                        'core_subjects' => [
                            ['code' => 'EC-601', 'title' => 'VLSI Design & CMOS Technology', 'credits' => 4, 'type' => 'Theory'],
                            ['code' => 'EC-602', 'title' => 'Antenna & Wave Propagation', 'credits' => 4, 'type' => 'Theory'],
                            ['code' => 'EC-603', 'title' => 'Microwave & Radar Engineering', 'credits' => 4, 'type' => 'Theory'],
                            ['code' => 'EC-604', 'title' => 'Optical Fiber Communication Systems', 'credits' => 3, 'type' => 'Theory'],
                            ['code' => 'EC-PE2', 'title' => 'Professional Elective II: Wireless Sensor Networks', 'credits' => 3, 'type' => 'Elective'],
                            ['code' => 'EC-605P', 'title' => 'VLSI CAD & FPGA Synthesis Lab', 'credits' => 2, 'type' => 'Practical'],
                            ['code' => 'EC-606P', 'title' => 'Microwave & Optical Fiber Lab', 'credits' => 2, 'type' => 'Practical'],
                        ]
                    ],
                    7 => [
                        'semester' => 7,
                        'name' => 'Semester VII (4th Year Specialization)',
                        'year' => '4th Year',
                        'credits' => '19 Credits',
                        'file' => 'assets/files/syllabus-ece-sem-7.pdf',
                        'core_subjects' => [
                            ['code' => 'EC-701', 'title' => 'Wireless & 5G Cellular Communications', 'credits' => 4, 'type' => 'Theory'],
                            ['code' => 'EC-702', 'title' => 'Internet of Things (IoT) Architectures & Protocols', 'credits' => 3, 'type' => 'Theory'],
                            ['code' => 'EC-PE3', 'title' => 'Professional Elective III: Biomedical Electronics', 'credits' => 3, 'type' => 'Elective'],
                            ['code' => 'OE-701', 'title' => 'Open Elective I: Renewable Energy & Power Systems', 'credits' => 3, 'type' => 'Open Elective'],
                            ['code' => 'EC-703P', 'title' => 'Capstone Project Stage-I & Hardware Architecture', 'credits' => 4, 'type' => 'Project'],
                            ['code' => 'EC-704I', 'title' => 'Industrial Summer Internship Seminar', 'credits' => 2, 'type' => 'Internship'],
                        ]
                    ],
                    8 => [
                        'semester' => 8,
                        'name' => 'Semester VIII (4th Year Capstone)',
                        'year' => '4th Year',
                        'credits' => '16 Credits',
                        'file' => 'assets/files/syllabus-ece-sem-8.pdf',
                        'core_subjects' => [
                            ['code' => 'EC-801', 'title' => 'Major Capstone Project Stage-II (Hardware Defense)', 'credits' => 10, 'type' => 'Project'],
                            ['code' => 'EC-PE4', 'title' => 'Professional Elective IV: Satellite & Deep Space Communication', 'credits' => 3, 'type' => 'Elective'],
                            ['code' => 'OE-801', 'title' => 'Open Elective II: Nanoelectronics & Quantum Computing', 'credits' => 3, 'type' => 'Open Elective'],
                            ['code' => 'EC-802V', 'title' => 'Comprehensive Technical Viva-Voce', 'credits' => 2, 'type' => 'Viva'],
                        ]
                    ],
                ]
            ],

            'common' => [
                'code' => 'COMMON',
                'name' => 'Common 1st Year (Applied Sciences & Humanities)',
                'short_name' => '1st Year Foundation',
                'degree' => 'B.Tech Common Foundation (All Branches)',
                'icon' => 'fa-solid fa-atom',
                'badge_color' => '#10B981',
                'intake' => 300,
                'duration' => '1st Year (Semesters I & II)',
                'curriculum_scheme' => 'AICTE Model Curriculum & University of Kashmir Scheme 2026',
                'description' => 'Universal foundational curriculum taken by all engineering students in Semesters 1 and 2, establishing core competencies in Mathematics, Physics, Chemistry, C Programming, Workshop, and Graphics.',
                'full_syllabus_file' => 'assets/files/syllabus-common-1st-year.pdf',
                'semesters' => $common1stYear,
            ],
        ];
    }
}

