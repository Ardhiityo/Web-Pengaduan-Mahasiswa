<?php

namespace App\Services\Interfaces;

interface FacultyRepositoryInterface
{
    public function getAllFaculties();
    public function getFacultyById($id);
    public function createFaculty(array $data);
    public function getFacultiesByAdminId(array $data);
}
