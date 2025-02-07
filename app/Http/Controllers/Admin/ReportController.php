<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Report\StoreReportRequest;
use App\Http\Requests\Report\UpdateReportCategory;
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

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reports = $this->reportRepository->getAllReports();
        return view('pages.admin.report.index', compact('reports'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $residents = $this->residentRepository->getAllResidents();
        $reportCategories = $this->reportCategoryRepository->getAllReportCategories();
        return view('pages.admin.report.create', compact('residents', 'reportCategories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreReportRequest $request)
    {
        $data = $request->validated();
        $this->reportRepository->createReport($data);
        toast('Data laporan sukses ditambahkan', 'success')->timerProgressBar();
        return redirect()->route('admin.report.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $report = $this->reportRepository->getReportById($id);
        return view('pages.admin.report.show', compact('report'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $report = $this->reportRepository->getReportById($id);
        $residents = $this->residentRepository->getAllResidents();
        $reportCategories = $this->reportCategoryRepository->getAllReportCategories();
        return view('pages.admin.report.edit', compact('report', 'residents', 'reportCategories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateReportCategory $request, string $id)
    {
        $data = $request->validated();
        $this->reportRepository->updateReport($data, $id);
        toast('Data laporan sukses diupdate', 'success')->timerProgressBar();
        return redirect()->route('admin.report.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->reportRepository->deleteReport($id);
        toast('Data laporan sukses dihapus', 'success')->timerProgressBar();
        return redirect()->route('admin.report.index');
    }
}
