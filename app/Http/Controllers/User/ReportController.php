<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\Report\StoreReportRequest;
use App\Services\Interfaces\ReportRepositoryInterface;
use App\Services\Interfaces\ReportStatusRepositoryInterface;
use App\Services\Interfaces\ReportCategoryRepositoryInterface;
use App\Services\Interfaces\DecryptParameterRepositoryInterface;

class ReportController extends Controller
{
    public function __construct(
        private ReportRepositoryInterface $reportRepository,
        private ReportCategoryRepositoryInterface $reportCategoryRepository,
        private ReportStatusRepositoryInterface $reportStatusRepository,
        private DecryptParameterRepositoryInterface $decryptParameterRepository
    ) {}

    public function index(Request $request)
    {
        if ($category = $request->query('category')) {
            if ($reports = $this->reportRepository->getReportsByCategory($category)) {
                $totalReports = $reports->count();
            } else {
                return redirect()->route('home');
            }
        } else {
            $reports = $this->reportRepository->getAllReports();
            $totalReports = $reports->count();
        }
        return view('pages.app.report.index', compact('reports', 'totalReports'));
    }

    public function show($reportId)
    {
        $decrypt = $this->decryptParameterRepository->getData(id: $reportId, message: 'Ups, FAQ tidak ditemukan!', route: 'admin.report-category.index');

        if ($decrypt instanceof RedirectResponse) return $decrypt;

        if ($report = $this->reportRepository->getReportById($decrypt)) {
            return view('pages.app.report.show', compact('report'));
        }
        return view('pages.app.404');
    }

    public function take()
    {
        return view('pages.app.report.take');
    }

    public function preview()
    {
        return view('pages.app.report.preview');
    }

    public function create()
    {
        $reportCategories = $this->reportCategoryRepository->getAllReportCategories();
        return view('pages.app.report.create', compact('reportCategories'));
    }

    public function store(StoreReportRequest $request)
    {
        $data = $request->validated();
        $report = $this->reportRepository->createReport($data);
        $this->reportRepository->sendNotificationTelegram($report);
        return redirect()->route('report.success');
    }

    public function success()
    {
        return view('pages.app.report.success');
    }

    public function myReport(Request $request)
    {
        if ($request->query('status')) {
            $reports = $this->reportStatusRepository->getReportStatusByResident($request->query('status'));
            return view('pages.app.report.my-reports', compact('reports'));
        } else {
            return view('pages.app.404');
        }
    }
}
