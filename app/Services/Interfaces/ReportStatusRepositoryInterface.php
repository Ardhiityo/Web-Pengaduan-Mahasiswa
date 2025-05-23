<?php

namespace App\Services\Interfaces;

interface ReportStatusRepositoryInterface
{
    public function getAllReportStatuses();
    public function getReportStatusById(string $id);
    public function getReportStatusByResident(string $status);
    public function createReportStatus(array $data);
    public function updateReportStatus(string $id, array $data);
    public function deleteReportStatus(string $id);
    public function getActiveReportStatusByResident();
    public function getDoneReportStatusByResident();
}
