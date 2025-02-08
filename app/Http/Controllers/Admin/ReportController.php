<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Report\StoreReportRequest;
use App\Http\Requests\Report\UpdateReportRequest;
use App\Services\Interfaces\ReportRepositoryInterface;
use App\Services\Interfaces\ResidentRepositoryInterface;
use App\Services\Interfaces\ReportCategoryRepositoryInterface;

class ReportController extends Controller
{
    public function __construct(
        private ReportRepositoryInterface $reportRepository,
        private ResidentRepositoryInterface $residentRepository,
        private ReportCategoryRepositoryInterface $reportCategoryRepository
    ) {}

    public function index()
    {
        $reports = $this->reportRepository->getAllReports();
        return view('pages.admin.report.index', compact('reports'));
    }

    public function create()
    {
        $residents = $this->residentRepository->getAllResidents();
        $reportCategories = $this->reportCategoryRepository->getAllReportCategories();
        return view('pages.admin.report.create', compact('residents', 'reportCategories'));
    }

    public function store(StoreReportRequest $request)
    {
        $data = $request->validated();
        $this->reportRepository->createReport($data);
        toast('Data laporan sukses ditambahkan', 'success')->timerProgressBar();
        return redirect()->route('admin.report.index');
    }

    public function show(string $id)
    {
        $report = $this->reportRepository->getReportById($id);
        return view('pages.admin.report.show', compact('report'));
    }

    public function edit(string $id)
    {
        $report = $this->reportRepository->getReportById($id);
        $residents = $this->residentRepository->getAllResidents();
        $reportCategories = $this->reportCategoryRepository->getAllReportCategories();
        return view('pages.admin.report.edit', compact('report', 'residents', 'reportCategories'));
    }

    public function update(UpdateReportRequest $request, string $id)
    {
        $data = $request->validated();
        $this->reportRepository->updateReport($data, $id);
        toast('Data laporan sukses diupdate', 'success')->timerProgressBar();
        return redirect()->route('admin.report.index');
    }

    public function destroy(string $id)
    {
        $this->reportRepository->deleteReport($id);
        toast('Data laporan sukses dihapus', 'success')->timerProgressBar();
        return redirect()->route('admin.report.index');
    }
}
