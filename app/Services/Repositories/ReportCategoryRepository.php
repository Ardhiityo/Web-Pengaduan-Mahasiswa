<?php

namespace App\Services\Repositories;

use App\Models\ReportCategory;
use Illuminate\Support\Facades\Storage;
use App\Services\Interfaces\ReportCategoryRepositoryInterface;

class ReportCategoryRepository implements ReportCategoryRepositoryInterface
{
    public function getAllReportCategories(int $per_page = 0, string $search = '')
    {
        $query = ReportCategory::select('id', 'name', 'image')
            ->when($search, function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%');
            });

        return $per_page > 0 ? $query->paginate(perPage: $per_page) : $query->get();
    }
    public function getReportCategoryById(string $id)
    {
        try {
            return ReportCategory::findOrFail($id);
        } catch (\Throwable $th) {
            return abort(404);
        }
    }

    public function createReportCategory(array $data)
    {
        $data['image'] = $data['image']->store('assets/category', 'public');

        return ReportCategory::create($data);
    }

    public function updateReportCategory(string $id, array $data)
    {
        $reportCategory = $this->getReportCategoryById($id);

        if (isset($data['image'])) {
            if ($reportCategory->image) {
                Storage::disk('public')->delete($reportCategory->image);
            }
            $data['image'] = $data['image']->store('assets/category', 'public');
        }

        return $reportCategory->update($data);
    }

    public function deleteReportCategory(string $id)
    {
        $reportCategory = $this->getReportCategoryById($id);

        if ($reportCategory->image) {
            Storage::disk('public')->delete($reportCategory->image);
        }

        return $reportCategory->delete();
    }
}
