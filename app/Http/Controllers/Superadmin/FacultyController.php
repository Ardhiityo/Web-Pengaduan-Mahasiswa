<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Superadmin\Faculty\StoreFacultyRequest;
use App\Http\Requests\Superadmin\Faculty\UpdateFacultyRequest;
use App\Services\Interfaces\FacultyRepositoryInterface;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class FacultyController extends Controller
{
    public function __construct(private FacultyRepositoryInterface $facultyRepository) {}

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = $this->facultyRepository->getAllFaculties();

            return DataTables::eloquent($query)
                ->addIndexColumn()
                ->addColumn('study_programs', fn($row) =>
                    $row->studyPrograms->isEmpty() ? '-' : $row->studyPrograms->pluck('name')->implode(', ')
                )
                ->addColumn('action', function ($row) {
                    return '
                        <a href="' . route('admin.faculty.show', $row->id) . '" class="my-1 btn btn-info btn-sm">Show</a>
                        <a href="' . route('admin.faculty.edit', $row->id) . '" class="my-1 btn btn-warning btn-sm">Edit</a>
                        <form action="' . route('admin.faculty.destroy', $row->id) . '" method="POST" class="d-inline">
                            ' . csrf_field() . method_field('DELETE') . '
                            <button type="submit" class="my-1 btn btn-sm btn-danger">Delete</button>
                        </form>
                    ';
                })
                ->filterColumn('study_programs', fn($query, $keyword) =>
                    $query->whereHas('studyPrograms', fn($q) => $q->where('name', 'like', "%{$keyword}%"))
                )
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('pages.superadmin.faculty.index');
    }

    public function create()
    {
        return view('pages.superadmin.faculty.create');
    }

    public function store(StoreFacultyRequest $request)
    {
        $this->facultyRepository->createFaculty($request->validated());

        toast(title: 'Data fakultas sukses ditambahkan', type: 'success')
            ->timerProgressBar();

        return redirect()->route('admin.faculty.index');
    }

    public function show($id)
    {
        $faculty = $this->facultyRepository->getFacultyById($id);

        return view('pages.superadmin.faculty.show', compact('faculty'));
    }

    public function edit($id)
    {
        $faculty = $this->facultyRepository->getFacultyById($id);

        return view('pages.superadmin.faculty.edit', compact('faculty'));
    }

    public function update(UpdateFacultyRequest $request, $id)
    {
        $this->facultyRepository->updateFacultyById($id, $request->validated());

        toast(title: 'Data fakultas sukses diubah', type: 'success')
            ->timerProgressBar();

        return redirect()->route('admin.faculty.index');
    }

    public function destroy(string $id)
    {
        $this->facultyRepository->deleteFacultyById($id);

        toast(title: 'Data fakultas sukses dihapus', type: 'success')
            ->timerProgressBar();

        return redirect()->route('admin.faculty.index');
    }
}
