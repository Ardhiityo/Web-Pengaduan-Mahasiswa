<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
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
        $decrypt = $this->decryptParameterRepository
            ->getData(
                id: $id,
                message: 'Ups, Kategori tidak ditemukan!',
                route: 'admin.report-category.index'
            );

        if ($decrypt instanceof RedirectResponse) return $decrypt;

        $reportCategory = $this->reportCategoryRepository->getReportCategoryById($decrypt);

        return view('pages.admin.category.show', compact('reportCategory'));
    }

    public function edit(string $id)
    {
        $decrypt = $this->decryptParameterRepository
            ->getData(
                id: $id,
                message: 'Ups, Kategori tidak ditemukan!',
                route: 'admin.report-category.index'
            );

        if ($decrypt instanceof RedirectResponse) return $decrypt;

        $reportCategory = $this->reportCategoryRepository->getReportCategoryById($decrypt);

        return view('pages.admin.category.edit', compact('reportCategory'));
    }

    public function update(UpdateReportCategoryRequest $request, string $id)
    {
        $decrypt = $this->decryptParameterRepository
            ->getData(
                id: $id,
                message: 'Ups, Kategori tidak ditemukan!',
                route: 'admin.report-category.index'
            );

        if ($decrypt instanceof RedirectResponse) return $decrypt;

        $this->reportCategoryRepository->updateReportCategory(data: $request->validated(), id: $decrypt);

        toast(title: 'Data kategori sukses diupdate', type: 'success')
            ->timerProgressBar();

        return redirect()->route('admin.report-category.index');
    }

    public function destroy(string $id)
    {
        $decrypt = $this->decryptParameterRepository
            ->getData(
                id: $id,
                message: 'Ups, Kategori tidak ditemukan!',
                route: 'admin.report-category.index'
            );

        if ($decrypt instanceof RedirectResponse) return $decrypt;

        if (!$this->reportCategoryRepository->deleteReportCategory($decrypt)) {

            toast('Pastikan data kategori yang hendak dihapus tidak terdapat pada data laporan', 'error')
                ->timerProgressBar();

            return redirect()->route('admin.report-category.index');
        }

        toast(title: 'Data kategori sukses dihapus', type: 'success')
            ->timerProgressBar();

        return redirect()->route('admin.report-category.index');
    }
}
