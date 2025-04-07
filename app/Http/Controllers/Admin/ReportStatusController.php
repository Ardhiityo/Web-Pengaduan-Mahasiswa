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
        $decrypt = $this->decryptParameterRepository->getData(id: $reportId, message: 'Ups, Kemajuan laporan tidak ditemukan!', route: 'admin.report-status.index');

        if ($decrypt instanceof RedirectResponse) return $decrypt;

        $report = $this->reportRepository->getReportById($decrypt);

        return view('pages.admin.report-status.create', compact('report', 'report'));
    }

    public function store(StoreReportStatusRequest $request)
    {
        $data = $request->validated();
        $reportStatus = $this->reportStatusRepository->createReportStatus($data);
        toast('Status kemajuan laporan sukses ditambahkan', 'success')->timerProgressBar();

        return redirect()->route('admin.report.show', Crypt::encrypt($reportStatus->report->id));
    }

    public function show(string $reportStatusId)
    {
        $decrypt = $this->decryptParameterRepository->getData(id: $reportStatusId, message: 'Ups, Kemajuan laporan tidak ditemukan!', route: 'admin.report.index');

        if ($decrypt instanceof RedirectResponse) return $decrypt;

        $reportStatus = $this->reportStatusRepository->getReportStatusById($decrypt);

        return view('pages.admin.report-status.show', compact('reportStatus'));
    }

    public function edit(string $reportStatusId)
    {
        $decrypt = $this->decryptParameterRepository->getData(id: $reportStatusId, message: 'Ups, Kemajuan laporan tidak ditemukan!', route: 'admin.report-status.index');

        if ($decrypt instanceof RedirectResponse) return $decrypt;

        $reportStatus = $this->reportStatusRepository->getReportStatusById($decrypt);

        return view('pages.admin.report-status.edit', compact('reportStatus'));
    }

    public function update(UpdateReportStatusRequest $request, string $reportStatusId)
    {
        $decrypt = $this->decryptParameterRepository->getData(id: $reportStatusId, message: 'Ups, Kemajuan laporan tidak ditemukan!', route: 'admin.report-status.index');

        if ($decrypt instanceof RedirectResponse) return $decrypt;

        $data = $request->validated();
        $this->reportStatusRepository->updateReportStatus($data, $decrypt);
        toast('Data laporan sukses diupdate', 'success')->timerProgressBar();

        return redirect()->route('admin.report.show', Crypt::encrypt($data['report_id']));
    }

    public function destroy(string $id)
    {
        $decrypt = $this->decryptParameterRepository->getData(id: $id, message: 'Ups, Kemajuan laporan tidak ditemukan!', route: 'admin.report-status.index');

        if ($decrypt instanceof RedirectResponse) return $decrypt;

        $reportStatus = $this->reportStatusRepository->getReportStatusById($decrypt);

        $this->reportStatusRepository->deleteReportStatus($decrypt);

        toast('Kemajuan laporan sukses dihapus', 'success')->timerProgressBar();

        return redirect()->route('admin.report.show', Crypt::encrypt($reportStatus->report->id));
    }
}
