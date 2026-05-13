<?php

namespace App\Services\Interfaces;

interface AdminRepositoryInterface
{
    public function getAllAdmins(int $per_page = 0, string $search = '');
    public function createAdmin(array $data);
    public function updateAdmin($id, $data);
    public function getAdminById($id);
    public function deleteAdminById($id);
    public function addAdminFaculty(array $data);
    public function deleteAdminFaculty($adminId, $facultyId);
}
