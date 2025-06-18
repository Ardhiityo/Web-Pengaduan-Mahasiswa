<?php

namespace Tests\Feature\User;

use App\Models\Report;
use App\Models\StudyProgram;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Support\Facades\Auth;

class ReportControllerTest extends TestCase
{
    public function testReportView()
    {
        $this->seed(DatabaseSeeder::class);

        $user = User::where('email', 'hello@test.com')->first();

        Auth::login($user);

        $this->get('/reports/myreports?status=delivered')
            ->assertSeeText('Diterima')
            ->assertSeeText('Diproses')
            ->assertSeeText('Selesai')
            ->assertSeeText('Ditolak')
            ->assertStatus(200);
    }

    public function testReportViewSuccess()
    {
        $this->seed(DatabaseSeeder::class);

        $user = User::where('email', 'hello@test.com')->first();

        Auth::login($user);

        $this->get('/reports/reports-success')
            ->assertSeeText('Yeay! Laporan kamu berhasil dibuat')
            ->assertStatus(200);
    }

    public function testReportViewTakeCreate()
    {
        $this->seed([DatabaseSeeder::class]);

        $user = User::where('email', 'hello@test.com')->first();
        self::assertNotNull($user);

        Auth::login($user);
        self::assertNotNull(Auth::user()->id);

        $file = UploadedFile::fake()->image('icon.jpg');
        self::assertNotNull($file);

        $report = Report::first();
        self::assertNotNull($report->id);

        $studyProgramId = StudyProgram::first()->id;

        $this->post('/reports/take/create-report', [
            'report_category_id' => $report->report_category_id,
            'title' => $report->title,
            'description' => $report->description,
            'image' => $file,
            'study_program_id' => $studyProgramId,
            'latitude' => $report->latitude,
            'longitude' => $report->longitude,
            'address' => $report->address
        ])
            ->assertRedirect(route('report.success'))
            ->assertStatus(302);
    }

    public function testReportViewTakeCreateView()
    {
        $this->seed(DatabaseSeeder::class);

        $user = User::where('email', 'hello@test.com')->first();

        Auth::login($user);

        $this->get('/reports/take/create-report')
            ->assertSeeText('Laporkan segera masalahmu di sini!')
            ->assertStatus(200);
    }

    public function testReportViewTakeCreatePreviewView()
    {
        $this->seed(DatabaseSeeder::class);

        $user = User::where('email', 'hello@test.com')->first();

        Auth::login($user);

        $this->get('/reports/take/preview')
            ->assertSeeText('Ulangi Foto')
            ->assertSeeText('Gunakan Foto')
            ->assertStatus(200);
    }

    public function testReportTakeView()
    {
        $this->seed(DatabaseSeeder::class);

        $user = User::where('email', 'hello@test.com')->first();

        Auth::login($user);

        $this->get('/reports/take')
            ->assertSeeText('Ambil foto')
            ->assertStatus(200);
    }
}
