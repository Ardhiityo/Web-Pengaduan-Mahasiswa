<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\Report\StoreReportRequest;
use App\Http\Requests\Report\UpdateReportRequest;
use App\Services\Interfaces\ReportRepositoryInterface;
use App\Services\Interfaces\ResidentRepositoryInterface;
use App\Services\Interfaces\ReportStatusRepositoryInterface;
use App\Services\Interfaces\ReportCategoryRepositoryInterface;
use App\Services\Interfaces\DecryptParameterRepositoryInterface;

class ReportController extends Controller
{
    public function __construct(
        private ReportRepositoryInterface $reportRepository,
        private ResidentRepositoryInterface $residentRepository,
        private ReportCategoryRepositoryInterface $reportCategoryRepository,
        private ReportStatusRepositoryInterface $reportStatusRepository,
        private DecryptParameterRepositoryInterface $decryptParameterRepository
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
        $this->reportRepository->createReport($request->validated());

        toast(title: 'Data laporan sukses ditambahkan', type: 'success')
            ->timerProgressBar();

        return redirect()->route('admin.report.index');
    }

    public function show(string $id)
    {
        $report = $this->reportRepository->getReportById($id);

        return view('pages.admin.report.show', compact('report'));
    }

    public function edit(string $id)
    {
        $decrypt = $this->decryptParameterRepository
            ->getData(
                id: $id,
                message: 'Ups, Laporan tidak ditemukan!',
                route: 'admin.report.index'
            );

        if ($decrypt instanceof RedirectResponse) return $decrypt;

        $report = $this->reportRepository->getReportById($decrypt);

        $residents = $this->residentRepository->getAllResidents();

        $reportCategories = $this->reportCategoryRepository->getAllReportCategories();

        return view('pages.admin.report.edit', compact('report', 'residents', 'reportCategories'));
    }

    public function update(UpdateReportRequest $request, string $id)
    {
        $decrypt = $this->decryptParameterRepository
            ->getData(
                id: $id,
                message: 'Ups, Laporan tidak ditemukan!',
                route: 'admin.report.index'
            );

        if ($decrypt instanceof RedirectResponse) return $decrypt;

        $this->reportRepository->updateReport(data: $request->validated(), id: $decrypt);

        toast(title: 'Data laporan sukses diupdate', type: 'success')
            ->timerProgressBar();

        return redirect()->route('admin.report.index');
    }

    public function destroy(string $id)
    {
        $decrypt = $this->decryptParameterRepository
            ->getData(
                id: $id,
                message: 'Ups, Laporan tidak ditemukan!',
                route: 'admin.report.index'
            );

        if ($decrypt instanceof RedirectResponse) return $decrypt;

        $this->reportRepository->deleteReport($decrypt);

        toast(title: 'Data laporan sukses dihapus', type: 'success')
            ->timerProgressBar();

        return redirect()->route('admin.report.index');
    }
}
