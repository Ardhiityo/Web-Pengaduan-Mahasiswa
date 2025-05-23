<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Services\Interfaces\StudyProgramRepositoryInterface;
use App\Http\Requests\Superadmin\StudyProgram\StoreStudyProgramRequest;
use App\Http\Requests\Superadmin\StudyProgram\UpdateStudyProgramRequest;

class StudyProgramController extends Controller
{
    public function __construct(private StudyProgramRepositoryInterface $studyProgramRepository) {}

    public function create()
    {
        return view('pages.superadmin.study-program.create');
    }

    public function store(StoreStudyProgramRequest $request)
    {
        $data = $request->validated();

        $this->studyProgramRepository->createStudyProgram($data);

        toast(title: 'Data program studi sukses ditambahkan', type: 'success')
            ->timerProgressBar();

        return redirect()->route('admin.faculty.show', ['faculty' => $data['faculty_id']]);
    }

    public function edit($facultyId, $studyProgramId)
    {
        $studyProgram = $this->studyProgramRepository->getStudyProgramById($studyProgramId);

        return view('pages.superadmin.study-program.edit', compact('studyProgram'));
    }

    public function update(UpdateStudyProgramRequest $request, $facultyId, $studyProgramId)
    {
        $this->studyProgramRepository->updateStudyProgramById($studyProgramId, $request->validated());

        toast(title: 'Data program studi sukses diubah', type: 'success')
            ->timerProgressBar();

        return redirect()->route('admin.faculty.show', ['faculty' => $facultyId]);
    }

    public function destroy($facultyId, $studyProgramId)
    {
        $this->studyProgramRepository->deleteStudyProgramById($studyProgramId);

        toast(title: 'Data program studi sukses dihapus', type: 'success')
            ->timerProgressBar();

        return redirect()->route('admin.faculty.show', ['faculty' => $facultyId]);
    }
}
