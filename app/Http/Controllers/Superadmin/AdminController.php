<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Superadmin\StoreAdminRequest;
use App\Services\Interfaces\AdminRepositoryInterface;
use App\Services\Interfaces\FacultyRepositoryInterface;
use App\Services\Repositories\DecryptParameterRepository;
use App\Http\Requests\Superadmin\Admin\UpdateAdminRequest;

class AdminController extends Controller
{

    public function __construct(
        private AdminRepositoryInterface $adminRepository,
        private FacultyRepositoryInterface $facultyRepository,
        private DecryptParameterRepository $decryptParameterRepository
    ) {}

    public function index()
    {
        $admins = $this->adminRepository->getAllAdmins();

        return view('pages.superadmin.admin.index', compact('admins'));
    }

    public function create()
    {
        $faculties = $this->facultyRepository->getAllFaculties();

        return view('pages.superadmin.admin.create', compact('faculties'));
    }

    public function store(StoreAdminRequest $request)
    {
        $this->adminRepository->createAdmin($request->validated());

        toast(title: 'Data admin sukses ditambahkan', type: 'success')
            ->timerProgressBar();

        return redirect()->route('admin.admin.index');
    }

    public function show(string $id)
    {
        $admin = $this->adminRepository->getAdminById($id);

        return view('pages.superadmin.admin.show', compact('admin'));
    }

    public function edit(string $id)
    {
        $admin = $this->adminRepository->getAdminById($id);

        $faculties = $this->facultyRepository->getAllFaculties();

        return view('pages.superadmin.admin.edit', compact('admin', 'faculties'));
    }

    public function update(UpdateAdminRequest $request, string $adminId)
    {
        $this->adminRepository->updateAdmin($adminId, $request->validated());

        toast(title: 'Data admin sukses diupdate', type: 'success')
            ->timerProgressBar();

        return redirect()->route('admin.admin.index');
    }

    public function destroy(string $id)
    {
        $this->adminRepository->deleteAdminById($id);

        toast(title: 'Data admin sukses dihapus', type: 'success')
            ->timerProgressBar();

        return redirect()->route('admin.admin.index');
    }
}
