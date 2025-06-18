<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
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
        $faq = $this->faqRepository->getFaqById(faqId: $faqId);

        return view('pages.admin.faq.show', compact('faq'));
    }

    public function edit($faqId)
    {
        $faq = $this->faqRepository->getFaqById(faqId: $faqId);

        return view('pages.admin.faq.edit', compact('faq'));
    }

    public function update(UpdateFaqRequest $request, $faqId)
    {
        $this->faqRepository->updateFaq(faqId: $faqId, data: $request->validated());

        toast(title: 'Data FAQ sukses diupdate', type: 'success')
            ->timerProgressBar();

        return redirect()->route('admin.faq.index');
    }

    public function destroy($faqId)
    {
        $this->faqRepository->deleteFaq(faqId: $faqId);

        toast(title: 'Data FAQ sukses dihapus', type: 'success')
            ->timerProgressBar();

        return redirect()->route('admin.faq.index');
    }
}
