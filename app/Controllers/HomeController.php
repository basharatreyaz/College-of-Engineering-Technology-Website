<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Models\Programme;
use App\Models\Notice;
use App\Models\Event;
use App\Models\Facility;
use App\Models\Faq;
use App\Models\GalleryItem;
use App\Services\View;

class HomeController
{
    public function index(): void
    {
        $programmeModel = new Programme();
        $noticeModel = new Notice();
        $eventModel = new Event();
        $facilityModel = new Facility();
        $faqModel = new Faq();
        $galleryModel = new GalleryItem();

        $featuredProgrammes = $programmeModel->getFeatured();
        if (empty($featuredProgrammes)) {
            $featuredProgrammes = $programmeModel->getActive();
        }

        $latestNotices = $noticeModel->getLatest(4);
        $featuredEvents = $eventModel->getFeatured(3);
        if (empty($featuredEvents)) {
            $featuredEvents = $eventModel->getPublished(3);
        }

        $facilities = array_slice($facilityModel->getActive(), 0, 6);
        $faqs = array_slice($faqModel->getActive('admissions'), 0, 5);
        if (empty($faqs)) {
            $faqs = array_slice($faqModel->getActive(), 0, 5);
        }

        $galleryItems = array_slice($galleryModel->getActive(), 0, 6);

        View::render('pages.home', [
            'pageTitle' => 'Kashmir College of Engineering & Technology | KCET Srinagar',
            'metaDescription' => 'Kashmir College of Engineering & Technology (KCET) offers premier B.Tech programmes in AI, Computer, Civil, IT, and ECE at our sprawling 100+ kanal green campus in Ranbirgarh, Srinagar.',
            'featuredProgrammes' => $featuredProgrammes,
            'latestNotices' => $latestNotices,
            'featuredEvents' => $featuredEvents,
            'facilities' => $facilities,
            'faqs' => $faqs,
            'galleryItems' => $galleryItems
        ]);
    }
}

