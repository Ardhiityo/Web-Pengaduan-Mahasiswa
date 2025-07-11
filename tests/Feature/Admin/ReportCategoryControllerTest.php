<?php

namespace Tests\Feature\Admin;

use Tests\TestCase;
use App\Models\User;
use App\Models\ReportCategory;
use Database\Seeders\AdminSeeder;
use Illuminate\Http\UploadedFile;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Support\Facades\Auth;
use Database\Seeders\ReportCategorySeeder;
use Database\Seeders\RolePermissionSeeder;
use Database\Seeders\SuperAdminSeeder;

class ReportCategoryControllerTest extends TestCase
{
    public function testReportCategoryView()
    {
        $this->seed(DatabaseSeeder::class);

        $user = User::role('superadmin')->first();

        Auth::login($user);

        $this->get('/admin/report-category')
            ->assertSeeText('Daftar Data Kategori')
            ->assertStatus(200);
    }

    public function testReportCategoryCreateView()
    {
        $this->seed(DatabaseSeeder::class);

        $user = User::role('superadmin')->first();

        Auth::login($user);

        $this->get('/admin/report-category/create')
            ->assertSeeText('Nama Kategori')
            ->assertSeeText('Icon')
            ->assertStatus(200);
    }

    public function testReportCategoryCreate()
    {
        $this->seed(DatabaseSeeder::class);

        $user = User::role('superadmin')->first();

        Auth::login($user);

        $file = UploadedFile::fake()->image('icon.jpg');

        $this->post('/admin/report-category', [
            'name' => 'testing',
            'image' => $file
        ])
            ->assertRedirect(url('/admin/report-category'))
            ->assertStatus(302);
    }

    public function testReportCategoryShow()
    {
        $this->seed(DatabaseSeeder::class);

        $user = User::role('superadmin')->first();

        Auth::login($user);

        $reportCategory = ReportCategory::first();

        $this->get('/admin/report-category/' . $reportCategory->id)
            ->assertSeeText($reportCategory->name)
            ->assertSeeText('Nama')
            ->assertSeeText('Ikon')
            ->assertStatus(200);
    }

    public function testReportCategoryEdit()
    {
        $this->seed(DatabaseSeeder::class);

        $user = User::role('superadmin')->first();

        Auth::login($user);

        $reportCategory = ReportCategory::first();

        $this->get('/admin/report-category/' . $reportCategory->id . '/edit')
            ->assertSeeText('Nama Kategori')
            ->assertSeeText('Ikon Lama')
            ->assertSeeText('Ikon Baru')
            ->assertStatus(200);
    }

    public function testReportCategoryUpdate()
    {
        $this->seed(DatabaseSeeder::class);

        $user = User::role('superadmin')->first();

        Auth::login($user);

        $reportCategory = ReportCategory::first();

        $file = UploadedFile::fake()->image('icon.jpg');

        $this->put('/admin/report-category/' . $reportCategory->id, [
            'name' => 'update',
            'image' => $file
        ])
            ->assertRedirect(url('/admin/report-category'))
            ->assertStatus(302);

        $updateReportCategory = ReportCategory::find($reportCategory->id);

        self::assertNotEquals($reportCategory->name, $updateReportCategory->name);
        self::assertNotEquals($reportCategory->image, $updateReportCategory->image);
    }

    public function testReportCategoryDestroy()
    {
        $this->seed([RolePermissionSeeder::class, SuperAdminSeeder::class, ReportCategorySeeder::class]);

        $user = User::role('superadmin')->first();

        Auth::login($user);

        $reportCategory = ReportCategory::first();

        $this->delete('/admin/report-category/' . $reportCategory->id)
            ->assertRedirect('/admin/report-category')
            ->assertStatus(302);

        self::assertNull(ReportCategory::find($reportCategory->id));
    }
}
