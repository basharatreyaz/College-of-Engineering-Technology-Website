# Kashmir College of Engineering & Technology (KCET) Website

A modern, responsive, multi-page higher-education institution website built with **HTML5, CSS3, vanilla JavaScript, PHP 8+, and MySQL/MariaDB (with SQLite support for zero-configuration testing)**.

---

## 🏛️ Institution Details

- **Institution:** Kashmir College of Engineering & Technology (KCET)
- **Campus Location:** Ranbirgarh, Srinagar, Jammu and Kashmir 190001, India
- **Primary Phone:** `+91 88994 12793`
- **Email:** `info@kcet.edu.in` | `kcetsrinagar@gmail.com`
- **Institutional Tagline:** *"Engineering Futures, Innovating Today."*
- **Campus Scale:** Sprawling 100+ Kanal Green Campus, 360+ Approved Annual Intake, 5 Core B.Tech Disciplines.

---

## 🚀 Key Features

1. **Academic Catalog & B.Tech Programmes:**
   - B.Tech in Artificial Intelligence Engineering
   - B.Tech in Computer Engineering
   - B.Tech in Civil Engineering
   - B.Tech in Information Technology Engineering
   - B.Tech in Electronics and Communication Engineering
   - Full programme detail views with syllabus downloads, eligibility, and enquiry hooks.

2. **Campus Infrastructure (12 Standard Facilities):**
   - Spacious Library & Digital Resource Centre
   - Canteen & Cafeteria
   - Transport Fleet (routes across Srinagar, Budgam, Ganderbal)
   - Dedicated 100 Mbps Optical Fiber & Wi-Fi
   - Multipurpose Hall & Auditorium
   - Training & Placement Cell
   - Campus Medical Room
   - Advanced Computer Centre
   - Fire Safety & Smoke Detection
   - 24/7 CCTV Monitoring & Security
   - Ramps & Lifts (Barrier-Free Accessibility)
   - Spacious Parking

3. **Admissions & Online Registration:**
   - Multi-section registration form (`/apply`) with client + server-side validation.
   - Non-guessable application reference number generator (`KCET-2026-XXXX`).
   - Printable receipt and verification checklist.
   - Anti-spam honeypot protection & rate limiting.
   - Quick admission enquiry popup modal with session storage memory (never repeatedly annoys visitors).

4. **News, Events & Notices:**
   - Categorized official circulars (Admissions, Academics, Examinations, Recruitment).
   - Past and upcoming campus stories with dates and venues.
   - Downloadable circular and syllabus PDF attachments.

5. **Full-Featured Administration Portal (`/admin`):**
   - Role-Based Access Control (`superadmin`, `admissions`, `editor`).
   - Secure authentication with `password_hash()` and `password_verify()`.
   - Real-time dynamic dashboard metrics derived from database queries.
   - Full CRUD modules for:
     - Programmes
     - Departments
     - Faculty & Staff
     - Facilities
     - Notices & Circulars
     - Events & Stories
     - FAQs
     - Campus Gallery
     - Downloads / Syllabi
     - Enquiries Management (follow-up status, internal notes)
     - Student Applications (dossier view, status updates, status history trail)
     - Site Settings (hero headlines, ticker text, campus contacts, emergency notices)
     - Admin Users & Roles
     - Immutable Audit Trail

6. **SEO & Accessibility:**
   - Clean URLs with Apache rewrite rules and front controller.
   - Fallback query routing (`?r=/path`) ensuring zero broken links in any environment.
   - Dynamic XML Sitemap (`/sitemap.xml`) and `robots.txt`.
   - Mobile-first responsive design tested down to 320px width (zero horizontal overflow).
   - High-contrast academic color palette respecting `prefers-reduced-motion`.

---

## 📂 Project Directory Structure

```text
kcet/
├── public/                     # Public web root
│   ├── index.php               # Front controller & autoloader
│   ├── .htaccess               # Apache clean URL rewrite rules & security headers
│   ├── robots.txt              # Search engine crawler policies
│   ├── sitemap.php             # Dynamic XML sitemap generator
│   └── assets/
│       ├── css/
│       │   ├── style.css       # Core design system & CSS custom properties
│       │   ├── responsive.css  # Mobile breakpoints (<1024px, <768px, <480px)
│       │   └── admin.css       # Administration panel styles
│       ├── js/
│       │   ├── main.js         # Mobile drawer, FAQ accordion, modals
│       │   ├── forms.js        # Form validation & print utilities
│       │   └── admin.js        # Admin sidebar, delete confirms, auto-slug
│       ├── images/             # Public image assets
│       └── files/              # Uploaded PDFs and syllabi
├── app/
│   ├── Config/                 # Application configuration
│   ├── Controllers/            # Public front controllers
│   │   ├── HomeController.php
│   │   ├── PageController.php
│   │   ├── ProgrammeController.php
│   │   ├── DepartmentController.php
│   │   ├── FacultyController.php
│   │   ├── FacilityController.php
│   │   ├── NoticeController.php
│   │   ├── EventController.php
│   │   ├── DownloadController.php
│   │   ├── FormController.php
│   │   └── Admin/              # Admin panel controllers
│   ├── Middleware/             # Auth, CSRF, Rate-limiting
│   ├── Models/                 # Database models extending BaseModel
│   ├── Services/               # Database PDO, View, Router, Session, Upload, Mailer
│   ├── Views/                  # PHP templates, layouts, and components
│   ├── Helpers/                # helpers.php
│   └── Routes/                 # web.php
├── storage/
│   ├── logs/                   # Error and audit logs
│   ├── uploads/                # Uploaded public assets
│   ├── private/                # Private applicant uploads
│   └── database.sqlite         # SQLite database file (if using SQLite)
├── database/
│   ├── schema.sql              # MySQL 8+ / MariaDB schema
│   ├── seed.sql                # Verified KCET academic seed data
│   └── migrate.php             # CLI migration and seeding runner
├── .env.example                # Example environment file
├── .env                        # Active environment configuration
├── .gitignore
├── README.md
└── ai.md
```

---

## 🛠️ Installation & Setup Guide

### 1. Requirements
- PHP 8.2 or newer (Tested on PHP 8.4)
- PHP extensions: `pdo`, `pdo_sqlite` (or `pdo_mysql`), `mbstring`, `fileinfo`, `gd`
- Web server: Apache, Nginx, or PHP Built-in Server

### 2. Environment Configuration
Copy `.env.example` to `.env`:
```bash
cp .env.example .env
```

To use SQLite (instant zero-configuration mode):
```env
DB_CONNECTION=sqlite
DB_FILE=storage/database.sqlite
```

To use MySQL / MariaDB (e.g., inside Laragon):
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=kcet_db
DB_USERNAME=root
DB_PASSWORD=
```

### 3. Database Migration & Seeding
Run the automated migration tool:
```bash
php database/migrate.php --fresh --seed
```
This sets up all tables and populates verified KCET departments, programmes, faculty, facilities, notices, and default admin users.

### 4. Running Locally

#### Option A: Using PHP Built-in Server
From the project root:
```bash
php -S localhost:8000 -t public
```
Then visit `http://localhost:8000` in your browser.

#### Option B: Using Laragon Apache
- Place the repository in `D:\laragon\www\kcet`.
- Start Laragon (Apache + MySQL).
- Access via `http://localhost/kcet/` or `http://localhost/kcet/public/` (the root `.htaccess` handles both automatically).

---

## 🔐 Default Admin Credentials

Access the administration portal at `/admin/login`:

| Role | Email | Default Password | Permissions |
| :--- | :--- | :--- | :--- |
| **Super Admin** | `admin@kcet.edu.in` | `Admin@KCET2026!` | Full system control, settings, user accounts |
| **Admissions Staff** | `admissions@kcet.edu.in` | `Admissions@2026` | Applications, enquiries, applicant dossier |
| **Content Editor** | `editor@kcet.edu.in` | `Editor@KCET2026` | Notices, events, facilities, gallery, FAQs |

*Security note: Passwords can be changed via the Admin Users panel.*

---

## 🛡️ Security Measures

- **Prepared SQL Statements:** 100% of queries use PDO prepared statements with strict parameter binding.
- **CSRF Token Validation:** All state-changing `POST` endpoints enforce token verification.
- **Output Escaping:** All rendered variables are sanitized with `htmlspecialchars(..., ENT_QUOTES, 'UTF-8')`.
- **Upload Restrictions:** MIME type checking via `finfo`, random hex filenames, and execution prevention.
- **Session Protection:** Session ID regeneration upon login, `HttpOnly` and `SameSite` cookie flags.
- **Anti-Spam:** Honeypot fields (`form-hp`) and rate limiting across enquiry and application forms.
- **Audit Logging:** Sensitive actions are logged in the `admin_audit_logs` database table.

# collegewebsite
