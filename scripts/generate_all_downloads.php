<?php
define('ROOT_PATH', dirname(__DIR__));
spl_autoload_register(function (string $class) {
    $prefix = 'App\\';
    $baseDir = ROOT_PATH . '/app/';
    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) return;
    $relativeClass = substr($class, $len);
    $file = $baseDir . str_replace('\\', '/', $relativeClass) . '.php';
    if (file_exists($file)) require_once $file;
});
require_once ROOT_PATH . '/app/Helpers/helpers.php';

function buildPdf(string $title, string $subtitle, string $categoryLabel, array $sections, ?string $footer = null): string {
    $content = "%PDF-1.4\n";
    $offsets = [];
    
    // 1: Catalog
    $offsets[1] = strlen($content);
    $content .= "1 0 obj\n<< /Type /Catalog /Pages 2 0 R >>\nendobj\n";
    
    // 2: Pages
    $offsets[2] = strlen($content);
    $content .= "2 0 obj\n<< /Type /Pages /Kids [3 0 R] /Count 1 >>\nendobj\n";
    
    // Text stream
    $stream = "BT\n";
    // Top border & header
    $stream .= "/F2 16 Tf\n50 785 Td\n(KASHMIR COLLEGE OF ENGINEERING & TECHNOLOGY) Tj\n";
    $stream .= "/F1 10 Tf\n0 -18 Td\n(Approved by AICTE New Delhi | Affiliated with the University of Kashmir) Tj\n";
    $stream .= "0 -14 Td\n(Campus: Ranbirgarh Narbal, Srinagar - 190017, Jammu & Kashmir | Web: https://kcet.edu.in) Tj\n";
    
    // Divider line simulation
    $stream .= "/F2 13 Tf\n0 -30 Td\n(" . addcslashes($title, "()\\") . ") Tj\n";
    $stream .= "/F1 10 Tf\n0 -16 Td\n(" . addcslashes($subtitle, "()\\") . "  |  Category: " . addcslashes($categoryLabel, "()\\") . ") Tj\n";
    $stream .= "0 -14 Td\n(Curriculum Model: AICTE Model Curriculum / University of Kashmir Ordinances) Tj\n";
    
    $yPos = 0;
    foreach ($sections as $heading => $items) {
        $stream .= "/F2 11 Tf\n0 -22 Td\n(" . addcslashes($heading, "()\\") . ") Tj\n";
        $stream .= "/F1 9 Tf\n";
        if (is_array($items)) {
            foreach ($items as $item) {
                $stream .= "0 -14 Td\n(  * " . addcslashes($item, "()\\") . ") Tj\n";
            }
        } else {
            $stream .= "0 -14 Td\n(  " . addcslashes($items, "()\\") . ") Tj\n";
        }
    }
    
    $footerText = $footer ?? "Official Academic Document issued by Academic Affairs & Examination Cell, KCET Srinagar.";
    $stream .= "/F1 8 Tf\n0 -30 Td\n(" . addcslashes($footerText, "()\\") . ") Tj\n";
    $stream .= "0 -12 Td\n(Helpline: +91 88994 12793, +91 96221 61642 | Email: info@kcet.edu.in) Tj\n";
    $stream .= "ET";
    
    $streamLen = strlen($stream);
    
    // 4: Font Helvetica
    $offsets[4] = strlen($content);
    $content .= "4 0 obj\n<< /Type /Font /Subtype /Type1 /BaseFont /Helvetica >>\nendobj\n";

    // 5: Font Helvetica-Bold
    $offsets[5] = strlen($content);
    $content .= "5 0 obj\n<< /Type /Font /Subtype /Type1 /BaseFont /Helvetica-Bold >>\nendobj\n";
    
    // 6: Contents
    $offsets[6] = strlen($content);
    $content .= "6 0 obj\n<< /Length $streamLen >>\nstream\n$stream\nendstream\nendobj\n";
    
    // 3: Page
    $offsets[3] = strlen($content);
    $content .= "3 0 obj\n<< /Type /Page /Parent 2 0 R /MediaBox [0 0 595 842] /Contents 6 0 R /Resources << /Font << /F1 4 0 R /F2 5 0 R >> >> >>\nendobj\n";
    
    // xref
    $xrefOffset = strlen($content);
    $content .= "xref\n0 7\n0000000000 65535 f \n";
    for ($i = 1; $i <= 6; $i++) {
        $content .= sprintf("%010d 00000 n \n", $offsets[$i]);
    }
    $content .= "trailer\n<< /Size 7 /Root 1 0 R >>\nstartxref\n$xrefOffset\n%%EOF\n";
    
    return $content;
}

$destDir = ROOT_PATH . '/public/assets/files';
if (!is_dir($destDir)) {
    mkdir($destDir, 0755, true);
}

$documents = [];

// 1. Institutional Documents & Forms
$documents[] = [
    'file' => 'kcet-prospectus-2026.pdf',
    'title' => 'KCET Information Prospectus 2026-27',
    'subtitle' => 'Comprehensive Guide to Campus, Academic Programmes & Life at KCET',
    'category' => 'prospectus',
    'branch' => 'all',
    'semester' => 0,
    'sections' => [
        'Institutional Overview' => [
            'Established in 2007 under the aegis of the S.R. Educational Trust',
            'Affiliated with the prestigious University of Kashmir and approved by AICTE, New Delhi',
            'Located on the scenic Baramulla-Srinagar Highway at Ranbirgarh (Narbal)',
            'State-of-the-art campus featuring high-tech engineering laboratories, smart lecture halls, and library'
        ],
        'Available B.Tech Engineering Programmes' => [
            'Artificial Intelligence Engineering (Intake: 60 seats)',
            'Computer Engineering (Intake: 60 seats)',
            'Civil Engineering (Intake: 60 seats)',
            'Information Technology (Intake: 60 seats)',
            'Electronics & Communication Engineering (Intake: 60 seats)'
        ],
        'Student Amenities & Facilities' => [
            'Spacious Central Library with 25,000+ volumes, IEEE / DelNet digital journals',
            'Dedicated campus transport fleet covering Srinagar, Budgam, Baramulla, and Ganderbal',
            'Separate residential hostels for male and female scholars with high-speed Wi-Fi',
            'Active Training & Placement Cell (T&P) with strong industry partnerships and campus recruitment drives'
        ]
    ]
];

$documents[] = [
    'file' => 'kcet-btech-admission-guide-2026.pdf',
    'title' => 'B.Tech Admission Guide & Fee Structure 2026-27',
    'subtitle' => 'Eligibility Criteria, Seat Distribution & Fee Payment Schedules',
    'category' => 'prospectus',
    'branch' => 'all',
    'semester' => 0,
    'sections' => [
        'Eligibility Requirements (First Year B.Tech)' => [
            'Passed 10+2 examination with Physics and Mathematics as compulsory subjects',
            'Minimum 45% aggregate marks (40% for candidates belonging to reserved categories)',
            'Valid score in JKBOPEE CET or KCET Institutional Entrance / Merit Quota'
        ],
        'Lateral Entry Eligibility (3rd Semester Direct Entry)' => [
            'Passed 3-Year Diploma in Engineering/Technology from state technical board with min 45% marks',
            'Or B.Sc. Degree from recognized university with Mathematics in 10+2'
        ],
        'Fee Structure & Scholarships' => [
            'Tuition fee regulated strictly as per J&K Higher Education & Fee Regulatory Committee norms',
            'Merit scholarships available for top 10% entrance rankers and economically backward students',
            'Payment mode: Online net banking, RTGS/NEFT, or bank draft in favor of KCET Srinagar'
        ]
    ]
];

$documents[] = [
    'file' => 'admission-form-offline.pdf',
    'title' => 'Application Form for Admission (Offline Printable Form)',
    'subtitle' => 'Official Walk-in Application Form for B.Tech First Year & Lateral Entry',
    'category' => 'forms',
    'branch' => 'all',
    'semester' => 0,
    'sections' => [
        'Form Instructions' => [
            'Fill all entries in capital letters using blue or black ballpoint pen',
            'Attach attested photocopies of 10th & 12th Marks Cards, Domicile Certificate, and Category Certificate',
            'Attach 4 recent passport-size colored photographs with name written on reverse',
            'Submit completed form at Admission Cell, KCET Campus Ranbirgarh Narbal'
        ],
        'Applicant Sections' => [
            'Section A: Candidate Personal & Demographic Particulars',
            'Section B: Academic Qualifications (10th, 12th, Diploma details, Board, Percentage)',
            'Section C: Programme Preference (AI, CE, Civil, IT, ECE)',
            'Section D: Declaration by Candidate and Parent / Guardian'
        ]
    ]
];

$documents[] = [
    'file' => 'hostel-transport-application-form.pdf',
    'title' => 'Hostel Accommodation & Campus Bus Registration Form',
    'subtitle' => 'Student Services Registration for Residential Facilities & Commuter Bus Routes',
    'category' => 'forms',
    'branch' => 'all',
    'semester' => 0,
    'sections' => [
        'Campus Transport Services' => [
            'Route 1: Lal Chowk - Batamaloo - HMT - Narbal Campus',
            'Route 2: Soura - Hazratbal - Parimpora - Narbal Campus',
            'Route 3: Baramulla - Pattan - Sangrama - Narbal Campus',
            'Route 4: Budgam - Ompora - Soibugh - Narbal Campus'
        ],
        'Hostel Accommodation Rules' => [
            'Strict anti-ragging compliance and biometric attendance monitoring',
            'Furnished rooms with 24/7 power backup, solar heating, and mess facility',
            'Parental consent and local guardian details mandatory at the time of allotment'
        ]
    ]
];

$documents[] = [
    'file' => 'merit-scholarship-application-form.pdf',
    'title' => 'Merit & Need-Based Fee Concession Form 2026',
    'subtitle' => 'Financial Aid and Tuition Fee Waiver Scheme Application',
    'category' => 'forms',
    'branch' => 'all',
    'semester' => 0,
    'sections' => [
        'Concession Categories' => [
            'Category 1: Academic Excellence (JKBOPEE Top Rankers & >90% in 10+2 PCM)',
            'Category 2: Need-Based / Orphan / Economically Weaker Section (EWS)',
            'Category 3: Wards of Martyrs and Defence / Police Personnel',
            'Category 4: Girl Student STEM Scholarship Incentive'
        ],
        'Mandatory Documentation' => [
            'Valid income certificate issued by competent revenue authority (Tehsildar)',
            'Previous academic marksheets and proof of admission at KCET'
        ]
    ]
];

$documents[] = [
    'file' => 'academic-calendar-2026.pdf',
    'title' => 'Academic Calendar (Spring & Autumn Sessions 2026)',
    'subtitle' => 'Official Schedule of Instruction, Sessional Exams, Seminars & Vacations',
    'category' => 'circular',
    'branch' => 'all',
    'semester' => 0,
    'sections' => [
        'Spring Semester 2026 (Even Semesters: II, IV, VI, VIII)' => [
            'Commencement of Classes: March 02, 2026',
            'First Minor Sessional Examinations: April 20 - April 25, 2026',
            'Second Minor Sessional Examinations: June 01 - June 06, 2026',
            'Preparatory Leave & End-Semester Examinations (University of Kashmir): June 22 onwards'
        ],
        'Autumn Semester 2026 (Odd Semesters: I, III, V, VII)' => [
            'Commencement of Classes & Induction: August 10, 2026',
            'Mid-Term Examinations: October 12 - October 17, 2026',
            'Tech-Fest & Cultural Week: November 05 - November 08, 2026',
            'University End-Term Theory & Lab Examinations: December 14 onwards'
        ]
    ]
];

$documents[] = [
    'file' => 'uok-examination-ordinances.pdf',
    'title' => 'University of Kashmir B.Tech Examination Regulations',
    'subtitle' => 'Evaluation Scheme, Minimum Attendance, Passing Standards & Grading System',
    'category' => 'circular',
    'branch' => 'all',
    'semester' => 0,
    'sections' => [
        'Credit & Grading Structure' => [
            'Total Credits for B.Tech Degree: 160 Credits (120 Credits for Lateral Entry)',
            '10-point Absolute Grading Scale: O (10), A+ (9), A (8), B+ (7), B (6), C (5), P (4), F (0)',
            'Minimum SGPA & CGPA required for degree award: 5.0'
        ],
        'Attendance & Sessional Requirements' => [
            'Minimum 75% attendance mandatory in each registered theory lecture and practical laboratory',
            'Internal sessional evaluation accounts for 40% (tests, assignments, lab work)',
            'External university end-semester examination accounts for 60%'
        ]
    ]
];

$documents[] = [
    'file' => 'aicte-anti-ragging-affidavit.pdf',
    'title' => 'AICTE Anti-Ragging Affidavit & Student Code of Conduct',
    'subtitle' => 'Zero Tolerance Policy Guidelines & Mandatory Student Undertaking',
    'category' => 'circular',
    'branch' => 'all',
    'semester' => 0,
    'sections' => [
        'Anti-Ragging Compliance' => [
            'Ragging in any form is strictly banned inside and outside the college campus',
            'Any student found guilty faces immediate suspension, expulsion, and lodging of FIR',
            'National Anti-Ragging Toll-Free Helpline: 1800-180-5522',
            'KCET Proctorial Board & Anti-Ragging Squad emergency number: +91 88994 12793'
        ]
    ]
];

// 2. Common 1st Year Syllabi
$documents[] = [
    'file' => 'syllabus-common-1st-year.pdf',
    'title' => 'Common First Year (Applied Sciences & Humanities) - Full Scheme',
    'subtitle' => 'Semesters 1 & 2 Foundation Curricula for All B.Tech Branches',
    'category' => 'syllabus',
    'branch' => 'common',
    'semester' => 0,
    'sections' => [
        'Semester 1 (Group A/B Foundation)' => [
            'BSC-101: Engineering Mathematics-I (Calculus & Linear Algebra) - 4 Credits',
            'BSC-102: Engineering Physics (Electromagnetism & Wave Optics) - 4 Credits',
            'ESC-101: Basic Electrical Engineering - 4 Credits',
            'ESC-102: Engineering Graphics & CAD Drafting - 3 Credits',
            'BSC-103P: Engineering Physics Laboratory - 1.5 Credits',
            'ESC-103P: Basic Electrical Lab - 1 Credit',
            'MC-101: Environmental Sciences & Ecology - Audit'
        ],
        'Semester 2 (Group B/A Foundation)' => [
            'BSC-104: Engineering Mathematics-II (Vector Calculus & ODEs) - 4 Credits',
            'BSC-105: Engineering Chemistry (Polymer Science & Spectroscopy) - 4 Credits',
            'ESC-104: Programming for Problem Solving with C - 4 Credits',
            'ESC-105: Workshop & Manufacturing Technologies - 3 Credits',
            'HSMC-101: Professional Communication & Soft Skills - 2 Credits',
            'ESC-106P: Programming Lab in C - 1.5 Credits',
            'BSC-106P: Engineering Chemistry Laboratory - 1.5 Credits'
        ]
    ]
];

$documents[] = [
    'file' => 'syllabus-common-sem-1.pdf',
    'title' => 'Common First Year - Semester I Syllabus',
    'subtitle' => 'Calculus, Applied Physics, Basic Electrical & Engineering Graphics',
    'category' => 'syllabus',
    'branch' => 'common',
    'semester' => 1,
    'sections' => [
        'Curriculum Breakdown' => [
            'BSC-101: Engineering Mathematics-I (Calculus, Matrices & Eigenvalues) - 4 Credits',
            'BSC-102: Engineering Physics (Electromagnetism, Quantum & Optics) - 4 Credits',
            'ESC-101: Basic Electrical Engineering (DC/AC Circuits & Transformers) - 4 Credits',
            'ESC-102: Engineering Graphics & CAD Design (AutoCAD & Projections) - 3 Credits',
            'BSC-103P: Engineering Physics Laboratory - 1.5 Credits',
            'ESC-103P: Basic Electrical Engineering Practical Lab - 1 Credit',
            'MC-101: Environmental Sciences (Ecosystems & Sustainable Development) - Audit'
        ]
    ]
];

$documents[] = [
    'file' => 'syllabus-common-sem-2.pdf',
    'title' => 'Common First Year - Semester II Syllabus',
    'subtitle' => 'Differential Equations, Chemistry, C Programming & Workshop Practice',
    'category' => 'syllabus',
    'branch' => 'common',
    'semester' => 2,
    'sections' => [
        'Curriculum Breakdown' => [
            'BSC-104: Engineering Mathematics-II (ODEs, Vector Calculus & Series) - 4 Credits',
            'BSC-105: Engineering Chemistry (Spectroscopy, Electrochemistry & Polymers) - 4 Credits',
            'ESC-104: Programming for Problem Solving (C Language & Algorithms) - 4 Credits',
            'ESC-105: Workshop & Manufacturing Practices (Carpentry, Welding, Fitting) - 3 Credits',
            'HSMC-101: Professional Technical Communication & Soft Skills - 2 Credits',
            'ESC-106P: Programming for Problem Solving Practical Lab - 1.5 Credits',
            'BSC-106P: Engineering Chemistry Laboratory - 1.5 Credits'
        ]
    ]
];

// Branch definitions
$branches = [
    'ai' => [
        'name' => 'Artificial Intelligence Engineering',
        'code' => 'AI',
        'file_full' => 'syllabus-ai.pdf',
        'title_full' => 'B.Tech in Artificial Intelligence Engineering - Complete Syllabus',
        'semesters' => [
            3 => [
                'title' => 'B.Tech AI - Semester III Syllabus',
                'file' => 'syllabus-ai-sem-3.pdf',
                'subjects' => [
                    'AI-301: Discrete Mathematics & Graph Theory (4 Credits)',
                    'AI-302: Data Structures & Algorithms with C++ (4 Credits)',
                    'AI-303: Digital Electronics & Logic Design (3 Credits)',
                    'AI-304: Python Programming for Data Science & AI (3 Credits)',
                    'AI-305: Computer Organization & Architecture (3 Credits)',
                    'AI-306P: Data Structures & Algorithms Lab (2 Credits)',
                    'AI-307P: Python AI Development Lab (2 Credits)'
                ]
            ],
            4 => [
                'title' => 'B.Tech AI - Semester IV Syllabus',
                'file' => 'syllabus-ai-sem-4.pdf',
                'subjects' => [
                    'AI-401: Linear Algebra & Matrix Methods for Machine Learning (4 Credits)',
                    'AI-402: Database Management Systems & NoSQL (4 Credits)',
                    'AI-403: Operating Systems & Systems Programming (3 Credits)',
                    'AI-404: Foundations of Artificial Intelligence & State-Space Search (4 Credits)',
                    'AI-405: Object-Oriented Software Engineering (3 Credits)',
                    'AI-406P: Artificial Intelligence & Search Lab (2 Credits)',
                    'AI-407P: Database Management Systems Lab (2 Credits)'
                ]
            ],
            5 => [
                'title' => 'B.Tech AI - Semester V Syllabus',
                'file' => 'syllabus-ai-sem-5.pdf',
                'subjects' => [
                    'AI-501: Machine Learning: Supervised, Unsupervised & Ensemble Methods (4 Credits)',
                    'AI-502: Knowledge Representation & Semantic Reasoning (3 Credits)',
                    'AI-503: Formal Languages & Automata Theory (3 Credits)',
                    'AI-504: Computer Networks & Distributed Protocols (3 Credits)',
                    'AI-PE1: Professional Elective I: Optimization Techniques for AI (3 Credits)',
                    'AI-505P: Machine Learning Lab in PyTorch & Scikit-Learn (2 Credits)',
                    'AI-506P: Knowledge Engineering & Prolog Lab (2 Credits)',
                    'HS-501: Management Principles & Engineering Economics (2 Credits)'
                ]
            ],
            6 => [
                'title' => 'B.Tech AI - Semester VI Syllabus',
                'file' => 'syllabus-ai-sem-6.pdf',
                'subjects' => [
                    'AI-601: Deep Learning & Neural Network Architectures (CNN, RNN, Transformers) (4 Credits)',
                    'AI-602: Computer Vision, Image Processing & Object Detection (4 Credits)',
                    'AI-603: Reinforcement Learning & Multi-Agent Intelligent Systems (3 Credits)',
                    'AI-604: Cloud Computing, Big Data Infrastructure & MLOps (3 Credits)',
                    'AI-PE2: Professional Elective II: Natural Language Processing (3 Credits)',
                    'AI-605P: Deep Learning & Computer Vision Lab (2 Credits)',
                    'AI-606P: Cloud Infrastructure & MLOps Deployment Lab (2 Credits)'
                ]
            ],
            7 => [
                'title' => 'B.Tech AI - Semester VII Syllabus',
                'file' => 'syllabus-ai-sem-7.pdf',
                'subjects' => [
                    'AI-701: Generative AI, Large Language Models (LLMs) & Diffusion Models (4 Credits)',
                    'AI-702: AI Ethics, Safety, Bias & Explainable AI (XAI) (3 Credits)',
                    'AI-PE3: Professional Elective III: Edge AI & Embedded Machine Learning (3 Credits)',
                    'OE-701: Open Elective I: Cybersecurity & Threat Intelligence (3 Credits)',
                    'AI-703P: Capstone Project Stage-I & Research Proposal (4 Credits)',
                    'AI-704I: Industrial Summer Internship Evaluation & Seminar (2 Credits)'
                ]
            ],
            8 => [
                'title' => 'B.Tech AI - Semester VIII Syllabus',
                'file' => 'syllabus-ai-sem-8.pdf',
                'subjects' => [
                    'AI-801: Major Capstone Project Stage-II (Working Model & Defense) (10 Credits)',
                    'AI-PE4: Professional Elective IV: Autonomous Robotics & Self-Driving Systems (3 Credits)',
                    'OE-801: Open Elective II: Intellectual Property Rights & Tech Entrepreneurship (3 Credits)',
                    'AI-802V: Comprehensive Technical Viva-Voce (2 Credits)'
                ]
            ]
        ]
    ],
    'ce' => [
        'name' => 'Computer Engineering',
        'code' => 'CE',
        'file_full' => 'syllabus-ce.pdf',
        'title_full' => 'B.Tech in Computer Engineering - Complete Syllabus',
        'semesters' => [
            3 => [
                'title' => 'B.Tech CE - Semester III Syllabus',
                'file' => 'syllabus-ce-sem-3.pdf',
                'subjects' => [
                    'CE-301: Discrete Mathematics & Structures (4 Credits)',
                    'CE-302: Data Structures & Algorithms (4 Credits)',
                    'CE-303: Digital Electronics & Logic Design (3 Credits)',
                    'CE-304: Object-Oriented Programming with Java (3 Credits)',
                    'CE-305: Computer Organization & Architecture (3 Credits)',
                    'CE-306P: Data Structures Practical Lab (2 Credits)',
                    'CE-307P: Java Programming Lab (2 Credits)'
                ]
            ],
            4 => [
                'title' => 'B.Tech CE - Semester IV Syllabus',
                'file' => 'syllabus-ce-sem-4.pdf',
                'subjects' => [
                    'CE-401: Design & Analysis of Algorithms (4 Credits)',
                    'CE-402: Operating Systems (4 Credits)',
                    'CE-403: Database Management Systems (4 Credits)',
                    'CE-404: Theory of Computation & Automata (3 Credits)',
                    'CE-405: Software Engineering & UML (3 Credits)',
                    'CE-406P: Operating Systems & Linux Lab (2 Credits)',
                    'CE-407P: DBMS & SQL Lab (2 Credits)'
                ]
            ],
            5 => [
                'title' => 'B.Tech CE - Semester V Syllabus',
                'file' => 'syllabus-ce-sem-5.pdf',
                'subjects' => [
                    'CE-501: Computer Networks & TCP/IP (4 Credits)',
                    'CE-502: Compiler Design (4 Credits)',
                    'CE-503: Microprocessors & Microcontrollers (3 Credits)',
                    'CE-504: Web Technologies & Full-Stack Development (3 Credits)',
                    'CE-PE1: Professional Elective I: Data Mining & Warehousing (3 Credits)',
                    'CE-505P: Computer Networks & Socket Lab (2 Credits)',
                    'CE-506P: Web Development & Frameworks Lab (2 Credits)'
                ]
            ],
            6 => [
                'title' => 'B.Tech CE - Semester VI Syllabus',
                'file' => 'syllabus-ce-sem-6.pdf',
                'subjects' => [
                    'CE-601: Information & Network Security (4 Credits)',
                    'CE-602: Cloud Computing & Virtualization (4 Credits)',
                    'CE-603: Artificial Intelligence & Expert Systems (3 Credits)',
                    'CE-PE2: Professional Elective II: Internet of Things (IoT) (3 Credits)',
                    'CE-604P: Network Security & Cryptography Lab (2 Credits)',
                    'CE-605P: Cloud Platforms & DevOps Lab (2 Credits)'
                ]
            ],
            7 => [
                'title' => 'B.Tech CE - Semester VII Syllabus',
                'file' => 'syllabus-ce-sem-7.pdf',
                'subjects' => [
                    'CE-701: Distributed Systems & Cloud Infrastructure (4 Credits)',
                    'CE-702: Machine Learning Foundations (4 Credits)',
                    'CE-PE3: Professional Elective III: Mobile Application Development (3 Credits)',
                    'OE-701: Open Elective I: Engineering Economics (3 Credits)',
                    'CE-703P: Capstone Project Stage-I (4 Credits)',
                    'CE-704I: Industry Summer Internship Evaluation (2 Credits)'
                ]
            ],
            8 => [
                'title' => 'B.Tech CE - Semester VIII Syllabus',
                'file' => 'syllabus-ce-sem-8.pdf',
                'subjects' => [
                    'CE-801: Major Capstone Project Stage-II (10 Credits)',
                    'CE-PE4: Professional Elective IV: Blockchain Technologies & Smart Contracts (3 Credits)',
                    'OE-801: Open Elective II: Cyber Laws & Intellectual Property (3 Credits)',
                    'CE-802V: Comprehensive Technical Viva-Voce (2 Credits)'
                ]
            ]
        ]
    ],
    'civil' => [
        'name' => 'Civil Engineering',
        'code' => 'CIVIL',
        'file_full' => 'syllabus-civil.pdf',
        'title_full' => 'B.Tech in Civil Engineering - Complete Syllabus',
        'semesters' => [
            3 => [
                'title' => 'B.Tech Civil - Semester III Syllabus',
                'file' => 'syllabus-civil-sem-3.pdf',
                'subjects' => [
                    'CE-301: Mathematics-III (PDEs & Numerical Methods) (4 Credits)',
                    'CE-302: Mechanics of Solids / Strength of Materials (4 Credits)',
                    'CE-303: Fluid Mechanics & Hydraulics (4 Credits)',
                    'CE-304: Surveying-I (Principles & Levelling) (3 Credits)',
                    'CE-305: Building Materials & Construction Tech (3 Credits)',
                    'CE-306P: Surveying Practice Lab (2 Credits)',
                    'CE-307P: Material Testing Lab (2 Credits)'
                ]
            ],
            4 => [
                'title' => 'B.Tech Civil - Semester IV Syllabus',
                'file' => 'syllabus-civil-sem-4.pdf',
                'subjects' => [
                    'CE-401: Structural Analysis-I (Determinate Structures) (4 Credits)',
                    'CE-402: Hydraulic Engineering & Open Channel Flow (4 Credits)',
                    'CE-403: Surveying-II (Advanced Theodolite & Total Station) (3 Credits)',
                    'CE-404: Concrete Technology & Mix Design (3 Credits)',
                    'CE-405: Engineering Geology & Rock Mechanics (3 Credits)',
                    'CE-406P: Concrete Technology Lab (2 Credits)',
                    'CE-407P: Fluid Mechanics & Hydraulic Machinery Lab (2 Credits)'
                ]
            ],
            5 => [
                'title' => 'B.Tech Civil - Semester V Syllabus',
                'file' => 'syllabus-civil-sem-5.pdf',
                'subjects' => [
                    'CE-501: Structural Analysis-II (Indeterminate Structures & Matrix Methods) (4 Credits)',
                    'CE-502: Design of Reinforced Concrete Structures (IS 456) (4 Credits)',
                    'CE-503: Geotechnical Engineering-I (Soil Mechanics) (4 Credits)',
                    'CE-504: Hydrology & Water Resources Engineering (3 Credits)',
                    'CE-PE1: Professional Elective I: Environmental Impact Assessment (3 Credits)',
                    'CE-505P: Soil Mechanics & Geotechnical Lab (2 Credits)',
                    'CE-506P: Structural Design & Drafting Lab (2 Credits)'
                ]
            ],
            6 => [
                'title' => 'B.Tech Civil - Semester VI Syllabus',
                'file' => 'syllabus-civil-sem-6.pdf',
                'subjects' => [
                    'CE-601: Design of Steel Structures (IS 800) (4 Credits)',
                    'CE-602: Geotechnical Engineering-II (Foundation Engineering) (4 Credits)',
                    'CE-603: Transportation Engineering-I (Highway Engineering) (4 Credits)',
                    'CE-604: Environmental Engineering-I (Water Supply Systems) (3 Credits)',
                    'CE-PE2: Professional Elective II: Irrigation Engineering (3 Credits)',
                    'CE-605P: Transportation Engineering Lab (2 Credits)',
                    'CE-606P: Environmental Engineering Lab (2 Credits)'
                ]
            ],
            7 => [
                'title' => 'B.Tech Civil - Semester VII Syllabus',
                'file' => 'syllabus-civil-sem-7.pdf',
                'subjects' => [
                    'CE-701: Transportation Engineering-II (Airports, Railways & Harbors) (3 Credits)',
                    'CE-702: Environmental Engineering-II (Sewage & Wastewater Treatment) (3 Credits)',
                    'CE-703: Estimating, Costing & Valuation (3 Credits)',
                    'CE-PE3: Professional Elective III: Earthquake Resistant Design of Structures (3 Credits)',
                    'OE-701: Open Elective I: Disaster Management & Mitigation (3 Credits)',
                    'CE-704P: Capstone Project Stage-I (4 Credits)',
                    'CE-705I: Practical Survey Camp / Industrial Training Evaluation (2 Credits)'
                ]
            ],
            8 => [
                'title' => 'B.Tech Civil - Semester VIII Syllabus',
                'file' => 'syllabus-civil-sem-8.pdf',
                'subjects' => [
                    'CE-801: Major Capstone Project Stage-II (Comprehensive Civil Design) (10 Credits)',
                    'CE-PE4: Professional Elective IV: Construction Planning, Management & Equipment (3 Credits)',
                    'OE-801: Open Elective II: Urban Planning & Smart Cities Infrastructure (3 Credits)',
                    'CE-802V: Comprehensive Technical Viva-Voce (2 Credits)'
                ]
            ]
        ]
    ],
    'it' => [
        'name' => 'Information Technology',
        'code' => 'IT',
        'file_full' => 'syllabus-it.pdf',
        'title_full' => 'B.Tech in Information Technology - Complete Syllabus',
        'semesters' => [
            3 => [
                'title' => 'B.Tech IT - Semester III Syllabus',
                'file' => 'syllabus-it-sem-3.pdf',
                'subjects' => [
                    'IT-301: Discrete Mathematical Structures (4 Credits)',
                    'IT-302: Data Structures & Algorithms (4 Credits)',
                    'IT-303: Digital Electronics & Logic Design (3 Credits)',
                    'IT-304: Object-Oriented Methodology using Java (3 Credits)',
                    'IT-305: Principles of Communication Systems (3 Credits)',
                    'IT-306P: Data Structures Lab (2 Credits)',
                    'IT-307P: Java Programming Lab (2 Credits)'
                ]
            ],
            4 => [
                'title' => 'B.Tech IT - Semester IV Syllabus',
                'file' => 'syllabus-it-sem-4.pdf',
                'subjects' => [
                    'IT-401: Computer Organization & Microprocessors (4 Credits)',
                    'IT-402: Database Management Systems (4 Credits)',
                    'IT-403: Design & Analysis of Algorithms (4 Credits)',
                    'IT-404: Operating Systems Concepts (3 Credits)',
                    'IT-405: Software Engineering Principles (3 Credits)',
                    'IT-406P: DBMS & SQL Lab (2 Credits)',
                    'IT-407P: Operating Systems & Shell Programming Lab (2 Credits)'
                ]
            ],
            5 => [
                'title' => 'B.Tech IT - Semester V Syllabus',
                'file' => 'syllabus-it-sem-5.pdf',
                'subjects' => [
                    'IT-501: Computer Communication Networks (4 Credits)',
                    'IT-502: Formal Languages & Automata Theory (3 Credits)',
                    'IT-503: Web Development Frameworks (React & Node.js) (3 Credits)',
                    'IT-504: Information Storage & Management (3 Credits)',
                    'IT-PE1: Professional Elective I: Cyber Forensics & Investigation (3 Credits)',
                    'IT-505P: Web Engineering & Frameworks Lab (2 Credits)',
                    'IT-506P: Computer Networks & Protocol Lab (2 Credits)'
                ]
            ],
            6 => [
                'title' => 'B.Tech IT - Semester VI Syllabus',
                'file' => 'syllabus-it-sem-6.pdf',
                'subjects' => [
                    'IT-601: Information & Cryptographic Security (4 Credits)',
                    'IT-602: Software Project Management & Agile (3 Credits)',
                    'IT-603: Mobile Computing & Wireless Networks (3 Credits)',
                    'IT-604: Data Science & Analytics with Python (4 Credits)',
                    'IT-PE2: Professional Elective II: Enterprise Resource Planning (ERP) (3 Credits)',
                    'IT-605P: Mobile Application Development Lab (2 Credits)',
                    'IT-606P: Data Science & Analytics Lab (2 Credits)'
                ]
            ],
            7 => [
                'title' => 'B.Tech IT - Semester VII Syllabus',
                'file' => 'syllabus-it-sem-7.pdf',
                'subjects' => [
                    'IT-701: Cloud Computing & Virtualized Services (4 Credits)',
                    'IT-702: Big Data Technologies & Hadoop Ecosystem (3 Credits)',
                    'IT-PE3: Professional Elective III: DevOps & Continuous Integration (3 Credits)',
                    'OE-701: Open Elective I: IT Laws & Patenting (3 Credits)',
                    'IT-703P: Capstone Project Stage-I (4 Credits)',
                    'IT-704I: Industrial Summer Internship Evaluation (2 Credits)'
                ]
            ],
            8 => [
                'title' => 'B.Tech IT - Semester VIII Syllabus',
                'file' => 'syllabus-it-sem-8.pdf',
                'subjects' => [
                    'IT-801: Major Capstone Project Stage-II (Working IT Solution) (10 Credits)',
                    'IT-PE4: Professional Elective IV: Artificial Intelligence & Deep Learning (3 Credits)',
                    'OE-801: Open Elective II: Human-Computer Interaction (HCI) (3 Credits)',
                    'IT-802V: Comprehensive Technical Viva-Voce (2 Credits)'
                ]
            ]
        ]
    ],
    'ece' => [
        'name' => 'Electronics & Communication Engineering',
        'code' => 'ECE',
        'file_full' => 'syllabus-ece.pdf',
        'title_full' => 'B.Tech in Electronics & Communication - Complete Syllabus',
        'semesters' => [
            3 => [
                'title' => 'B.Tech ECE - Semester III Syllabus',
                'file' => 'syllabus-ece-sem-3.pdf',
                'subjects' => [
                    'ECE-301: Mathematics-III (Complex Variables & Transforms) (4 Credits)',
                    'ECE-302: Electronic Devices & Circuit Theory (4 Credits)',
                    'ECE-303: Network Analysis & Synthesis (4 Credits)',
                    'ECE-304: Signals & Linear Systems (3 Credits)',
                    'ECE-305: Digital System Design & Verilog (3 Credits)',
                    'ECE-306P: Analog Electronics Circuits Lab (2 Credits)',
                    'ECE-307P: Digital Logic & Simulation Lab (2 Credits)'
                ]
            ],
            4 => [
                'title' => 'B.Tech ECE - Semester IV Syllabus',
                'file' => 'syllabus-ece-sem-4.pdf',
                'subjects' => [
                    'ECE-401: Analog Communication Systems (AM, FM, PM) (4 Credits)',
                    'ECE-402: Linear Integrated Circuits & Op-Amps (4 Credits)',
                    'ECE-403: Electromagnetic Field Theory (EMFT) (4 Credits)',
                    'ECE-404: Microprocessor & Microcontroller Architectures (8085/8086) (3 Credits)',
                    'ECE-405: Probability Theory & Stochastic Processes (3 Credits)',
                    'ECE-406P: Analog Communication Lab (2 Credits)',
                    'ECE-407P: Linear Integrated Circuits Lab (2 Credits)'
                ]
            ],
            5 => [
                'title' => 'B.Tech ECE - Semester V Syllabus',
                'file' => 'syllabus-ece-sem-5.pdf',
                'subjects' => [
                    'ECE-501: Digital Communication Systems (QPSK, QAM, Coding) (4 Credits)',
                    'ECE-502: Digital Signal Processing (DSP & Filter Design) (4 Credits)',
                    'ECE-503: Control Systems Engineering (3 Credits)',
                    'ECE-504: Embedded Systems & ARM Cortex (3 Credits)',
                    'ECE-PE1: Professional Elective I: Electronic Instrumentation (3 Credits)',
                    'ECE-505P: Digital Communication & DSP Lab (2 Credits)',
                    'ECE-506P: Embedded Systems & Microcontrollers Lab (2 Credits)'
                ]
            ],
            6 => [
                'title' => 'B.Tech ECE - Semester VI Syllabus',
                'file' => 'syllabus-ece-sem-6.pdf',
                'subjects' => [
                    'ECE-601: VLSI Design & CMOS Technology (4 Credits)',
                    'ECE-602: Antenna & Wave Propagation (4 Credits)',
                    'ECE-603: Microwave & Radar Engineering (4 Credits)',
                    'ECE-604: Optical Fiber Communication Systems (3 Credits)',
                    'ECE-PE2: Professional Elective II: Wireless Sensor Networks (3 Credits)',
                    'ECE-605P: VLSI CAD & FPGA Simulation Lab (2 Credits)',
                    'ECE-606P: Microwave & Optical Fiber Lab (2 Credits)'
                ]
            ],
            7 => [
                'title' => 'B.Tech ECE - Semester VII Syllabus',
                'file' => 'syllabus-ece-sem-7.pdf',
                'subjects' => [
                    'ECE-701: Wireless & 5G Cellular Communications (4 Credits)',
                    'ECE-702: Internet of Things (IoT) Architectures & Protocols (3 Credits)',
                    'ECE-PE3: Professional Elective III: Biomedical Electronics (3 Credits)',
                    'OE-701: Open Elective I: Renewable Energy & Power Systems (3 Credits)',
                    'ECE-703P: Capstone Project Stage-I (4 Credits)',
                    'ECE-704I: Industrial Summer Internship Evaluation (2 Credits)'
                ]
            ],
            8 => [
                'title' => 'B.Tech ECE - Semester VIII Syllabus',
                'file' => 'syllabus-ece-sem-8.pdf',
                'subjects' => [
                    'ECE-801: Major Capstone Project Stage-II (Hardware / Embedded Defense) (10 Credits)',
                    'ECE-PE4: Professional Elective IV: Satellite & Deep Space Communication (3 Credits)',
                    'OE-801: Open Elective II: Nanoelectronics & Quantum Computing (3 Credits)',
                    'ECE-802V: Comprehensive Technical Viva-Voce (2 Credits)'
                ]
            ]
        ]
    ]
];

// Add Complete branch scheme documents
foreach ($branches as $branchKey => $bData) {
    $semSections = [];
    foreach ($bData['semesters'] as $semNum => $semData) {
        $semSections["Semester " . $semNum] = $semData['subjects'];
    }
    $documents[] = [
        'file' => $bData['file_full'],
        'title' => $bData['title_full'],
        'subtitle' => 'Approved AICTE 4-Year Scheme & Detailed Syllabus Booklet',
        'category' => 'syllabus',
        'branch' => $branchKey,
        'semester' => 0,
        'sections' => $semSections
    ];

    // Add Semester documents
    foreach ($bData['semesters'] as $semNum => $semData) {
        $documents[] = [
            'file' => $semData['file'],
            'title' => $semData['title'],
            'subtitle' => $bData['name'] . ' - Semester ' . $semNum . ' Course Modules & Scheme',
            'category' => 'syllabus',
            'branch' => $branchKey,
            'semester' => $semNum,
            'sections' => [
                'Semester ' . $semNum . ' Course Breakdown' => $semData['subjects'],
                'Teaching Scheme & Examination Scheme' => [
                    '4 Theory / Core Credits: 3 Lectures + 1 Tutorial per week (100 Marks)',
                    'Practical Labs: 2-3 Lab Hours per week (50 Marks)',
                    'Continuous Internal Evaluation (CIE): 40 Marks, University Semester Exam (SEE): 60 Marks'
                ]
            ]
        ];
    }
}

$db = App\Services\Database::getInstance();
$createdCount = 0;
$dbSyncedCount = 0;

echo "Generating " . count($documents) . " documents...\n";

foreach ($documents as $doc) {
    $filePath = 'assets/files/' . $doc['file'];
    $fullPath = ROOT_PATH . '/public/' . $filePath;
    
    // Generate PDF
    $pdfData = buildPdf(
        $doc['title'],
        $doc['subtitle'],
        ucfirst($doc['category']),
        $doc['sections']
    );
    file_put_contents($fullPath, $pdfData);
    $bytes = strlen($pdfData);
    $fileSize = $bytes > 1048576 ? round($bytes / 1048576, 1) . ' MB' : round($bytes / 1024, 1) . ' KB';
    $createdCount++;

    // Check if exists in DB
    $existing = $db->query("SELECT id FROM downloads WHERE file_path = :path LIMIT 1", [':path' => $filePath]);
    if (!empty($existing)) {
        $db->execute("UPDATE downloads SET title = :title, category = :cat, branch = :branch, semester = :sem, file_size = :size, is_active = 1 WHERE id = :id", [
            ':title' => $doc['title'],
            ':cat' => $doc['category'],
            ':branch' => $doc['branch'],
            ':sem' => $doc['semester'],
            ':size' => $fileSize,
            ':id' => $existing[0]['id']
        ]);
    } else {
        $db->execute("INSERT INTO downloads (title, category, branch, semester, file_path, file_type, file_size, publication_date, is_active) VALUES (:title, :cat, :branch, :sem, :path, 'PDF', :size, date('now'), 1)", [
            ':title' => $doc['title'],
            ':cat' => $doc['category'],
            ':branch' => $doc['branch'],
            ':sem' => $doc['semester'],
            ':path' => $filePath,
            ':size' => $fileSize
        ]);
    }
    $dbSyncedCount++;
}

echo "Successfully generated $createdCount PDF files and synced $dbSyncedCount database records!\n";

