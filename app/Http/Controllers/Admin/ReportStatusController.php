<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Crypt;
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
        $decrypt = $this->decryptParameterRepository
            ->getData(
                id: $reportId,
                message: 'Ups, Kemajuan laporan tidak ditemukan!',
                route: 'admin.report-status.index'
            );

        if ($decrypt instanceof RedirectResponse) return $decrypt;

        $report = $this->reportRepository->getReportById(id: $decrypt);

        return view('pages.admin.report-status.create', compact('report', 'report'));
    }

    public function store(StoreReportStatusRequest $request)
    {
        $reportStatus = $this->reportStatusRepository
            ->createReportStatus(data: $request->validated());

        toast(title: 'Status kemajuan laporan sukses ditambahkan', type: 'success')
            ->timerProgressBar();

        return redirect()->route('admin.report.show', Crypt::encrypt($reportStatus->report->id));
    }

    public function show(string $reportStatusId)
    {
        $decrypt = $this->decryptParameterRepository
            ->getData(
                id: $reportStatusId,
                message: 'Ups, Kemajuan laporan tidak ditemukan!',
                route: 'admin.report.index'
            );

        if ($decrypt instanceof RedirectResponse) return $decrypt;

        $reportStatus = $this->reportStatusRepository->getReportStatusById(id: $decrypt);

        return view('pages.admin.report-status.show', compact('reportStatus'));
    }

    public function edit(string $reportStatusId)
    {
        $decrypt = $this->decryptParameterRepository
            ->getData(
                id: $reportStatusId,
                message: 'Ups, Kemajuan laporan tidak ditemukan!',
                route: 'admin.report-status.index'
            );

        if ($decrypt instanceof RedirectResponse) return $decrypt;

        $reportStatus = $this->reportStatusRepository->getReportStatusById(id: $decrypt);

        return view('pages.admin.report-status.edit', compact('reportStatus'));
    }

    public function update(UpdateReportStatusRequest $request, string $reportStatusId)
    {
        $decrypt = $this->decryptParameterRepository
            ->getData(
                id: $reportStatusId,
                message: 'Ups, Kemajuan laporan tidak ditemukan!',
                route: 'admin.report-status.index'
            );

        if ($decrypt instanceof RedirectResponse) return $decrypt;

        $data = $request->validated();

        $this->reportStatusRepository->updateReportStatus(data: $data, id: $decrypt);

        toast(title: 'Data laporan sukses diupdate', type: 'success')
            ->timerProgressBar();

        return redirect()->route('admin.report.show', Crypt::encrypt($data['report_id']));
    }

    public function destroy(string $id)
    {
        $decrypt = $this->decryptParameterRepository
            ->getData(
                id: $id,
                message: 'Ups, Kemajuan laporan tidak ditemukan!',
                route: 'admin.report-status.index'
            );

        if ($decrypt instanceof RedirectResponse) return $decrypt;

        $reportStatus = $this->reportStatusRepository->getReportStatusById(id: $decrypt);

        $this->reportStatusRepository->deleteReportStatus(id: $decrypt);

        toast(title: 'Kemajuan laporan sukses dihapus', type: 'success')
            ->timerProgressBar();

        return redirect()->route('admin.report.show', Crypt::encrypt($reportStatus->report->id));
    }
}
