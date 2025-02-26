<?php

namespace App\Services\Repositories;

use App\Models\Faq;
use App\Services\Interfaces\FaqRepositoryInterface;

class FaqRepository implements FaqRepositoryInterface
{
    public function getAllFaqs()
    {
        return Faq::all();
    }
    public function getFaqById($faqId)
    {
        return Faq::findOrFail($faqId);
    }
    public function createFaq($data)
    {
        return Faq::create($data);
    }
    public function updateFaq($faqId, $data)
    {
        $faq = Faq::findOrFail($faqId);
        return $faq->update($data);
    }
    public function deleteFaq($faqId)
    {
        return Faq::destroy($faqId);
    }
}
