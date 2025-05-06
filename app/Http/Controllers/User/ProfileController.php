<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Resident\UpdateResidentRequest;
use App\Services\Interfaces\ResidentRepositoryInterface;
use App\Services\Interfaces\ReportStatusRepositoryInterface;

class ProfileController extends Controller
{
    public function __construct(private ReportStatusRepositoryInterface $reportStatusRepository, private ResidentRepositoryInterface $residentRepository) {}
    public function index()
    {
        $reportActive = $this->reportStatusRepository->getActiveReportStatusByResident();
        $reportDone = $this->reportStatusRepository->getDoneReportStatusByResident();

        return view('pages.app.profile', compact('reportActive', 'reportDone'));
    }

    public function edit()
    {
        $resident = $this->residentRepository->getResidentById(Auth::user()->resident->id);
        return view('pages.app.edit-profile', compact('resident'));
    }

    public function update(UpdateResidentRequest $request)
    {
        $this->residentRepository->updateResident($request->validated(), Auth::user()->resident->id);
        return redirect()->route('profile');
    }
}
