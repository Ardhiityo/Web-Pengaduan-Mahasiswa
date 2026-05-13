<?php

namespace App\Services\Interfaces;

interface FaqRepositoryInterface
{
    public function getAllFaqs(int $per_page = 0, string $search = '');
    public function createFaq($data);
    public function getFaqById(string $faqId);
    public function updateFaq(string $faqId, $data);
    public function deleteFaq(string $faqId);
}
