<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Jobs\ProcessNotification;
use App\Services\TelegramService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Report\StoreReportRequest;
use App\Services\Interfaces\ReportRepositoryInterface;
use App\Services\Interfaces\ResidentRepositoryInterface;
use App\Services\Interfaces\ReportStatusRepositoryInterface;
use App\Services\Interfaces\StudyProgramRepositoryInterface;
use App\Services\Interfaces\ReportCategoryRepositoryInterface;
use App\Services\Interfaces\DecryptParameterRepositoryInterface;

class ReportController extends Controller
{
    public function __construct(
        private ReportRepositoryInterface $reportRepository,
        private ReportCategoryRepositoryInterface $reportCategoryRepository,
        private ReportStatusRepositoryInterface $reportStatusRepository,
        private DecryptParameterRepositoryInterface $decryptParameterRepository,
        private TelegramService $telegramService,
        private StudyProgramRepositoryInterface $studyProgramRepository,
        private ResidentRepositoryInterface $residentRepository,
    ) {}

    public function index(Request $request)
    {
        if ($category = $request->query('category')) {
            if ($reportCategory = $this->reportRepository->getReportsByCategory(category: $category)) {
                $reports = $reportCategory;
                $totalReports = $reportCategory->count();
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
        if ($report = $this->reportRepository->getReportById(id: $reportId)) {
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
        $studyPrograms = $this->studyProgramRepository->getAllStudyPrograms();
        $resident = $this->residentRepository->getResidentById(Auth::user()->resident->id);

        return view('pages.app.report.create', compact('reportCategories', 'studyPrograms', 'resident'));
    }

    public function store(StoreReportRequest $request)
    {
        $report = $this->reportRepository->createReport(data: $request->validated());
        ProcessNotification::dispatch($report);

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
