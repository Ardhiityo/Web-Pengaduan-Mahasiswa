<?php

namespace Tests\Feature\Admin;

use App\Models\Faq;
use Tests\TestCase;
use App\Models\User;
use App\Models\Report;
use App\Models\Resident;
use App\Models\ReportCategory;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Support\Facades\Auth;

class DashboardControllerTest extends TestCase
{
    public function testDashboardSuccess(): void
    {
        $this->seed(DatabaseSeeder::class);

        $totalResidents = Resident::count();
        $totalReportCategories = ReportCategory::count();
        $totalReports = Report::count();
        $totalFAQ = Faq::count();

        $user = User::first();
        Auth::login($user);

        $this->get('/admin/dashboard')
            ->assertSeeText($totalResidents)
            ->assertSeeText($totalReportCategories)
            ->assertSeeText($totalReports)
            ->assertSeeText($totalFAQ)
            ->assertStatus(200);
    }

    public function testDashboardUnauthenticate(): void
    {
        $this->get('/admin/dashboard')
            ->assertStatus(302);
    }
}
