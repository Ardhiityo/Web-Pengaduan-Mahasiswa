<?php

namespace App\Services\Repositories;

use App\Models\Report;
use App\Models\ReportCategory;
use App\Services\Interfaces\ReportRepositoryInterface;
use PhpParser\Node\Stmt\TryCatch;

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

    public function getReportsByCategory(string $category)
    {
        try {
            return ReportCategory::where('name', $category)->firstOrFail()->reports;
        } catch (\Throwable $th) {
            return false;
        }
    }

    public function getReportByCode(string $code)
    {
        try {
            return Report::where('code', $code)->firstOrFail();
        } catch (\Throwable $th) {
            return false;
        }
    }

    public function latestReports()
    {
        return Report::latest()->take(3)->get();
    }

    public function createReport(array $data)
    {
        $data['code'] = "FIK-" . now()->format('U') . rand(0, 1000);

        if (isset($data['image'])) {
            $data['image'] = $data['image']->store('assets/report', 'public');
        };

        return Report::create($data)
            ->reportStatuses()->create(['status' => 'delivered', 'description' => 'Laporanmu sudah kami terima']);
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
