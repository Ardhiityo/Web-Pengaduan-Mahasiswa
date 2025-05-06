<?php

namespace App\Services;

use Exception;
use App\Models\Report;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class TelegramService
{
    public function sendNotificationTelegram(Report $report)
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
