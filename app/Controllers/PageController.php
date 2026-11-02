<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Models\Department;
use App\Models\Faq;
use App\Models\GalleryItem;
use App\Models\Programme;
use App\Services\View;

class PageController
{
    public function about(): void
    {
        $deptModel = new Department();
        $departments = $deptModel->getActive();

        View::render('pages.about', [
            'pageTitle' => 'About Us | Kashmir College of Engineering & Technology',
            'metaDescription' => 'Learn about KCET\'s genesis, vision, mission, leadership messages, and our sprawling 100+ kanal green campus in Ranbirgarh, Srinagar.',
            'departments' => $departments
        ]);
    }

    public function campusLife(): void
    {
        $galleryModel = new GalleryItem();
        $galleryItems = $galleryModel->getActive();

        View::render('pages.campus-life', [
            'pageTitle' => 'Campus Life | Kashmir College of Engineering & Technology',
            'metaDescription' => 'Discover student community, sports, technical clubs, annual boot camps, cultural festivals, and life on the KCET green campus.',
            'galleryItems' => $galleryItems
        ]);
    }

    public function admissions(): void
    {
        $faqModel = new Faq();
        $faqs = $faqModel->getActive('admissions');

        View::render('pages.admissions', [
            'pageTitle' => 'Admissions 2026-27 | KCET Srinagar',
            'metaDescription' => 'Admission eligibility, procedures, documents checklist, and scholarships for 4-Year B.Tech and Lateral Entry at KCET.',
            'faqs' => $faqs
        ]);
    }

    public function careers(): void
    {
        View::render('pages.careers', [
            'pageTitle' => 'Careers & Vacancies | KCET Srinagar',
            'metaDescription' => 'Join the academic and technical team at Kashmir College of Engineering & Technology. View current faculty and staff openings.',
        ]);
    }

    public function contact(): void
    {
        $programmeModel = new Programme();
        $programmes = $programmeModel->getActive();

        View::render('pages.contact', [
            'pageTitle' => 'Contact Us | KCET Srinagar',
            'metaDescription' => 'Reach Kashmir College of Engineering & Technology in Ranbirgarh, Srinagar. Contact info, office hours, location map, and enquiry form.',
            'programmes' => $programmes,
        ]);
    }

    public function privacy(): void
    {
        View::render('pages.privacy', [
            'pageTitle' => 'Privacy Policy | KCET Srinagar',
            'metaDescription' => 'Information on how Kashmir College of Engineering & Technology collects, uses, and protects student and applicant personal data.',
        ]);
    }

    public function terms(): void
    {
        View::render('pages.terms', [
            'pageTitle' => 'Terms of Use | KCET Srinagar',
            'metaDescription' => 'Website usage terms, disclaimers, and institutional regulations for Kashmir College of Engineering & Technology.',
        ]);
    }

    public function notFound(): void
    {
        View::render('pages.404', [
            'pageTitle' => '404 - Page Not Found | KCET Srinagar',
            'metaDescription' => 'The page you requested could not be found.',
        ]);
    }
}

