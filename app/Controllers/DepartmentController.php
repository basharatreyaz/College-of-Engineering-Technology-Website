<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Models\Department;
use App\Models\Programme;
use App\Models\Faculty;
use App\Services\View;

class DepartmentController
{
    public function index(): void
    {
        $deptModel = new Department();
        $departments = $deptModel->getActive();

        View::render('pages.departments.index', [
            'pageTitle' => 'Academic Departments | KCET Srinagar',
            'metaDescription' => 'Discover our engineering departments: Computer Engineering, Artificial Intelligence, Civil, IT, ECE, and Applied Sciences.',
            'departments' => $departments
        ]);
    }

    public function show(string $slug): void
    {
        $deptModel = new Department();
        $department = $deptModel->findBySlug($slug);

        if (!$department || (int)$department['is_active'] !== 1) {
            $pageController = new PageController();
            $pageController->notFound();
            return;
        }

        $progModel = new Programme();
        $programmes = $progModel->getByDepartment((int)$department['id']);

        $facultyModel = new Faculty();
        $facultyMembers = $facultyModel->getByDepartment((int)$department['id']);

        View::render('pages.departments.show', [
            'pageTitle' => $department['name'] . ' | KCET Srinagar',
            'metaDescription' => truncate($department['overview'] ?? '', 160),
            'department' => $department,
            'programmes' => $programmes,
            'facultyMembers' => $facultyMembers
        ]);
    }
}

