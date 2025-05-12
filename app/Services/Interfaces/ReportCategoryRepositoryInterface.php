<?php

namespace App\Services\Interfaces;

interface ReportCategoryRepositoryInterface
{
    public function getAllReportCategories();
    public function getReportCategoryById(string $id);
    public function createReportCategory(array $data);
    public function updateReportCategory(string $id, array $data);
    public function deleteReportCategory(string $id);
}
