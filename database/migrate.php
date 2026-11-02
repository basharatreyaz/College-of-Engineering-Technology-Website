<?php
declare(strict_types=1);

/**
 * KCET Database Migration & Seeding Tool
 * Usage: php database/migrate.php [--fresh] [--seed]
 */

define('ROOT_PATH', dirname(__DIR__));
require_once ROOT_PATH . '/app/Helpers/helpers.php';
require_once ROOT_PATH . '/app/Services/Database.php';

echo "========================================================\n";
echo "   KCET Database Migration & Seeder\n";
echo "========================================================\n";

$options = getopt('', ['fresh', 'seed', 'help']);

if (isset($options['help'])) {
    echo "Usage: php database/migrate.php [options]\n";
    echo "  --fresh    Drop existing tables and recreate schema\n";
    echo "  --seed     Run seed queries to populate initial data\n";
    exit(0);
}

try {
    $db = \App\Services\Database::getInstance();
    $pdo = $db->getPdo();
    $driver = $db->getDriver();
    echo "Connected using driver: [{$driver}]\n";

    if ($driver === 'sqlite') {
        runSqliteMigration($pdo, isset($options['fresh']) || true, isset($options['seed']) || true);
    } else {
        runMysqlMigration($pdo, isset($options['fresh']) || true, isset($options['seed']) || true);
    }

    echo "\n>>> Migration & Seeding completed successfully! <<<\n";
} catch (\Throwable $e) {
    echo "\n[ERROR] Migration failed: " . $e->getMessage() . "\n";
    echo $e->getTraceAsString() . "\n";
    exit(1);
}

function runMysqlMigration(\PDO $pdo, bool $fresh, bool $seed): void
{
    $schemaFile = ROOT_PATH . '/database/schema.sql';
    $seedFile = ROOT_PATH . '/database/seed.sql';

    if (!file_exists($schemaFile)) {
        throw new \RuntimeException("Schema file not found: {$schemaFile}");
    }

    echo "Running MySQL schema from schema.sql...\n";
    $sql = file_get_contents($schemaFile);
    $pdo->exec($sql);
    echo "Schema tables created.\n";

    if ($seed && file_exists($seedFile)) {
        echo "Running MySQL seed data from seed.sql...\n";
        $seedSql = file_get_contents($seedFile);
        $pdo->exec($seedSql);
        echo "Seed data inserted.\n";
    }
}

function runSqliteMigration(\PDO $pdo, bool $fresh, bool $seed): void
{
    echo "Preparing SQLite database...\n";
    $pdo->exec("PRAGMA foreign_keys = OFF;");

    $tables = [
        'admin_audit_logs', 'application_status_history', 'applications',
        'enquiries', 'downloads', 'gallery_items', 'faqs', 'facilities',
        'events', 'notices', 'faculty', 'programmes', 'departments',
        'site_settings', 'users'
    ];

    if ($fresh) {
        foreach ($tables as $t) {
            $pdo->exec("DROP TABLE IF EXISTS {$t};");
        }
    }

    // 1. Users
    $pdo->exec("CREATE TABLE IF NOT EXISTS users (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        name TEXT NOT NULL,
        email TEXT NOT NULL UNIQUE,
        password_hash TEXT NOT NULL,
        role TEXT NOT NULL DEFAULT 'editor',
        status TEXT NOT NULL DEFAULT 'active',
        last_login_at DATETIME NULL,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
    );");

    // 2. Site settings
    $pdo->exec("CREATE TABLE IF NOT EXISTS site_settings (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        setting_key TEXT NOT NULL UNIQUE,
        setting_value TEXT NULL,
        setting_type TEXT NOT NULL DEFAULT 'text',
        setting_label TEXT NOT NULL,
        group_name TEXT NOT NULL DEFAULT 'general',
        updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
    );");

    // 3. Departments
    $pdo->exec("CREATE TABLE IF NOT EXISTS departments (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        name TEXT NOT NULL,
        slug TEXT NOT NULL UNIQUE,
        code TEXT NOT NULL,
        hod_name TEXT NULL,
        hod_designation TEXT NULL,
        hod_photo TEXT NULL,
        hod_message TEXT NULL,
        vision TEXT NULL,
        mission TEXT NULL,
        overview TEXT NULL,
        labs_info TEXT NULL,
        display_order INTEGER NOT NULL DEFAULT 0,
        is_active INTEGER NOT NULL DEFAULT 1,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
    );");

    // 4. Programmes
    $pdo->exec("CREATE TABLE IF NOT EXISTS programmes (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        department_id INTEGER NOT NULL,
        name TEXT NOT NULL,
        slug TEXT NOT NULL UNIQUE,
        degree_type TEXT NOT NULL DEFAULT 'B.Tech',
        duration TEXT NOT NULL DEFAULT '4 Years (8 Semesters)',
        intake TEXT NULL,
        eligibility TEXT NULL,
        fee_info TEXT NULL,
        syllabus_file TEXT NULL,
        summary TEXT NULL,
        description TEXT NULL,
        career_prospects TEXT NULL,
        is_featured INTEGER NOT NULL DEFAULT 0,
        is_admissions_open INTEGER NOT NULL DEFAULT 1,
        is_active INTEGER NOT NULL DEFAULT 1,
        display_order INTEGER NOT NULL DEFAULT 0,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        updated_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (department_id) REFERENCES departments(id)
    );");

    // 5. Faculty
    $pdo->exec("CREATE TABLE IF NOT EXISTS faculty (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        department_id INTEGER NOT NULL,
        name TEXT NOT NULL,
        slug TEXT NOT NULL UNIQUE,
        designation TEXT NOT NULL,
        qualification TEXT NOT NULL,
        specialization TEXT NULL,
        email TEXT NULL,
        phone TEXT NULL,
        bio TEXT NULL,
        photo TEXT NULL,
        cv_file TEXT NULL,
        display_order INTEGER NOT NULL DEFAULT 0,
        is_active INTEGER NOT NULL DEFAULT 1,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        updated_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (department_id) REFERENCES departments(id)
    );");

    // 6. Facilities
    $pdo->exec("CREATE TABLE IF NOT EXISTS facilities (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        title TEXT NOT NULL,
        slug TEXT NOT NULL UNIQUE,
        badge TEXT NULL,
        summary TEXT NULL,
        description TEXT NULL,
        image TEXT NULL,
        display_order INTEGER NOT NULL DEFAULT 0,
        is_active INTEGER NOT NULL DEFAULT 1,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
    );");

    // 7. Notices
    $pdo->exec("CREATE TABLE IF NOT EXISTS notices (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        title TEXT NOT NULL,
        slug TEXT NOT NULL UNIQUE,
        category TEXT NOT NULL DEFAULT 'general',
        summary TEXT NULL,
        content TEXT NULL,
        attachment_file TEXT NULL,
        is_featured INTEGER NOT NULL DEFAULT 0,
        publish_date DATE NOT NULL,
        expiry_date DATE NULL,
        status TEXT NOT NULL DEFAULT 'published',
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
    );");

    // 8. Events
    $pdo->exec("CREATE TABLE IF NOT EXISTS events (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        title TEXT NOT NULL,
        slug TEXT NOT NULL UNIQUE,
        category TEXT NOT NULL DEFAULT 'Academic',
        start_date DATE NOT NULL,
        end_date DATE NULL,
        location TEXT NULL,
        summary TEXT NULL,
        content TEXT NULL,
        featured_image TEXT NULL,
        status TEXT NOT NULL DEFAULT 'published',
        is_featured INTEGER NOT NULL DEFAULT 0,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
    );");

    // 9. FAQs
    $pdo->exec("CREATE TABLE IF NOT EXISTS faqs (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        category TEXT NOT NULL DEFAULT 'general',
        question TEXT NOT NULL,
        answer TEXT NOT NULL,
        display_order INTEGER NOT NULL DEFAULT 0,
        is_active INTEGER NOT NULL DEFAULT 1,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
    );");

    // 10. Gallery Items
    $pdo->exec("CREATE TABLE IF NOT EXISTS gallery_items (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        title TEXT NOT NULL,
        caption TEXT NULL,
        category TEXT NOT NULL DEFAULT 'campus',
        image_url TEXT NOT NULL,
        display_order INTEGER NOT NULL DEFAULT 0,
        is_active INTEGER NOT NULL DEFAULT 1,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
    );");

    // 11. Downloads
    $pdo->exec("CREATE TABLE IF NOT EXISTS downloads (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        title TEXT NOT NULL,
        category TEXT NOT NULL DEFAULT 'syllabus',
        file_path TEXT NOT NULL,
        file_type TEXT NOT NULL DEFAULT 'PDF',
        file_size TEXT NULL,
        publication_date DATE NOT NULL,
        is_active INTEGER NOT NULL DEFAULT 1,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
    );");

    // 12. Enquiries
    $pdo->exec("CREATE TABLE IF NOT EXISTS enquiries (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        full_name TEXT NOT NULL,
        email TEXT NOT NULL,
        phone TEXT NOT NULL,
        programme_id INTEGER NULL,
        subject TEXT NULL,
        message TEXT NOT NULL,
        source_page TEXT NOT NULL DEFAULT 'website',
        status TEXT NOT NULL DEFAULT 'new',
        internal_notes TEXT NULL,
        ip_address TEXT NULL,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        updated_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (programme_id) REFERENCES programmes(id)
    );");

    // 13. Applications
    $pdo->exec("CREATE TABLE IF NOT EXISTS applications (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        application_number TEXT NOT NULL UNIQUE,
        first_name TEXT NOT NULL,
        last_name TEXT NOT NULL,
        email TEXT NOT NULL,
        phone TEXT NOT NULL,
        whatsapp_number TEXT NULL,
        dob DATE NULL,
        gender TEXT NULL,
        programme_id INTEGER NOT NULL,
        parent_name TEXT NOT NULL,
        address TEXT NOT NULL,
        city TEXT NOT NULL,
        state TEXT NOT NULL DEFAULT 'Jammu and Kashmir',
        pincode TEXT NOT NULL,
        prior_education TEXT NOT NULL,
        marks_percentage TEXT NOT NULL,
        current_status TEXT NULL,
        status TEXT NOT NULL DEFAULT 'new',
        notes TEXT NULL,
        ip_address TEXT NULL,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        updated_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (programme_id) REFERENCES programmes(id)
    );");

    // 14. Application status history
    $pdo->exec("CREATE TABLE IF NOT EXISTS application_status_history (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        application_id INTEGER NOT NULL,
        status TEXT NOT NULL,
        remarks TEXT NULL,
        changed_by_user_id INTEGER NULL,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (application_id) REFERENCES applications(id),
        FOREIGN KEY (changed_by_user_id) REFERENCES users(id)
    );");

    // 15. Admin audit logs
    $pdo->exec("CREATE TABLE IF NOT EXISTS admin_audit_logs (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        user_id INTEGER NULL,
        user_email TEXT NULL,
        action TEXT NOT NULL,
        object_type TEXT NOT NULL,
        object_id TEXT NULL,
        details TEXT NULL,
        ip_address TEXT NULL,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (user_id) REFERENCES users(id)
    );");

    $pdo->exec("PRAGMA foreign_keys = ON;");
    echo "SQLite schema created.\n";

    if ($seed) {
        echo "Importing seed data from seed.sql...\n";
        $seedSql = file_get_contents(ROOT_PATH . '/database/seed.sql');
        
        // Remove MySQL specific comments and syntax
        $lines = explode("\n", $seedSql);
        $cleanSql = '';
        foreach ($lines as $line) {
            $trimmed = trim($line);
            if (str_starts_with($trimmed, '--') || empty($trimmed)) {
                continue;
            }
            $cleanSql .= $line . "\n";
        }
        
        // Execute statements
        $statements = explode(";\n", $cleanSql);
        foreach ($statements as $stmt) {
            $stmt = trim($stmt);
            if (!empty($stmt)) {
                $pdo->exec($stmt);
            }
        }
        echo "SQLite seed data imported.\n";
    }
}

