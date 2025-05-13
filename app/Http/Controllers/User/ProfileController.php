<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Resident\UpdateResidentRequest;
use App\Services\Interfaces\ResidentRepositoryInterface;
use App\Services\Interfaces\ReportStatusRepositoryInterface;
use App\Services\Interfaces\StudyProgramRepositoryInterface;

class ProfileController extends Controller
{
    public function __construct(
        private ReportStatusRepositoryInterface $reportStatusRepository,
        private ResidentRepositoryInterface $residentRepository,
        private StudyProgramRepositoryInterface $studyProgramRepository
    ) {}

    public function index()
    {
        $reportActive = $this->reportStatusRepository->getActiveReportStatusByResident();
        $reportDone = $this->reportStatusRepository->getDoneReportStatusByResident();

        return view('pages.app.profile', compact('reportActive', 'reportDone'));
    }

    public function edit()
    {
        $resident = $this->residentRepository->getResidentById(Auth::user()->resident->id);
        $studyPrograms = $this->studyProgramRepository->getAllStudyPrograms();

        return view('pages.app.edit-profile', compact('resident', 'studyPrograms'));
    }

    public function update(UpdateResidentRequest $request)
    {
        $data = $request->validated();
        $residentId = Auth::user()->resident->id;

        $this->residentRepository->updateResident($residentId, $data);

        return redirect()->route('profile');
    }
}
