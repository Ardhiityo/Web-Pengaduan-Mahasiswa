<?php

namespace App\Services\Repositories;

use App\Models\StudyProgram;
use App\Services\Interfaces\StudyProgramRepositoryInterface;
use function Laravel\Prompts\select;

class StudyProgramRepository implements StudyProgramRepositoryInterface
{
    public function getAllStudyPrograms()
    {
        return StudyProgram::select('id', 'name')->get();
    }

    public function getStudyProgramById($id)
    {
        try {
            return StudyProgram::select('id', 'name')->findOrFail($id);
        } catch (\Throwable $th) {
            return abort(404);
        }
    }

    public function updateStudyProgramById($id, array $data)
    {
        return $this->getStudyProgramById($id)->update($data);
    }

    public function createStudyProgram(array $data)
    {
        return StudyProgram::create($data);
    }

    public function deleteStudyProgramById($id)
    {
        return StudyProgram::destroy($id);
    }
}
