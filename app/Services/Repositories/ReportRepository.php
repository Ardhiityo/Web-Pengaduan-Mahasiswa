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

    public function sendNotificationTelegram($report)
    {
        $api_token = env('BOT_TELE_API_TOKEN');
        $bot_id = env(key: 'BOT_ID');
        $method = 'sendMessage';

        $code = $report->code;
        $name = $report->resident->user->name;
        $title = $report->title;
        $description = $report->description;

        $message = "Hai, ada laporan baru nih, kode laporan <b>$code</b>, dilaporkan oleh <b>$name</b> dengan judul laporan <b>$title</b>, deskripsi laporan <b>$description</b>";

        $content = [
            'chat_id' => $bot_id,
            'text' => $message,
            'parse_mode' => 'html'
        ];

        try {
            return Http::post(
                "https://api.telegram.org/bot{$api_token}/{$method}",
                $content
            );
        } catch (Exception $exception) {
            Log::info(
                "message : " .  $exception->getMessage(),
                ['ReportRepository' => 'sendNotificationTelegram']
            );
        }
    }
}
