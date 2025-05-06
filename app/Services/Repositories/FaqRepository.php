<?php

namespace App\Services\Repositories;

use App\Models\Faq;
use App\Services\Interfaces\FaqRepositoryInterface;

class FaqRepository implements FaqRepositoryInterface
{
    public function getAllFaqs()
    {
        return Faq::select('id', 'title', 'description')->get();
    }
    public function getFaqById(int $faqId)
    {
        return Faq::find($faqId);
    }
    public function createFaq($data)
    {
        return Faq::create($data);
    }
    public function updateFaq(int $faqId, $data)
    {
        $faq = Faq::find($faqId);

        return $faq->update($data);
    }
    public function deleteFaq(int $faqId)
    {
        return Faq::destroy($faqId);
    }
}
