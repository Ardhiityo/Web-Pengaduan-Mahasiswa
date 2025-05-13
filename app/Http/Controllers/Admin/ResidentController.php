<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Requests\Resident\StoreResidentRequest;
use App\Http\Requests\Resident\UpdateResidentRequest;
use App\Services\Interfaces\ResidentRepositoryInterface;
use App\Services\Interfaces\StudyProgramRepositoryInterface;
use App\Services\Interfaces\DecryptParameterRepositoryInterface;

class ResidentController extends Controller
{
    public function __construct(
        private ResidentRepositoryInterface $residentRepository,
        private DecryptParameterRepositoryInterface $decryptParameterRepository,
        private StudyProgramRepositoryInterface $studyProgramRepository
    ) {}

    public function index()
    {
        $residents = $this->residentRepository->getAllResidents();

        return view('pages.admin.resident.index', compact('residents'));
    }

    public function create()
    {
        $studyPrograms = $this->studyProgramRepository->getAllStudyPrograms();

        return view('pages.admin.resident.create', compact('studyPrograms'));
    }

    public function store(StoreResidentRequest $request)
    {
        $this->residentRepository->createResident(data: $request->validated());

        toast(title: 'Data mahasiswa sukses ditambahkan', type: 'success')
            ->timerProgressBar();

        return redirect()->route('admin.resident.index');
    }

    public function show(string $id)
    {
        $resident = $this->residentRepository->getResidentById(id: $id);

        return view('pages.admin.resident.show', compact('resident'));
    }

    public function edit(string $id)
    {
        $resident = $this->residentRepository->getResidentById(id: $id);
        $studyPrograms = $this->studyProgramRepository->getAllStudyPrograms();

        return view('pages.admin.resident.edit', compact('resident', 'studyPrograms'));
    }

    public function update(UpdateResidentRequest $request, string $id)
    {
        $this->residentRepository->updateResident($id, $request->validated());

        toast(title: 'Data mahasiswa sukses diupdate', type: 'success')
            ->timerProgressBar();

        return redirect()->route('admin.resident.index');
    }

    public function destroy(string $id)
    {
        $this->residentRepository->deleteResident($id);

        toast(title: 'Data mahasiswa sukses dihapus', type: 'success')
            ->timerProgressBar();

        return redirect()->route('admin.resident.index');
    }
}
