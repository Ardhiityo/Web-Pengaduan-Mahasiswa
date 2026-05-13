<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Superadmin\Faculty\StoreFacultyRequest;
use App\Http\Requests\Superadmin\Faculty\UpdateFacultyRequest;
use App\Services\Interfaces\FacultyRepositoryInterface;
use Illuminate\Http\Request;

class FacultyController extends Controller
{
    public function __construct(private FacultyRepositoryInterface $facultyRepository) {}

    public function index(Request $request)
    {
        $per_page = (int) $request->query('per_page', 10);
        $search = $request->query('search', '');

        $faculties = $this->facultyRepository->getAllFaculties($per_page, $search);

        return view('pages.superadmin.faculty.index', compact('faculties'));
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
