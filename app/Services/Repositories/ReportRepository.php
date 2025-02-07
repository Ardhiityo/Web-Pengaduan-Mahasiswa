<?php

namespace App\Services\Repositories;

use Ramsey\Uuid\Uuid;
use App\Models\Report;
use Illuminate\Support\Str;
use App\Services\Interfaces\ReportRepositoryInterface;
use Carbon\Carbon;

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

    public function createReport(array $data)
    {
        $data['code'] = "FIK-" . now()->format('U');
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
        return $report->delete();
    }
}
