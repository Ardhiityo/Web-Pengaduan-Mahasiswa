<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ReportStatus\UpdateReportStatusRequest;
use App\Services\Interfaces\ReportRepositoryInterface;
use App\Http\Requests\ReportStatus\StoreReportStatusRequest;
use App\Services\Interfaces\ReportCategoryRepositoryInterface;
use App\Services\Interfaces\ReportStatusRepositoryInterface;

class ReportStatusController extends Controller
{
    public function __construct(
        private ReportRepositoryInterface $reportRepository,
        private ReportStatusRepositoryInterface $reportStatusRepository,
        private ReportCategoryRepositoryInterface $reportCategoryRepository
    ) {}

    public function index()
    {
        $reports = $this->reportRepository->getAllReports();
        return view('pages.admin.report.index', compact('reports'));
    }

    public function create($reportId)
    {
        $report = $this->reportRepository->getReportById($reportId);
        return view('pages.admin.report-status.create', compact('report', 'report'));
    }

    public function store(StoreReportStatusRequest $request)
    {
        $data = $request->validated();
        $reportStatus = $this->reportStatusRepository->createReportStatus($data);
        toast('Status kemajuan laporan sukses ditambahkan', 'success')->timerProgressBar();
        return redirect()->route('admin.report.show', $reportStatus->report->id);
    }

    public function show(string $id)
    {
        $reportStatus = $this->reportStatusRepository->getReportStatusById($id);
        return view('pages.admin.report-status.show', compact('reportStatus'));
    }

    public function edit(string $id)
    {
        $reportStatus = $this->reportStatusRepository->getReportStatusById($id);
        $reportCategories = $this->reportCategoryRepository->getAllReportCategories();
        return view('pages.admin.report-status.edit', compact('reportStatus'));
    }

    public function update(UpdateReportStatusRequest $request, string $id)
    {
        $data = $request->validated();
        $this->reportStatusRepository->updateReportStatus($data, $id);
        toast('Data laporan sukses diupdate', 'success')->timerProgressBar();
        return redirect()->route('admin.report.show', $data['report_id']);
    }

    public function destroy(string $id)
    {
        $reportStatus = $this->reportStatusRepository->getReportStatusById($id);
        $this->reportStatusRepository->deleteReportStatus($id);
        toast('Kemajuan laporan sukses dihapus', 'success')->timerProgressBar();
        return redirect()->route('admin.report.show', $reportStatus->report->id);
    }
}
