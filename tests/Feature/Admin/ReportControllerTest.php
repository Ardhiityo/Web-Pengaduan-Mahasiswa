<?php

namespace Tests\Feature\Admin;

use Tests\TestCase;
use App\Models\User;
use App\Models\Report;
use App\Models\ReportCategory;
use Illuminate\Http\UploadedFile;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class ReportControllerTest extends TestCase
{
    public function testReportView()
    {
        $this->seed(DatabaseSeeder::class);

        $user = User::first();

        Auth::login($user);

        $this->get('/admin/report')
            ->assertSeeText('Daftar Data Laporan')
            ->assertStatus(200);
    }

    public function testReportCreateView()
    {
        $this->seed(DatabaseSeeder::class);

        $user = User::first();

        Auth::login($user);

        $this->get('/admin/report/create')
            ->assertSeeText('Tambah Data')
            ->assertStatus(200);
    }

    public function testReportCreate()
    {
        $this->seed(DatabaseSeeder::class);

        $user = User::first();

        Auth::login($user);

        $user = User::where('email', 'hello@test.com')->first();

        $file = UploadedFile::fake()->image('icon.jpg');

        $reportCategory = ReportCategory::first();

        $this->post('/admin/report', [
            'resident_id' => $user->resident->id,
            'report_category_id' => $reportCategory->id,
            'title' => 'testing',
            'description' => 'testing',
            'image' => $file,
            'latitude' => '123',
            'longitude' => '123',
            'address' => 'test'
        ])
            ->assertRedirect(url('/admin/report'))
            ->assertStatus(302);

        $newReport = Report::where('title', 'testing')->first();

        self::assertNotNull($newReport);
    }

    public function testReportShow()
    {
        $this->seed(DatabaseSeeder::class);

        $user = User::first();

        Auth::login($user);

        $report = Report::first();

        $this->get('/admin/report/' . Crypt::encrypt($report->id))
            ->assertSeeText('Detail Laporan')
            ->assertStatus(200);
    }

    public function testReportEdit()
    {
        $this->seed(DatabaseSeeder::class);

        $user = User::first();

        Auth::login($user);

        $report = Report::first();

        $this->get('/admin/report/' . Crypt::encrypt($report->id) . '/edit')
            ->assertSeeText('Edit Data')
            ->assertStatus(200);
    }

    public function testReportUpdate()
    {
        $this->seed(DatabaseSeeder::class);

        $user = User::first();

        Auth::login($user);

        $user = User::where('email', 'hello@test.com')->first();

        $reportCategory = ReportCategory::first();

        $report = Report::first();

        $this->put('/admin/report/' . Crypt::encrypt($report->id), [
            'resident_id' => $user->resident->id,
            'report_category_id' => $reportCategory->id,
            'title' => 'updated',
            'description' => 'updated',
            'latitude' => '123',
            'longitude' => '123',
            'address' => 'test'
        ])
            ->assertRedirect(url('/admin/report'))
            ->assertStatus(302);

        $updatedReport = Report::where('title', 'updated')->first();

        self::assertNotNull($updatedReport);
    }

    public function testReportDestroy()
    {
        $this->seed(DatabaseSeeder::class);

        $user = User::first();

        Auth::login($user);

        $report = Report::first();

        $this->delete('/admin/report/' . Crypt::encrypt($report->id))
            ->assertRedirect(url('/admin/report'))
            ->assertStatus(302);
    }
}
