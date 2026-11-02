<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Models\Faculty;
use App\Models\Department;
use App\Services\View;

class FacultyController
{
    public function index(): void
    {
        $facultyModel = new Faculty();
        $deptModel = new Department();

        $departments = $deptModel->getActive();
        $deptFilter = isset($_GET['dept']) ? (int)$_GET['dept'] : null;
        $searchQuery = isset($_GET['q']) ? trim($_GET['q']) : null;

        if ($deptFilter) {
            $faculty = $facultyModel->getByDepartment($deptFilter);
        } else {
            $faculty = $facultyModel->getActive();
        }

        if ($searchQuery) {
            $q = mb_strtolower($searchQuery);
            $faculty = array_filter($faculty, function($f) use ($q) {
                return str_contains(mb_strtolower($f['name']), $q) ||
                       str_contains(mb_strtolower($f['designation']), $q) ||
                       str_contains(mb_strtolower($f['qualification']), $q) ||
                       str_contains(mb_strtolower($f['specialization'] ?? ''), $q);
            });
        }

        View::render('pages.faculty', [
            'pageTitle' => 'Faculty & Academic Staff | KCET Srinagar',
            'metaDescription' => 'Meet the distinguished professors, researchers, and technical educators driving engineering education at KCET Srinagar.',
            'faculty' => $faculty,
            'departments' => $departments,
            'selectedDept' => $deptFilter,
            'searchQuery' => $searchQuery
        ]);
    }
}

