<?php

namespace Tests\Feature\Admin;

use Tests\TestCase;
use App\Models\User;
use App\Models\Report;
use App\Models\ReportStatus;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class ReportStatusControllerTest extends TestCase
{
    public function testReportStatusView()
    {
        $this->seed(DatabaseSeeder::class);

        $user = User::role('superadmin')->first();

        Auth::login($user);

        $report = Report::first();

        $this->get('/admin/report/' . $report->id)
            ->assertSeeText('No')
            ->assertSeeText('Bukti kemajuan laporan')
            ->assertSeeText('Status laporan')
            ->assertSeeText('Deskripsi laporan')
            ->assertSeeText('Aksi')
            ->assertStatus(200);
    }

    public function testReportStatusCreateView()
    {
        $this->seed(DatabaseSeeder::class);

        $user = User::role('superadmin')->first();

        Auth::login($user);

        $report = Report::first();

        $this->get('/admin/report/' . $report->id . '/report-status/create')
            ->assertSeeText('Tambah Data Kemajuan Laporan')
            ->assertStatus(200);
    }

    public function testReportStatusCreate()
    {
        $this->seed(DatabaseSeeder::class);

        $user = User::role('superadmin')->first();

        Auth::login($user);

        $report = Report::first();

        $this->post('/admin/report-status', [
            'report_id' => $report->id,
            'status' => 'delivered',
            'description' => 'testing'

        ])->assertStatus(302);

        self::assertNotNull(ReportStatus::where('description', 'testing')->first());
    }

    public function testReportStatusShow()
    {
        $this->seed(DatabaseSeeder::class);

        $user = User::role('superadmin')->first();

        Auth::login($user);

        $reportStatus = ReportStatus::first();

        $this->get('/admin/report-status/' . $reportStatus->id)
            ->assertSeeText($reportStatus->status)
            ->assertSeeText($reportStatus->description)
            ->assertStatus(200);
    }

    public function testReportStatusEditView()
    {
        $this->seed(DatabaseSeeder::class);

        $user = User::role('superadmin')->first();

        Auth::login($user);

        $reportStatus = ReportStatus::first();

        $this->get('/admin/report-status/' . $reportStatus->id . '/edit')
            ->assertSeeText('Edit Data Kemajuan Laporan ' . $reportStatus->report->code)
            ->assertStatus(200);
    }

    public function testReportStatusUpdate()
    {
        $this->seed(DatabaseSeeder::class);
        $user = User::role('superadmin')->first();

        Auth::login($user);

        $reportStatus = Report::first();

        $this->post('/admin/report-status', [
            'report_id' => $reportStatus->id,
            'status' => 'completed',
            'description' => 'completed'

        ])->assertStatus(302);

        self::assertNotNull(ReportStatus::where('description', 'completed')->first());
    }

    public function testReportStatusDestroy()
    {
        $this->seed(DatabaseSeeder::class);

        $user = User::role('superadmin')->first();

        self::assertNotNull($user);

        Auth::login($user);
        self::assertNotNull(Auth::user());

        $reportStatus = ReportStatus::first();
        self::assertNotNull($reportStatus);

        $this->delete('/admin/report-status/' . $reportStatus->id)
            ->assertStatus(302);

        self::assertNull(ReportStatus::find($reportStatus->id));
    }
}
