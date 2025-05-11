<?php

namespace App\Services\Interfaces;

interface AdminRepositoryInterface
{
    public function getAllAdmins();
    public function createAdmin(array $data);
    public function updateAdmin($id, $data);
    public function getAdminById($id);
    public function deleteAdminById($id);
    public function addAdminFaculty(array $data);
}
