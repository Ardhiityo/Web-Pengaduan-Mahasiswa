<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Resident\StoreResidentRequest;
use App\Http\Requests\Resident\UpdateResidentRequest;
use App\Services\Interfaces\DecryptParameterRepositoryInterface;
use App\Services\Interfaces\ResidentRepositoryInterface;
use App\Services\Interfaces\StudyProgramRepositoryInterface;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ResidentController extends Controller
{
    public function __construct(
        private ResidentRepositoryInterface $residentRepository,
        private DecryptParameterRepositoryInterface $decryptParameterRepository,
        private StudyProgramRepositoryInterface $studyProgramRepository
    ) {}

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = $this->residentRepository->getAllResidents();

            return DataTables::eloquent($query)
                ->addIndexColumn()
                ->addColumn('name', fn($row) => $row->user->name)
                ->addColumn('email', fn($row) => $row->user->email)
                ->addColumn('study_program', fn($row) => $row->studyProgram->name ?? '-')
                ->addColumn('avatar', function ($row) {
                    if ($row->avatar) {
                        return '<img src="' . asset('storage/' . $row->avatar) . '" alt="avatar" width="60">';
                    }
                    return '-';
                })
                ->addColumn('action', function ($row) {
                    return '
                        <a href="' . route('admin.resident.show', $row->id) . '" class="my-1 btn btn-sm btn-info">Show</a>
                        <a href="' . route('admin.resident.edit', $row->id) . '" class="my-1 btn btn-sm btn-warning">Edit</a>
                        <form action="' . route('admin.resident.destroy', $row->id) . '" method="POST" class="d-inline">
                            ' . csrf_field() . method_field('DELETE') . '
                            <button type="submit" class="my-1 btn btn-sm btn-danger">Delete</button>
                        </form>
                    ';
                })
                ->filterColumn('name', fn($query, $keyword) =>
                    $query->whereHas('user', fn($q) => $q->where('name', 'like', "%{$keyword}%"))
                )
                ->filterColumn('email', fn($query, $keyword) =>
                    $query->whereHas('user', fn($q) => $q->where('email', 'like', "%{$keyword}%"))
                )
                ->filterColumn('study_program', fn($query, $keyword) =>
                    $query->whereHas('studyProgram', fn($q) => $q->where('name', 'like', "%{$keyword}%"))
                )
                ->rawColumns(['avatar', 'action'])
                ->make(true);
        }

        return view('pages.admin.resident.index');
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
