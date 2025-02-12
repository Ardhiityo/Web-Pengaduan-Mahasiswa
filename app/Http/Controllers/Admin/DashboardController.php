<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Report;
use App\Models\ReportCategory;
use App\Models\Resident;

class DashboardController extends Controller
{

    public function index()
    {
        $totalResidents = Resident::count();
        $totalReportCategories = ReportCategory::count();
        $totalReports = Report::count();
        return view('pages.admin.dashboard', compact('totalResidents', 'totalReportCategories', 'totalReports'));
    }
}
