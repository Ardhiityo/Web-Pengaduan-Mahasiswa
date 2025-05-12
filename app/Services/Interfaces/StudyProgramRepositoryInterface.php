<?php

namespace App\Services\Interfaces;

interface StudyProgramRepositoryInterface
{
    public function getAllStudyPrograms();
    public function createStudyProgram(array $data);
}
