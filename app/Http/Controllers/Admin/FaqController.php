<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Faq\StoreFaqRequest;
use App\Http\Requests\Faq\UpdateFaqRequest;
use App\Services\Interfaces\FaqRepositoryInterface;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    public function __construct(private FaqRepositoryInterface $faqRepository) {}

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
        $this->faqRepository->createFaq($request->validated());
        toast('Data FAQ sukses ditambahkan', 'success')->timerProgressBar();
        return redirect()->route('admin.faq.index');
    }

    public function show($faqId)
    {
        $faq = $this->faqRepository->getFaqById($faqId);
        return view('pages.admin.faq.show', compact('faq'));
    }

    public function edit($faqId)
    {
        $faq = $this->faqRepository->getFaqById($faqId);
        return view('pages.admin.faq.edit', compact('faq'));
    }

    public function update($faqId, UpdateFaqRequest $request)
    {
        $this->faqRepository->updateFaq($faqId, $request->validated());
        toast('Data FAQ sukses diupdate', 'success')->timerProgressBar();
        return redirect()->route('admin.faq.index');
    }

    public function destroy($faqId)
    {
        $this->faqRepository->deleteFaq($faqId);
        toast('Data FAQ sukses dihapus', 'success')->timerProgressBar();
        return redirect()->route('admin.faq.index');
    }
}
