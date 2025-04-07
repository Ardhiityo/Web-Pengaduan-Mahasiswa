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
        $data = $request->validated();
        $this->reportCategoryRepository->createReportCategory($data);
        toast('Data kategori sukses ditambahkan', 'success')->timerProgressBar();

        return redirect()->route('admin.report-category.index');
    }

    public function show(string $id)
    {
        $decrypt = $this->decryptParameterRepository->getData(id: $id, message: 'Ups, Kategori tidak ditemukan!', route: 'admin.report-category.index');

        if ($decrypt instanceof RedirectResponse) return $decrypt;

        $reportCategory = $this->reportCategoryRepository->getReportCategoryById($decrypt);

        return view('pages.admin.category.show', compact('reportCategory'));
    }

    public function edit(string $id)
    {
        $decrypt = $this->decryptParameterRepository->getData(id: $id, message: 'Ups, Kategori tidak ditemukan!', route: 'admin.report-category.index');

        if ($decrypt instanceof RedirectResponse) return $decrypt;

        $reportCategory = $this->reportCategoryRepository->getReportCategoryById($decrypt);

        return view('pages.admin.category.edit', compact('reportCategory'));
    }

    public function update(UpdateReportCategoryRequest $request, string $id)
    {
        $data = $request->validated();

        $decrypt = $this->decryptParameterRepository->getData(id: $id, message: 'Ups, Kategori tidak ditemukan!', route: 'admin.report-category.index');

        if ($decrypt instanceof RedirectResponse) return $decrypt;

        $this->reportCategoryRepository->updateReportCategory($data, $decrypt);
        toast('Data kategori sukses diupdate', 'success')->timerProgressBar();

        return redirect()->route('admin.report-category.index');
    }

    public function destroy(string $id)
    {
        $decrypt = $this->decryptParameterRepository->getData(id: $id, message: 'Ups, Kategori tidak ditemukan!', route: 'admin.report-category.index');

        if ($decrypt instanceof RedirectResponse) return $decrypt;

        if (!$this->reportCategoryRepository->deleteReportCategory($decrypt)) {
            toast('Pastikan data kategori yang hendak dihapus tidak terdapat pada data laporan', 'error')->timerProgressBar();
            return redirect()->route('admin.report-category.index');
        }
        toast('Data kategori sukses dihapus', 'success')->timerProgressBar();

        return redirect()->route('admin.report-category.index');
    }
}
