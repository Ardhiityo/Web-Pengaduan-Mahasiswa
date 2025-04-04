<?php

namespace Tests\Feature\User;

use Faker\Factory;
use Tests\TestCase;
use App\Models\User;
use App\Models\ReportCategory;
use Database\Seeders\AdminSeeder;
use Illuminate\Http\UploadedFile;
use Database\Seeders\DatabaseSeeder;
use Database\Seeders\ReportCategorySeeder;
use Database\Seeders\ResidentSeeder;
use Illuminate\Support\Facades\Auth;

class ReportControllerTest extends TestCase
{
    public function testReportView()
    {
        $this->seed(DatabaseSeeder::class);

        $user = User::where('email', 'hello@test.com')->first();
        $user->email_verified_at = now();
        $user->save();

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
        $user->email_verified_at = now();
        $user->save();

        Auth::login($user);

        $this->get('/reports/reports-success')
            ->assertSeeText('Yeay! Laporan kamu berhasil dibuat')
            ->assertStatus(200);
    }

    public function testReportViewTakeCreate()
    {
        $this->seed([AdminSeeder::class, ResidentSeeder::class, ReportCategorySeeder::class]);

        $user = User::where('email', 'hello@test.com')->first();
        self::assertNotNull($user);

        Auth::login($user);
        self::assertNotNull(Auth::user());

        $reportCategory = ReportCategory::first();
        self::assertNotNull($reportCategory);

        $faker = Factory::create();

        $file = UploadedFile::fake()->image('icon.jpg');

        self::assertNotNull($file);

        $this->post('/reports/take/create-report', [
            // 'resident_id' => $user->resident->id,
            'report_category_id' => $reportCategory->id,
            'title' => $faker->sentence(5),
            'description' => $faker->sentence(10),
            'image' => $file,
            'latitude' => $faker->latitude(),
            'longitude' => $faker->longitude(),
            'address' => $faker->address()
        ])
            ->assertRedirect(url('/reports/reports-success'))
            ->assertStatus(302);
    }

    public function testReportViewTakeCreateView()
    {
        $this->seed(DatabaseSeeder::class);

        $user = User::where('email', 'hello@test.com')->first();
        $user->email_verified_at = now();
        $user->save();

        Auth::login($user);

        $this->get('/reports/take/create-report')
            ->assertSeeText('Laporkan segera masalahmu di sini!')
            ->assertStatus(200);
    }

    public function testReportViewTakeCreatePreviewView()
    {
        $this->seed(DatabaseSeeder::class);

        $user = User::where('email', 'hello@test.com')->first();
        $user->email_verified_at = now();
        $user->save();

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
        $user->email_verified_at = now();
        $user->save();

        Auth::login($user);

        $this->get('/reports/take')
            ->assertSeeText('Ambil foto')
            ->assertStatus(200);
    }
}
