<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\Faq\StoreFaqRequest;
use App\Http\Requests\Faq\UpdateFaqRequest;
use App\Services\Interfaces\FaqRepositoryInterface;
use App\Services\Interfaces\DecryptParameterRepositoryInterface;

class FaqController extends Controller
{
    public function __construct(
        private FaqRepositoryInterface $faqRepository,
        private DecryptParameterRepositoryInterface $decryptParameterRepository
    ) {}

    public function index()
    {
        $faqs = $this->faqRepository->getAllFaqs();

        return view('pages.admin.faq.index', compact('faqs'));
    }

    public function create()
    {
        return view('pages.admin.faq.create');
    }

    public function store(StoreFaqRequest $request)
    {
        $this->faqRepository->createFaq(data: $request->validated());

        toast(title: 'Data FAQ sukses ditambahkan', type: 'success')
            ->timerProgressBar();

        return redirect()->route('admin.faq.index');
    }

    public function show(string $faqId)
    {
        $decrypt = $this->decryptParameterRepository
            ->getData(
                id: $faqId,
                message: 'Ups, FAQ tidak ditemukan!',
                route: 'admin.faq.index'
            );

        if ($decrypt instanceof RedirectResponse) return $decrypt;

        $faq = $this->faqRepository->getFaqById(faqId: $decrypt);

        return view('pages.admin.faq.show', compact('faq'));
    }

    public function edit($faqId)
    {
        $decrypt = $this->decryptParameterRepository
            ->getData(
                id: $faqId,
                message: 'Ups, FAQ tidak ditemukan!',
                route: 'admin.faq.index'
            );

        if ($decrypt instanceof RedirectResponse) return $decrypt;

        $faq = $this->faqRepository->getFaqById(faqId: $decrypt);

        return view('pages.admin.faq.edit', compact('faq'));
    }

    public function update($faqId, UpdateFaqRequest $request)
    {
        $decrypt = $this->decryptParameterRepository
            ->getData(
                id: $faqId,
                message: 'Ups, FAQ tidak ditemukan!',
                route: 'admin.faq.index'
            );

        if ($decrypt instanceof RedirectResponse) return $decrypt;

        $this->faqRepository->updateFaq(faqId: $decrypt, data: $request->validated());

        toast(title: 'Data FAQ sukses diupdate', type: 'success')
            ->timerProgressBar();

        return redirect()->route('admin.faq.index');
    }

    public function destroy($faqId)
    {
        $decrypt = $this->decryptParameterRepository
            ->getData(
                id: $faqId,
                message: 'Ups, FAQ tidak ditemukan!',
                route: 'admin.faq.index'
            );

        if ($decrypt instanceof RedirectResponse) return $decrypt;

        $this->faqRepository->deleteFaq(faqId: $decrypt);

        toast(title: 'Data FAQ sukses dihapus', type: 'success')
            ->timerProgressBar();

        return redirect()->route('admin.faq.index');
    }
}
