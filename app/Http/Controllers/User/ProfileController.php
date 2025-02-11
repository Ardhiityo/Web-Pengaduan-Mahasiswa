<?php

namespace App\Http\Controllers\User;

use App\Models\Report;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ReportStatus;
use App\Services\Interfaces\ReportStatusRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function __construct(private ReportStatusRepositoryInterface $reportStatusRepository) {}
    public function index()
    {
        $reportActive = $this->reportStatusRepository->getActiveReportStatusByResident();
        $reportDone = $this->reportStatusRepository->getDoneReportStatusByResident();
        return view('pages.app.profile', compact('reportActive', 'reportDone'));
    }
}
