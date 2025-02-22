<?php

namespace App\Services\Repositories;

use App\Models\Report;
use App\Models\ReportCategory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
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
        try {
            return ReportCategory::where('name', $category)->firstOrFail()->reports;
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

        $report = Report::create($data);
        $report->reportStatuses()->create(['status' => 'delivered', 'description' => 'Laporanmu sudah kami terima']);
        return $report;
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
