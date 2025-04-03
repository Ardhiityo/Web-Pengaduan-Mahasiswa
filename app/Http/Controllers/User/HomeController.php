<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Services\Interfaces\ReportRepositoryInterface;
use App\Services\Interfaces\ReportCategoryRepositoryInterface;

class HomeController extends Controller
{
    public function __construct(
        private ReportCategoryRepositoryInterface $reportCategoryRepository,
        private ReportRepositoryInterface $reportRepository
    ) {}

    public function index()
    {
        $reportCategories = $this->reportCategoryRepository->getAllReportCategories();
        $latestReports = $this->reportRepository->latestReports();

        return view('pages.app.home', compact('latestReports', 'reportCategories'));
    }
}
