<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Models\Download;
use App\Services\SyllabusData;
use App\Services\View;

class DownloadController
{
    public function syllabus(): void
    {
        $_GET['cat'] = 'syllabus';
        if (!isset($_GET['branch'])) {
            $_GET['branch'] = 'ai';
        }
        $this->index();
    }

    public function syllabusBranch(string $branch): void
    {
        $map = [
            'ai' => 'ai',
            'artificial-intelligence' => 'ai',
            'artificial-intelligence-engineering' => 'ai',
            'b-tech-artificial-intelligence-engineering' => 'ai',
            'ce' => 'ce',
            'cse' => 'ce',
            'computer-engineering' => 'ce',
            'b-tech-computer-engineering' => 'ce',
            'civil' => 'civil',
            'civil-engineering' => 'civil',
            'b-tech-civil-engineering' => 'civil',
            'it' => 'it',
            'information-technology' => 'it',
            'information-technology-engineering' => 'it',
            'b-tech-information-technology-engineering' => 'it',
            'ece' => 'ece',
            'electronics-and-communication' => 'ece',
            'electronics-and-communication-engineering' => 'ece',
            'b-tech-electronics-and-communication-engineering' => 'ece',
            'common' => 'common',
            'first-year' => 'common',
            '1st-year' => 'common',
            'foundation' => 'common',
        ];

        $cleanBranch = strtolower(trim($branch));
        $_GET['cat'] = 'syllabus';
        $_GET['branch'] = $map[$cleanBranch] ?? 'ai';
        $this->index();
    }

    public function index(): void
    {
        $downloadModel = new Download();
        
        $category = isset($_GET['cat']) ? trim($_GET['cat']) : 'all';
        $branch = isset($_GET['branch']) ? trim($_GET['branch']) : 'all';
        $semester = isset($_GET['sem']) ? (int)$_GET['sem'] : 0;
        $search = isset($_GET['q']) ? trim($_GET['q']) : '';

        // Fetch downloads
        $downloads = $downloadModel->getActive(
            $category !== 'all' ? $category : null,
            $branch !== 'all' ? $branch : null,
            $semester > 0 ? $semester : null
        );

        // If search query is present, filter downloads
        if ($search !== '') {
            $searchLower = strtolower($search);
            $downloads = array_filter($downloads, function ($doc) use ($searchLower) {
                return str_contains(strtolower($doc['title']), $searchLower)
                    || str_contains(strtolower($doc['category']), $searchLower)
                    || str_contains(strtolower($doc['branch'] ?? ''), $searchLower);
            });
        }

        // Distinct category buckets for dedicated sections
        $prospectusDownloads = $downloadModel->getActive('prospectus');
        $formDownloads = $downloadModel->getActive('forms');
        $circularDownloads = $downloadModel->getActive('circular');

        $branches = SyllabusData::getBranches();

        $isSyllabus = ($category === 'syllabus' || str_starts_with($_SERVER['REQUEST_URI'] ?? '', '/syllabus'));
        $title = $isSyllabus 
            ? 'B.Tech Syllabus & Academic Curricula | KCET Srinagar'
            : 'Downloads & Academic Syllabus | KCET Srinagar';
        $meta = $isSyllabus
            ? 'Download official B.Tech curricula for all 8 semesters across Artificial Intelligence, Computer Engineering, Civil, IT, and ECE at KCET Srinagar.'
            : 'Download official B.Tech curricula, course syllabi divided by branches and semesters, information prospectus, and admission forms for KCET Srinagar.';

        View::render('pages.downloads', [
            'pageTitle' => $title,
            'metaDescription' => $meta,
            'isSyllabusRoute' => $isSyllabus,
            'downloads' => $downloads,
            'selectedCategory' => $category,
            'selectedBranch' => $branch,
            'selectedSemester' => $semester,
            'searchQuery' => $search,
            'branches' => $branches,
            'prospectusDownloads' => $prospectusDownloads,
            'formDownloads' => $formDownloads,
            'circularDownloads' => $circularDownloads,
        ]);
    }
}
