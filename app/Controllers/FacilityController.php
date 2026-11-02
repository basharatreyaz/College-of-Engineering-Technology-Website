<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Models\Facility;
use App\Services\View;

class FacilityController
{
    public function index(): void
    {
        $facilityModel = new Facility();
        $facilities = $facilityModel->getActive();

        View::render('pages.facilities', [
            'pageTitle' => 'Campus Facilities & Infrastructure | KCET Srinagar',
            'metaDescription' => 'Explore KCET\'s 100+ kanal green campus facilities: Central Library, 100 Mbps Wi-Fi, Computer Centres, Cafeteria, Transport Fleet, and Safety Systems.',
            'facilities' => $facilities
        ]);
    }

    public function show(string $slug): void
    {
        $facilityModel = new Facility();
        $facility = $facilityModel->findBySlug($slug);

        if (!$facility || (int)$facility['is_active'] !== 1) {
            $pageController = new PageController();
            $pageController->notFound();
            return;
        }

        $allFacilities = $facilityModel->getActive();
        $otherFacilities = array_filter($allFacilities, fn($f) => (int)$f['id'] !== (int)$facility['id']);

        View::render('pages.facility-detail', [
            'pageTitle' => $facility['title'] . ' | Facilities | KCET Srinagar',
            'metaDescription' => truncate($facility['summary'] ?? '', 160),
            'facility' => $facility,
            'otherFacilities' => array_slice($otherFacilities, 0, 4)
        ]);
    }
}

