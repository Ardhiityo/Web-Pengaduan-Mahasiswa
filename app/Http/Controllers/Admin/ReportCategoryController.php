<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Interfaces\ReportCategoryRepositoryInterface;
use App\Http\Requests\ReportCategory\StoreReportCategoryRequest;
use App\Http\Requests\ReportCategory\UpdateReportCategoryRequest;

class ReportCategoryController extends Controller
{
    public function __construct(private ReportCategoryRepositoryInterface $reportCategoryRepository) {}

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
        $data = $request->validated();
        $this->reportCategoryRepository->createReportCategory($data);
        toast('Data kategori sukses ditambahkan', 'success')->timerProgressBar();
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
        $data = $request->validated();
        $this->reportCategoryRepository->updateReportCategory($data, $id);
        toast('Data kategori sukses diupdate', 'success')->timerProgressBar();
        return redirect()->route('admin.report-category.index');
    }

    public function destroy(string $id)
    {
        if (!$this->reportCategoryRepository->deleteReportCategory($id)) {
            alert()->error('Gagal dihapus!', 'Pastikan data kategori yang hendak dihapus tidak terdapat pada data laporan');
            return redirect()->route('admin.report-category.index');
        }
        toast('Data kategori sukses dihapus', 'success')->timerProgressBar();
        return redirect()->route('admin.report-category.index');
    }
}
