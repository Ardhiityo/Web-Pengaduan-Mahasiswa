<?php

namespace App\Services\Interfaces;

interface FaqRepositoryInterface
{
    public function getAllFaqs();
    public function createFaq($data);
    public function getFaqById($faqId);
    public function updateFaq($faqId, $data);
    public function deleteFaq($faqId);
}
