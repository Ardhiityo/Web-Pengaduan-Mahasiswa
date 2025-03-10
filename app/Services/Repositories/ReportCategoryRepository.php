<?php

namespace App\Services\Repositories;

use App\Models\ReportCategory;
use App\Services\Interfaces\ReportCategoryRepositoryInterface;

class ReportCategoryRepository implements ReportCategoryRepositoryInterface
{
    public function getAllReportCategories()
    {
        return ReportCategory::all();
    }
    public function getReportCategoryById(int $id)
    {
        return ReportCategory::findOrFail($id);
    }

    public function createReportCategory(array $data)
    {
        $data['image'] = $data['image']->store('assets/report-category', 'public');
        return ReportCategory::create($data);
    }

    public function updateReportCategory(array $data, int $id)
    {
        $reportCategory = $this->getReportCategoryById($id);
        if (isset($data['image'])) {
            $data['image'] = $data['image']->store('assets/report-category/image', 'public');
        }
        if (!isset($data['name'])) {
            $data['name'] = $reportCategory->name;
        }
        return $reportCategory->update($data);
    }

    public function deleteReportCategory(int $id)
    {
        $reportCategory = $this->getReportCategoryById($id);
        if ($reportCategory->reports()->count() >= 1) {
            return false;
        } else {
            $reportCategory->delete();
            return true;
        }
    }
}
