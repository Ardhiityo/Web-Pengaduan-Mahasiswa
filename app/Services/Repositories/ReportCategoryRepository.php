<?php

namespace App\Services\Repositories;

use App\Models\ReportCategory;
use Illuminate\Support\Facades\Storage;
use App\Services\Interfaces\ReportCategoryRepositoryInterface;

class ReportCategoryRepository implements ReportCategoryRepositoryInterface
{
    public function getAllReportCategories()
    {
        return ReportCategory::select('id', 'name', 'image')->get();
    }
    public function getReportCategoryById(int $id)
    {
        return ReportCategory::find($id);
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
            if (!is_null($reportCategory->image)) {
                Storage::disk('public')->delete($reportCategory->image);
            }
            $data['image'] = $data['image']->store('assets/report-category', 'public');
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
            if (!is_null($reportCategory->image)) {
                Storage::disk('public')->delete($reportCategory->image);
            }
            $reportCategory->delete();

            return true;
        }
    }
}
