<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Services\Interfaces\AdminRepositoryInterface;
use App\Services\Interfaces\FacultyRepositoryInterface;
use App\Http\Requests\Superadmin\AdminFaculty\StoreAdminFacultyRequest;

class AdminFacultyController extends Controller
{
    public function __construct(
        private FacultyRepositoryInterface $facultyRepository,
        private AdminRepositoryInterface $adminRepository
    ) {}

    public function create(string $adminId)
    {
        $faculties = $this->facultyRepository->getAllFaculties();

        return view("pages.superadmin.admin-faculty.create", compact("faculties", 'adminId'));
    }

    public function store(StoreAdminFacultyRequest $request)
    {
        $data = $request->validated();

        $this->adminRepository->addAdminFaculty($data);

        toast(title: 'Data admin fakultas sukses ditambahkan', type: 'success')
            ->timerProgressBar();

        return redirect()->route("admin.admin.show", ["admin" => $data['user_id']]);
    }

    public function destroy(string $adminId, string $facultyId)
    {
        $this->adminRepository->deleteAdminFaculty($adminId, $facultyId);

        toast(title: 'Data admin fakultas sukses dihapus', type: 'success')
            ->timerProgressBar();

        return redirect()->route("admin.admin.show", ["admin" => $adminId]);
    }
}
