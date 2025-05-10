<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Services\Interfaces\FacultyRepositoryInterface;
use Illuminate\Http\Request;

class FacultyController extends Controller
{
    public function __construct(private FacultyRepositoryInterface $facultyRepository) {}

    public function index()
    {
        $faculties = $this->facultyRepository->getAllFaculties();

        return view('pages.superadmin.faculty.index', compact('faculties'));
    }
}
