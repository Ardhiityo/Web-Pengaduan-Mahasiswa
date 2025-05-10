<?php

namespace App\Services;

use App\Models\Faq;
use App\Models\Admin;
use App\Models\Report;
use App\Models\Resident;
use App\Models\StudyProgram;
use App\Models\ReportCategory;
use Illuminate\Support\Facades\Auth;

class DashboardService
{
    public function getDashboardData()
    {
        $user = Auth::user();

        if ($user->hasRole('admin')) {
            $admin = Admin::where("user_id", $user->id)->first();
            $studyProgramId = StudyProgram::where('faculty_id', $admin->faculty_id)
                ->pluck('id')
                ->toArray();

            $totalResidents = Resident::whereIn('study_program_id', $studyProgramId)->count();
            $totalReports = Report::whereIn('study_program_id', $studyProgramId)->count();
            $totalReportCategories = ReportCategory::count();
            $totalFAQs = Faq::count();

            return compact('totalResidents', 'totalReportCategories', 'totalReports', 'totalFAQs');
        } else if ($user->hasRole('superadmin')) {
            $totalResidents = Resident::count();
            $totalReports = Report::count();
            $totalReportCategories = ReportCategory::count();
            $totalFAQs = Faq::count();
            $totalAdmins = Admin::count();

            return compact('totalResidents', 'totalReportCategories', 'totalReports', 'totalFAQs', 'totalAdmins');
        }
    }
}
