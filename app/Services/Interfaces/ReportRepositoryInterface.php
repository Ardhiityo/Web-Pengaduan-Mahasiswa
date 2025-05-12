<?php

namespace App\Services\Interfaces;

interface ReportRepositoryInterface
{
    public function getAllReports();
    public function latestReports();
    public function getReportsByCategory(string $category);
    public function getReportById(string $id);
    public function createReport(array $data);
    public function updateReport(array $data, int $id);
    public function deleteReport(int $id);
}
