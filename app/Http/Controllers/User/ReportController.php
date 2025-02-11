<?php

namespace App\Http\Controllers\User;

use App\Models\Report;
use App\Models\Resident;
use App\Models\ReportStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Report\StoreReportRequest;
use App\Services\Interfaces\ReportRepositoryInterface;
use App\Services\Interfaces\ReportCategoryRepositoryInterface;
use App\Services\Interfaces\ReportStatusRepositoryInterface;

class ReportController extends Controller
{
    public function __construct(
        private ReportRepositoryInterface $reportRepository,
        private ReportCategoryRepositoryInterface $reportCategoryRepository,
        private ReportStatusRepositoryInterface $reportStatusRepository
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

    public function show($code)
    {
        if ($report = $this->reportRepository->getReportByCode($code)) {
            return view('pages.app.report.show', compact('report'));
        }
        return redirect()->route('home');
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
        $this->reportRepository->createReport($data);
        return redirect()->route('report.success');
    }

    public function success()
    {
        return view('pages.app.report.success');
    }

    public function myReport(Request $request)
    {
        $reports = $this->reportStatusRepository->getReportStatusByResident($request->query('status'));
        return view('pages.app.report.my-reports', compact('reports'));
    }
}
