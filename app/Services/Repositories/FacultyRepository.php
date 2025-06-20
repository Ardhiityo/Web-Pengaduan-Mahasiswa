<?php

namespace App\Services\Repositories;

use App\Models\User;
use App\Models\Faculty;
use App\Services\Interfaces\FacultyRepositoryInterface;

class FacultyRepository implements FacultyRepositoryInterface
{
    public function getAllFaculties()
    {
        return Faculty::with(
            [
                'studyPrograms' => function ($query) {
                    $query->select('id', 'name', 'faculty_id');
                },
            ]
        )->select('id', 'name')->get();
    }

    public function getFacultyById($id)
    {
        try {
            return Faculty::with(
                [
                    'studyPrograms' => function ($query) {
                        $query->select('id', 'name', 'faculty_id');
                    },
                ]
            )
                ->select('id', 'name')
                ->findOrFail($id);
        } catch (\Throwable $th) {
            return abort(404, 'Faculty not found');
        }
    }

    public function updateFacultyById($id, $data)
    {
        $this->getFacultyById($id)->update($data);
    }

    public function createFaculty(array $data)
    {
        return Faculty::create($data);
    }

    public function getFacultiesByAdminId($adminId)
    {
        try {
            return User::findOrFail($adminId)->faculties;
        } catch (\Throwable $th) {
            return abort(404, 'Admin not found');
        }
    }

    public function deleteFacultyById(string $id)
    {
        return $this->getFacultyById($id)->delete();
    }
}
