<?php

namespace App\Services\Repositories;

use App\Models\Report;
use App\Models\ReportCategory;
use App\Models\ReportStatus;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
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
        return Report::findOrFail($id);
    }

    public function getReportsByCategory(string $category)
    {
        try {
            return ReportCategory::where('name', $category)->firstOrFail()->reports;
        } catch (\Throwable $th) {
            return false;
        }
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
        $report->reportStatuses()->create(['status' => 'delivered', 'description' => 'Laporanmu sudah kami terima']);
        return $report;
    }

    public function updateReport(array $data, int $id)
    {
        $report = $this->getReportById($id);

        if (isset($data['image'])) {
            //check if the image is available in storage
            if (Storage::disk('public')->exists($report->image)) {
                //delete the image that is in storage
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
                if ($reportStatus->image) {
                    if (Storage::disk('public')->exists($reportStatus->image)) {
                        Storage::disk('public')->delete($reportStatus->image);
                    }
                }
            }
        }
        $report->reportStatuses()->delete();

        //check if the image is available in storage
        if (Storage::disk('public')->exists($report->image)) {
            //delete the image that is in storage
            Storage::disk('public')->delete($report->image);
        }
        $report->delete();
    }

    public function sendNotificationTelegram($report)
    {
        $api_token = env('BOT_TELE_API_TOKEN');
        $bot_id = env('BOT_ID');
        $method = 'sendMessage';
        $user = Auth::user()->name;

        $message = "Hai, ada laporan baru nih, kode laporan <b>$report->code</b>, dilaporkan oleh <b>$user</b> dengan judul laporan <b>$report->title</b>, deskripsi laporan <b>$report->description</b>";
        $content = [
            'chat_id' => $bot_id,
            'text' => $message,
            'parse_mode' => 'html'
        ];
        return Http::post(
            "https://api.telegram.org/bot{$api_token}/{$method}",
            $content
        );
    }
}
