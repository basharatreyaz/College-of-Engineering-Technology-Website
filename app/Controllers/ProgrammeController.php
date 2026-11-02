<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Models\Programme;
use App\Models\Department;
use App\Models\Faq;
use App\Services\View;

class ProgrammeController
{
    public function index(): void
    {
        $progModel = new Programme();
        $deptModel = new Department();

        $departments = $deptModel->getActive();
        $deptFilter = isset($_GET['dept']) ? (int)$_GET['dept'] : null;

        if ($deptFilter) {
            $programmes = $progModel->getByDepartment($deptFilter);
        } else {
            $programmes = $progModel->getActive();
        }

        View::render('pages.programmes.index', [
            'pageTitle' => 'Engineering Programmes (B.Tech) | KCET Srinagar',
            'metaDescription' => 'Explore 4-year B.Tech programmes in Artificial Intelligence, Computer Engineering, Civil, Information Technology, and ECE at KCET.',
            'programmes' => $programmes,
            'departments' => $departments,
            'selectedDept' => $deptFilter
        ]);
    }

    public function show(string $slug): void
    {
        $progModel = new Programme();
        $programme = $progModel->findBySlug($slug);

        if (!$programme || (int)$programme['is_active'] !== 1) {
            $pageController = new PageController();
            $pageController->notFound();
            return;
        }

        $allProgrammes = $progModel->getActive();
        $relatedProgrammes = array_filter($allProgrammes, fn($p) => (int)$p['id'] !== (int)$programme['id']);

        $faqModel = new Faq();
        $faqs = $faqModel->getActive('admissions');

        View::render('pages.programmes.show', [
            'pageTitle' => $programme['name'] . ' | KCET Srinagar',
            'metaDescription' => truncate($programme['summary'] ?? '', 160),
            'programme' => $programme,
            'relatedProgrammes' => array_slice($relatedProgrammes, 0, 3),
            'faqs' => array_slice($faqs, 0, 4)
        ]);
    }
}

