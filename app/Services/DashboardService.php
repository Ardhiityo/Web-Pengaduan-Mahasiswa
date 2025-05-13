<?php

namespace App\Services;

use App\Models\Faq;
use App\Models\Admin;
use App\Models\AdminFaculty;
use App\Models\Faculty;
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
            $adminFacultyIds = $user->faculties->pluck('id')->toArray();
            $studyProgramIds = StudyProgram::whereIn('faculty_id', $adminFacultyIds)
                ->pluck('id')
                ->toArray();

            $totalResidents = Resident::whereIn('study_program_id', $studyProgramIds)->count();
            $totalReports = Report::whereIn('study_program_id', $studyProgramIds)->count();
            $totalReportCategories = ReportCategory::count();
            $totalFAQs = Faq::count();
            $totalFaculties = Faculty::whereIn('id', $adminFacultyIds)->count();
            $totalAdmins = AdminFaculty::whereIn('faculty_id', $adminFacultyIds)->count();
            $totalStudyPrograms = StudyProgram::whereIn('faculty_id', $adminFacultyIds)->count();

            return compact('totalResidents', 'totalReportCategories', 'totalReports', 'totalFAQs', 'totalFaculties', 'totalAdmins', 'totalStudyPrograms');
        } else if ($user->hasRole('superadmin')) {
            $totalResidents = Resident::count();
            $totalReports = Report::count();
            $totalReportCategories = ReportCategory::count();
            $totalFAQs = Faq::count();
            $totalAdmins = AdminFaculty::count();
            $totalFaculties = Faculty::count();
            $totalStudyPrograms = StudyProgram::count();

            return compact('totalResidents', 'totalReportCategories', 'totalReports', 'totalFAQs', 'totalAdmins', 'totalFaculties', 'totalStudyPrograms');
        }
    }
}
