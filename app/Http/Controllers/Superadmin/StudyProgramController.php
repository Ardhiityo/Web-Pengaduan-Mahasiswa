<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Superadmin\StudyProgram\StoreStudyProgramRequest;
use App\Services\Interfaces\StudyProgramRepositoryInterface;

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

        toast(title: 'Data studi program sukses ditambahkan', type: 'success')
            ->timerProgressBar();

        return redirect()->route('admin.faculty.show', ['faculty' => $data['faculty_id']]);
    }
}
