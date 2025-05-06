<?php

namespace App\Jobs;

use Exception;
use App\Models\Report;
use App\Services\TelegramService;
use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;

class ProcessNotification implements ShouldQueue
{
    use Queueable;

    public $tries = 3;
    public $timeout = 120;

    /**
     * Create a new job instance.
     */
    public function __construct(private Report $report)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(TelegramService $telegramService): void
    {
        try {
            $telegramService->sendNotificationTelegram($this->report);
        } catch (Exception $e) {
            // Log error
            Log::error('Gagal mengirim notifikasi Telegram: ' . $e->getMessage(), [
                'report_id' => $this->report->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            // Throw exception untuk menandai job gagal
            throw $e;
        }
    }

    /**
     * Handle kegagalan job.
     */
    public function failed(Exception $exception): void
    {
        // Log kegagalan job
        Log::error('Job ProcessNotification gagal dieksekusi', [
            'report_id' => $this->report->id,
            'error' => $exception->getMessage()
        ]);
    }
}
