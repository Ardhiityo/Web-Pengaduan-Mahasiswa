<?php

namespace App\Services\Interfaces;

interface ResidentRepositoryInterface
{
    public function getAllResidents();
    public function getResidentById(string $id);
    public function createResident(array $data);
    public function updateResident(string $id, array $data);
    public function deleteResident(string $id);
}
