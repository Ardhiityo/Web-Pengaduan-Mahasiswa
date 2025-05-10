<?php

namespace App\Services\Interfaces;

interface AdminRepositoryInterface
{
    public function getAllAdmins();
    public function createAdmin($data);
    public function updateAdmin($data);
}
