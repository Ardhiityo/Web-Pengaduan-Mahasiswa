<?php

namespace App\Services\Repositories;

use App\Models\ReportStatus;
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
        return $reportStatus->update($data);
    }

    public function deleteReportStatus(int $id)
    {
        $report = $this->getReportStatusById($id);
        return $report->delete();
    }
}
