<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Interfaces\ReportRepositoryInterface;
use App\Http\Requests\ReportStatus\StoreReportStatusRequest;
use App\Services\Interfaces\ReportStatusRepositoryInterface;
use App\Http\Requests\ReportStatus\UpdateReportStatusRequest;
use App\Services\Interfaces\ReportCategoryRepositoryInterface;
use App\Services\Interfaces\DecryptParameterRepositoryInterface;

class ReportStatusController extends Controller
{
    public function __construct(
        private ReportRepositoryInterface $reportRepository,
        private ReportStatusRepositoryInterface $reportStatusRepository,
        private ReportCategoryRepositoryInterface $reportCategoryRepository,
        private DecryptParameterRepositoryInterface $decryptParameterRepository
    ) {}

    public function create($reportId)
    {
        $report = $this->reportRepository->getReportById(id: $reportId);

        return view('pages.admin.report-status.create', compact('report'));
    }

    public function store(StoreReportStatusRequest $request)
    {
        $reportStatus = $this->reportStatusRepository
            ->createReportStatus(data: $request->validated());

        toast(title: 'Status kemajuan laporan sukses ditambahkan', type: 'success')
            ->timerProgressBar();

        return redirect()->route('admin.report.show', ['report' => $reportStatus->report->id]);
    }

    public function show(string $reportStatusId)
    {
        $reportStatus = $this->reportStatusRepository->getReportStatusById(id: $reportStatusId);

        return view('pages.admin.report-status.show', compact('reportStatus'));
    }

    public function edit(string $reportStatusId)
    {
        $reportStatus = $this->reportStatusRepository->getReportStatusById(id: $reportStatusId);

        return view('pages.admin.report-status.edit', compact('reportStatus'));
    }

    public function update(UpdateReportStatusRequest $request, string $reportStatusId)
    {
        $data = $request->validated();

        $this->reportStatusRepository->updateReportStatus(data: $data, id: $reportStatusId);

        toast(title: 'Data laporan sukses diupdate', type: 'success')
            ->timerProgressBar();

        return redirect()->route('admin.report.show', ['report' => $data['report_id']]);
    }

    public function destroy(string $id)
    {
        $reportStatus = $this->reportStatusRepository->getReportStatusById(id: $id);

        $this->reportStatusRepository->deleteReportStatus(id: $id);

        toast(title: 'Kemajuan laporan sukses dihapus', type: 'success')
            ->timerProgressBar();

        return redirect()->route('admin.report.show', ['report' => $reportStatus->report->id]);
    }
}
