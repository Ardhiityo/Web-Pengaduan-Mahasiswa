<?php

namespace App\Services\Repositories;

use App\Models\StudyProgram;
use App\Services\Interfaces\StudyProgramRepositoryInterface;

class StudyProgramRepository implements StudyProgramRepositoryInterface
{
    public function getAllStudyPrograms()
    {
        return StudyProgram::select('id', 'name')->get();
    }

    public function createStudyProgram(array $data)
    {
        return StudyProgram::create($data);
    }
}
