<?php

namespace App\Services\Repositories;

use App\Models\ReportStatus;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Services\Interfaces\ReportStatusRepositoryInterface;

class ReportStatusRepository implements ReportStatusRepositoryInterface
{
    public function getAllReportStatuses()
    {
        return ReportStatus::all();
    }

    public function getReportStatusById(int $id)
    {
        return ReportStatus::find($id);
    }

    public function getReportStatusByResident(string $status)
    {
        $residentId = Auth::user()->resident->id;
        return
            ReportStatus::whereHas('report', function ($query) use ($residentId) {
                $query->where('resident_id', $residentId);
            })
            ->select('report_statuses.*')
            ->join(DB::raw('(SELECT report_id, MAX(created_at) as latest_created_at FROM report_statuses WHERE deleted_at IS NULL GROUP BY report_id) as latest_statuses'), function ($join) {
                $join->on('report_statuses.report_id', '=', 'latest_statuses.report_id')
                    ->on('report_statuses.created_at', '=', 'latest_statuses.latest_created_at');
            })
            ->where('status', $status)->get();
    }

    public function createReportStatus(array $data)
    {
        if (isset($data['image'])) {
            $data['image'] = $data['image']->store('assets/report-status', 'public');
        }
        return ReportStatus::create($data);
    }

    public function updateReportStatus(array $data, int $id)
    {
        $reportStatus = $this->getReportStatusById($id);
        if (isset($data['image'])) {
            $data['image'] = $data['image']->store('assets/report-status', 'public');
        }
        return $reportStatus->update($data);
    }

    public function deleteReportStatus(int $id)
    {
        $report = $this->getReportStatusById($id);
        return $report->delete();
    }
    public function getActiveReportStatusByResident()
    {
        $reportDelivered = $this->getReportStatusByResident('delivered')->count();
        $reportInProcess = $this->getReportStatusByResident('in_process')->count();
        $total = $reportDelivered + $reportInProcess;
        return $total;
    }

    public function getDoneReportStatusByResident()
    {
        $reportCompleted = $this->getReportStatusByResident('completed')->count();
        $reportRejected = $this->getReportStatusByResident('rejected')->count();
        $total = $reportCompleted + $reportRejected;
        return $total;
    }
}
