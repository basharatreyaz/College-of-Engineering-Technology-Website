-- KCET Database Schema
-- Compatible with MySQL 8.0+ / MariaDB 10.5+

SET FOREIGN_KEY_CHECKS = 0;

DROP TABLE IF EXISTS admin_audit_logs;
DROP TABLE IF EXISTS application_status_history;
DROP TABLE IF EXISTS applications;
DROP TABLE IF EXISTS enquiries;
DROP TABLE IF EXISTS downloads;
DROP TABLE IF EXISTS gallery_items;
DROP TABLE IF EXISTS faqs;
DROP TABLE IF EXISTS facilities;
DROP TABLE IF EXISTS events;
DROP TABLE IF EXISTS notices;
DROP TABLE IF EXISTS faculty;
DROP TABLE IF EXISTS programmes;
DROP TABLE IF EXISTS departments;
DROP TABLE IF EXISTS site_settings;
DROP TABLE IF EXISTS users;

SET FOREIGN_KEY_CHECKS = 1;

-- 1. Users Table
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(150) NOT NULL,
    email VARCHAR(191) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    role VARCHAR(50) NOT NULL DEFAULT 'editor', -- superadmin, editor, admissions
    status VARCHAR(20) NOT NULL DEFAULT 'active', -- active, inactive
    last_login_at DATETIME NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 2. Site Settings
CREATE TABLE site_settings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    setting_key VARCHAR(100) NOT NULL UNIQUE,
    setting_value TEXT NULL,
    setting_type VARCHAR(30) NOT NULL DEFAULT 'text', -- text, textarea, email, number, url
    setting_label VARCHAR(150) NOT NULL,
    group_name VARCHAR(50) NOT NULL DEFAULT 'general',
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 3. Departments Table
CREATE TABLE departments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(200) NOT NULL,
    slug VARCHAR(191) NOT NULL UNIQUE,
    code VARCHAR(30) NOT NULL,
    hod_name VARCHAR(150) NULL,
    hod_designation VARCHAR(150) NULL,
    hod_photo VARCHAR(255) NULL,
    hod_message TEXT NULL,
    vision TEXT NULL,
    mission TEXT NULL,
    overview TEXT NULL,
    labs_info TEXT NULL,
    display_order INT NOT NULL DEFAULT 0,
    is_active TINYINT(1) NOT NULL DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 4. Programmes Table
CREATE TABLE programmes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    department_id INT NOT NULL,
    name VARCHAR(200) NOT NULL,
    slug VARCHAR(191) NOT NULL UNIQUE,
    degree_type VARCHAR(50) NOT NULL DEFAULT 'B.Tech',
    duration VARCHAR(50) NOT NULL DEFAULT '4 Years (8 Semesters)',
    intake VARCHAR(50) NULL,
    eligibility TEXT NULL,
    fee_info TEXT NULL,
    syllabus_file VARCHAR(255) NULL,
    summary TEXT NULL,
    description MEDIUMTEXT NULL,
    career_prospects TEXT NULL,
    is_featured TINYINT(1) NOT NULL DEFAULT 0,
    is_admissions_open TINYINT(1) NOT NULL DEFAULT 1,
    is_active TINYINT(1) NOT NULL DEFAULT 1,
    display_order INT NOT NULL DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_programmes_department FOREIGN KEY (department_id) REFERENCES departments (id) ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 5. Faculty & Staff Table
CREATE TABLE faculty (
    id INT AUTO_INCREMENT PRIMARY KEY,
    department_id INT NOT NULL,
    name VARCHAR(150) NOT NULL,
    slug VARCHAR(191) NOT NULL UNIQUE,
    designation VARCHAR(150) NOT NULL,
    qualification VARCHAR(200) NOT NULL,
    specialization VARCHAR(255) NULL,
    email VARCHAR(191) NULL,
    phone VARCHAR(50) NULL,
    bio TEXT NULL,
    photo VARCHAR(255) NULL,
    cv_file VARCHAR(255) NULL,
    display_order INT NOT NULL DEFAULT 0,
    is_active TINYINT(1) NOT NULL DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_faculty_department FOREIGN KEY (department_id) REFERENCES departments (id) ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 6. Facilities Table
CREATE TABLE facilities (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(200) NOT NULL,
    slug VARCHAR(191) NOT NULL UNIQUE,
    badge VARCHAR(100) NULL,
    summary TEXT NULL,
    description MEDIUMTEXT NULL,
    image VARCHAR(255) NULL,
    display_order INT NOT NULL DEFAULT 0,
    is_active TINYINT(1) NOT NULL DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 7. Notices & Announcements
CREATE TABLE notices (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    slug VARCHAR(191) NOT NULL UNIQUE,
    category VARCHAR(50) NOT NULL DEFAULT 'general', -- admissions, academics, examinations, recruitment, general
    summary TEXT NULL,
    content MEDIUMTEXT NULL,
    attachment_file VARCHAR(255) NULL,
    is_featured TINYINT(1) NOT NULL DEFAULT 0,
    publish_date DATE NOT NULL,
    expiry_date DATE NULL,
    status VARCHAR(20) NOT NULL DEFAULT 'published', -- published, draft, archived
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 8. Events Table
CREATE TABLE events (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    slug VARCHAR(191) NOT NULL UNIQUE,
    category VARCHAR(100) NOT NULL DEFAULT 'Academic',
    start_date DATE NOT NULL,
    end_date DATE NULL,
    location VARCHAR(200) NULL,
    summary TEXT NULL,
    content MEDIUMTEXT NULL,
    featured_image VARCHAR(255) NULL,
    status VARCHAR(20) NOT NULL DEFAULT 'published',
    is_featured TINYINT(1) NOT NULL DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 9. FAQs Table
CREATE TABLE faqs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    category VARCHAR(50) NOT NULL DEFAULT 'general', -- admissions, academics, facilities, general
    question VARCHAR(255) NOT NULL,
    answer TEXT NOT NULL,
    display_order INT NOT NULL DEFAULT 0,
    is_active TINYINT(1) NOT NULL DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 10. Gallery Items
CREATE TABLE gallery_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(200) NOT NULL,
    caption VARCHAR(255) NULL,
    category VARCHAR(50) NOT NULL DEFAULT 'campus', -- campus, labs, events, sports
    image_url VARCHAR(255) NOT NULL,
    display_order INT NOT NULL DEFAULT 0,
    is_active TINYINT(1) NOT NULL DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 11. Downloads Table
CREATE TABLE downloads (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    category VARCHAR(50) NOT NULL DEFAULT 'syllabus', -- syllabus, prospectus, forms, circular
    file_path VARCHAR(255) NOT NULL,
    file_type VARCHAR(20) NOT NULL DEFAULT 'PDF',
    file_size VARCHAR(50) NULL,
    publication_date DATE NOT NULL,
    is_active TINYINT(1) NOT NULL DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 12. Enquiries Table
CREATE TABLE enquiries (
    id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(150) NOT NULL,
    email VARCHAR(191) NOT NULL,
    phone VARCHAR(50) NOT NULL,
    programme_id INT NULL,
    subject VARCHAR(200) NULL,
    message TEXT NOT NULL,
    source_page VARCHAR(100) NOT NULL DEFAULT 'website',
    status VARCHAR(30) NOT NULL DEFAULT 'new', -- new, contacted, under_review, closed
    internal_notes TEXT NULL,
    ip_address VARCHAR(45) NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_enquiries_programme FOREIGN KEY (programme_id) REFERENCES programmes (id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 13. Applications Table
CREATE TABLE applications (
    id INT AUTO_INCREMENT PRIMARY KEY,
    application_number VARCHAR(50) NOT NULL UNIQUE,
    first_name VARCHAR(100) NOT NULL,
    last_name VARCHAR(100) NOT NULL,
    email VARCHAR(191) NOT NULL,
    phone VARCHAR(50) NOT NULL,
    whatsapp_number VARCHAR(50) NULL,
    dob DATE NULL,
    gender VARCHAR(20) NULL,
    programme_id INT NOT NULL,
    parent_name VARCHAR(150) NOT NULL,
    address TEXT NOT NULL,
    city VARCHAR(100) NOT NULL,
    state VARCHAR(100) NOT NULL DEFAULT 'Jammu and Kashmir',
    pincode VARCHAR(20) NOT NULL,
    prior_education VARCHAR(200) NOT NULL,
    marks_percentage VARCHAR(20) NOT NULL,
    current_status VARCHAR(100) NULL,
    status VARCHAR(30) NOT NULL DEFAULT 'new', -- new, under_review, accepted, rejected, closed
    notes TEXT NULL,
    ip_address VARCHAR(45) NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_applications_programme FOREIGN KEY (programme_id) REFERENCES programmes (id) ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 14. Application Status History
CREATE TABLE application_status_history (
    id INT AUTO_INCREMENT PRIMARY KEY,
    application_id INT NOT NULL,
    status VARCHAR(30) NOT NULL,
    remarks TEXT NULL,
    changed_by_user_id INT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_history_application FOREIGN KEY (application_id) REFERENCES applications (id) ON DELETE CASCADE,
    CONSTRAINT fk_history_user FOREIGN KEY (changed_by_user_id) REFERENCES users (id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 15. Admin Audit Logs
CREATE TABLE admin_audit_logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NULL,
    user_email VARCHAR(191) NULL,
    action VARCHAR(100) NOT NULL,
    object_type VARCHAR(100) NOT NULL,
    object_id VARCHAR(100) NULL,
    details TEXT NULL,
    ip_address VARCHAR(45) NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_audit_user FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Helpful Indexes
CREATE INDEX idx_programmes_dept ON programmes (department_id);
CREATE INDEX idx_faculty_dept ON faculty (department_id);
CREATE INDEX idx_notices_status_date ON notices (status, publish_date);
CREATE INDEX idx_events_status_date ON events (status, start_date);
CREATE INDEX idx_enquiries_status ON enquiries (status);
CREATE INDEX idx_applications_status ON applications (status);

