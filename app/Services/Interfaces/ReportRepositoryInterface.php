<?php

namespace App\Services\Interfaces;

interface ReportRepositoryInterface
{
    public function getAllReports(int $per_page = 0, string $search = '');
    public function latestReports();
    public function getReportsByCategory(string $category);
    public function getReportById(string $id);
    public function createReport(array $data);
    public function updateReport(string $id, array $data);
    public function deleteReport(string $id);
}
