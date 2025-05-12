<?php

namespace App\Services\Interfaces;

interface StudyProgramRepositoryInterface
{
    public function getAllStudyPrograms();
    public function getStudyProgramById($id);
    public function createStudyProgram(array $data);
    public function deleteStudyProgramById($id);
}
