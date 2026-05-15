<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Services\Interfaces\AdminRepositoryInterface;
use App\Services\Interfaces\FacultyRepositoryInterface;
use App\Http\Requests\Superadmin\Admin\StoreAdminRequest;
use App\Services\Repositories\DecryptParameterRepository;
use App\Http\Requests\Superadmin\Admin\UpdateAdminRequest;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class AdminController extends Controller
{

    public function __construct(
        private AdminRepositoryInterface $adminRepository,
        private FacultyRepositoryInterface $facultyRepository,
        private DecryptParameterRepository $decryptParameterRepository
    ) {}

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = $this->adminRepository->getAllAdmins();

            return DataTables::eloquent($query)
                ->addIndexColumn()
                ->addColumn('faculties', fn($row) => $row->faculties->pluck('name')->implode(', ') ?: '-')
                ->addColumn('action', function ($row) {
                    return '
                        <a href="' . route('admin.admin.show', $row->id) . '" class="my-1 btn btn-info btn-sm">Show</a>
                        <a href="' . route('admin.admin.edit', $row->id) . '" class="my-1 btn btn-warning btn-sm">Edit</a>
                        <form action="' . route('admin.admin.destroy', $row->id) . '" method="POST" class="d-inline">
                            ' . csrf_field() . method_field('DELETE') . '
                            <button type="submit" class="my-1 btn btn-sm btn-danger">Delete</button>
                        </form>
                    ';
                })
                ->filterColumn('faculties', fn($query, $keyword) =>
                    $query->whereHas('faculties', fn($q) => $q->where('name', 'like', "%{$keyword}%"))
                )
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('pages.superadmin.admin.index');
    }

    public function create()
    {
        $faculties = $this->facultyRepository->getAllFaculties()->get();

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

        $faculties = $this->facultyRepository->getAllFaculties()->get();

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
