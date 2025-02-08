<?php

namespace App\Services\Repositories;

use App\Models\Report;
use App\Services\Interfaces\ReportRepositoryInterface;

class ReportRepository implements ReportRepositoryInterface
{
    public function getAllReports()
    {
        return Report::all();
    }
    public function getReportById(int $id)
    {
        return Report::find($id);
    }

    public function latestReports()
    {
        return Report::latest()->take(3)->get();
    }

    public function createReport(array $data)
    {
        $data['code'] = "FIK-" . now()->format('U') . rand(0, 1000);
        $data['image'] = $data['image']->store('assets/report', 'public');

        return Report::create($data);
    }

    public function updateReport(array $data, int $id)
    {
        $report = $this->getReportById($id);
        if (isset($data['image'])) {
            $data['image'] = $data['image']->store('assets/report', 'public');
        }
        return $report->update($data);
    }

    public function deleteReport(int $id)
    {
        $report = $this->getReportById($id);
        $report->reportStatuses()->delete();
        $report->delete();
    }
}
