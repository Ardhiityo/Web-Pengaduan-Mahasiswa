<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Services\Interfaces\FaqRepositoryInterface;

class FaqController extends Controller
{
    public function __construct(private FaqRepositoryInterface $faqRepository) {}

    public function index()
    {
        $faqs = $this->faqRepository->getAllFaqs();
        return view('pages.app.faq', compact('faqs'));
    }
}
