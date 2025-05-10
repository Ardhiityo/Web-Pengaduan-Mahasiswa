<?php

namespace App\Http\Controllers\Superadmin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Superadmin\StoreAdminRequest;
use App\Services\Interfaces\AdminRepositoryInterface;
use App\Services\Interfaces\FacultyRepositoryInterface;

class AdminController extends Controller
{

    public function __construct(
        private AdminRepositoryInterface $adminRepository,
        private FacultyRepositoryInterface $facultyRepository
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
        //
    }
}
