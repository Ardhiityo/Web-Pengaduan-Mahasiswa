<?php

namespace App\Services\Interfaces;

interface FacultyRepositoryInterface
{
    public function getAllFaculties(int $per_page = 0, string $search = '');
    public function getFacultyById($id);
    public function updateFacultyById($id, $data);
    public function createFaculty(array $data);
    public function getFacultiesByAdminId(array $data);
    public function deleteFacultyById(string $id);
}
