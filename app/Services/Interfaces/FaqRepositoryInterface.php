<?php

namespace App\Services\Interfaces;

interface FaqRepositoryInterface
{
    public function getAllFaqs();
    public function createFaq($data);
    public function getFaqById(int $faqId);
    public function updateFaq(int $faqId, $data);
    public function deleteFaq(int $faqId);
}
