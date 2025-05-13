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

    public function getFaqById(string $faqId)
    {
        try {
            return Faq::findOrFail($faqId);
        } catch (\Throwable $th) {
            return abort(404);
        }
    }

    public function createFaq($data)
    {
        return Faq::create($data);
    }

    public function updateFaq(string $faqId, $data)
    {
        $faq = $this->getFaqById($faqId);

        return $faq->update($data);
    }

    public function deleteFaq(string $faqId)
    {
        return Faq::destroy($faqId);
    }
}
