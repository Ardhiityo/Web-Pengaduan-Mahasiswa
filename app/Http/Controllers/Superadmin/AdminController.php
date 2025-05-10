<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\Superadmin\StoreAdminRequest;
use App\Http\Requests\Superadmin\UpdateAdminRequest;
use App\Services\Interfaces\AdminRepositoryInterface;
use App\Services\Interfaces\FacultyRepositoryInterface;
use App\Services\Repositories\DecryptParameterRepository;

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
        $decrypt = $this->decryptParameterRepository
            ->getData(
                id: $id,
                message: 'Ups, Admin tidak ditemukan!',
                route: 'admin.report.index'
            );

        if ($decrypt instanceof RedirectResponse) return $decrypt;

        $admin = $this->adminRepository->getAdminById($decrypt);

        return view('pages.superadmin.admin.show', compact('admin'));
    }

    public function edit(string $id)
    {
        $decrypt = $this->decryptParameterRepository
            ->getData(
                id: $id,
                message: 'Ups, Admin tidak ditemukan!',
                route: 'admin.admin.index'
            );
        if ($decrypt instanceof RedirectResponse) return $decrypt;

        $admin = $this->adminRepository->getAdminById($decrypt);

        $faculties = $this->facultyRepository->getAllFaculties();

        return view('pages.superadmin.admin.edit', compact('admin', 'faculties'));
    }

    public function update(UpdateAdminRequest $request, string $id)
    {
        $decrypt = $this->decryptParameterRepository
            ->getData(
                id: $id,
                message: 'Ups, Admin tidak ditemukan!',
                route: 'admin.admin.index'
            );

        if ($decrypt instanceof RedirectResponse) return $decrypt;

        $this->adminRepository->updateAdmin($decrypt, $request->validated());

        toast(title: 'Data admin sukses diupdate', type: 'success')
            ->timerProgressBar();

        return redirect()->route('admin.admin.index');
    }

    public function destroy(string $id)
    {
        $decrypt = $this->decryptParameterRepository
            ->getData(
                id: $id,
                message: 'Ups, Admin tidak ditemukan!',
                route: 'admin.admin.index'
            );
        if ($decrypt instanceof RedirectResponse) return $decrypt;

        $this->adminRepository->deleteAdminById($decrypt);

        toast(title: 'Data admin sukses dihapus', type: 'success')
            ->timerProgressBar();

        return redirect()->route('admin.admin.index');
    }
}
