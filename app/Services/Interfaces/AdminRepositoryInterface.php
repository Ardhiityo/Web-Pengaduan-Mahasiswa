<?php

namespace App\Services\Interfaces;

interface AdminRepositoryInterface
{
    public function getAllAdmins();
    public function createAdmin($data);
    public function updateAdmin($id, $data);
    public function getAdminById($id);
    public function deleteAdminById($id);
}
