<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Services\Interfaces\ReportCategoryRepositoryInterface;
use App\Http\Requests\ReportCategory\StoreReportCategoryRequest;
use App\Services\Interfaces\DecryptParameterRepositoryInterface;
use App\Http\Requests\ReportCategory\UpdateReportCategoryRequest;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ReportCategoryController extends Controller
{
    public function __construct(
        private ReportCategoryRepositoryInterface $reportCategoryRepository,
        private DecryptParameterRepositoryInterface $decryptParameterRepository
    ) {}

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = $this->reportCategoryRepository->getAllReportCategories();

            return DataTables::eloquent($query)
                ->addIndexColumn()
                ->addColumn('image', function ($row) {
                    if ($row->image) {
                        return '<img src="' . asset('storage/' . $row->image) . '" alt="image" width="60">';
                    }
                    return '-';
                })
                ->addColumn('action', function ($row) {
                    return '
                        <a href="' . route('admin.report-category.show', $row->id) . '" class="my-1 btn btn-sm btn-info">Show</a>
                        <a href="' . route('admin.report-category.edit', $row->id) . '" class="my-1 btn btn-sm btn-warning">Edit</a>
                        <form action="' . route('admin.report-category.destroy', $row->id) . '" method="POST" class="d-inline">
                            ' . csrf_field() . method_field('DELETE') . '
                            <button type="submit" class="my-1 btn btn-sm btn-danger">Delete</button>
                        </form>
                    ';
                })
                ->rawColumns(['image', 'action'])
                ->make(true);
        }

        return view('pages.admin.category.index');
    }

    public function create()
    {
        return view('pages.admin.category.create');
    }

    public function store(StoreReportCategoryRequest $request)
    {
        $this->reportCategoryRepository->createReportCategory(data: $request->validated());

        toast(title: 'Data kategori sukses ditambahkan', type: 'success')
            ->timerProgressBar();

        return redirect()->route('admin.report-category.index');
    }

    public function show(string $id)
    {
        $reportCategory = $this->reportCategoryRepository->getReportCategoryById($id);

        return view('pages.admin.category.show', compact('reportCategory'));
    }

    public function edit(string $id)
    {
        $reportCategory = $this->reportCategoryRepository->getReportCategoryById($id);

        return view('pages.admin.category.edit', compact('reportCategory'));
    }

    public function update(UpdateReportCategoryRequest $request, string $id)
    {
        $this->reportCategoryRepository->updateReportCategory($id, $request->validated());

        toast(title: 'Data kategori sukses diupdate', type: 'success')
            ->timerProgressBar();

        return redirect()->route('admin.report-category.index');
    }

    public function destroy(string $id)
    {
        $this->reportCategoryRepository->deleteReportCategory($id);

        toast(title: 'Data kategori sukses dihapus', type: 'success')
            ->timerProgressBar();

        return redirect()->route('admin.report-category.index');
    }
}
