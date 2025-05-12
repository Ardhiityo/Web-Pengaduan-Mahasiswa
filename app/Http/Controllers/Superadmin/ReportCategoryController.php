<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Services\Interfaces\ReportCategoryRepositoryInterface;
use App\Http\Requests\ReportCategory\StoreReportCategoryRequest;
use App\Services\Interfaces\DecryptParameterRepositoryInterface;
use App\Http\Requests\ReportCategory\UpdateReportCategoryRequest;

class ReportCategoryController extends Controller
{
    public function __construct(
        private ReportCategoryRepositoryInterface $reportCategoryRepository,
        private DecryptParameterRepositoryInterface $decryptParameterRepository
    ) {}

    public function index()
    {
        $reportCategories = $this->reportCategoryRepository->getAllReportCategories();

        return view('pages.admin.category.index', compact('reportCategories'));
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
