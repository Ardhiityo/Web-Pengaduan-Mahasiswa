<?php

namespace App\Services\Repositories;

use App\Models\Faculty;
use App\Services\Interfaces\FacultyRepositoryInterface;

class FacultyRepository implements FacultyRepositoryInterface
{
    public function getAllFaculties()
    {
        return Faculty::select('id', 'name')->get();
    }
}
