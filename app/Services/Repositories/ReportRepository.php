<?php

namespace App\Services\Repositories;

use Exception;
use App\Models\Report;
use App\Models\ReportStatus;
use App\Models\ReportCategory;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
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

    public function getReportsByCategory(string $category)
    {
        return ReportCategory::with('reports', 'reportStatuses')
            ->where('name', $category)
            ->first();
    }

    public function latestReports()
    {
        return Report::with('reportStatuses')->latest()->take(3)->get();
    }

    public function createReport(array $data)
    {
        $data['code'] = uniqid('FIK-');

        if (isset($data['image'])) {
            $data['image'] = $data['image']->store('assets/report', 'public');
        };

        $report = Report::create($data);
        $report->reportStatuses()->create([
            'status' => 'delivered',
            'description' => 'Laporanmu sudah kami terima'
        ]);

        return $report;
    }

    public function updateReport(array $data, int $id)
    {
        $report = $this->getReportById($id);

        if (isset($data['image'])) {
            if (!is_null($report->image)) {
                Storage::disk('public')->delete($report->image);
            }
            $data['image'] = $data['image']->store('assets/report', 'public');
        }

        return $report->update($data);
    }

    public function deleteReport(int $id)
    {
        $report = $this->getReportById($id);

        if ($report->reportStatuses->count()) {
            $reportStatuses = ReportStatus::where('report_id', $report->id)->get();
            foreach ($reportStatuses as $reportStatus) {
                if (!is_null($reportStatus->image)) {
                    Storage::disk('public')->delete($reportStatus->image);
                }
            }
        }
        $report->reportStatuses()->delete();

        if (!is_null($report->image)) {
            Storage::disk('public')->delete($report->image);
        }

        $report->delete();
    }
}
