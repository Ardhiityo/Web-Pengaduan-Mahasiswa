<?php

namespace App\Services\Repositories;

use App\Models\Report;
use App\Models\ReportStatus;
use App\Models\ReportCategory;
use App\Models\StudyProgram;
use Symfony\Component\Uid\Ulid;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Services\Interfaces\ReportRepositoryInterface;
use Illuminate\Contracts\Database\Eloquent\Builder;

class ReportRepository implements ReportRepositoryInterface
{
    public function getAllReports()
    {
        $user = Auth::user();
        if ($user->hasRole('admin')) {
            $admin = $user->admins()->first();
            $studyProgramId = StudyProgram::where('faculty_id', $admin->faculty_id)
                ->pluck('id')->toArray();

            return Report::with([
                'resident' => function (Builder $query) {
                    $query->with(['user' => function (Builder $query) {
                        $query->select('id', 'name');
                    }])->select('id', 'user_id');
                },
                'reportCategory' => fn(Builder $query) => $query->select('id', 'name'),
                'studyProgram' =>  fn(Builder $query) => $query->select('id', 'name'),
            ])->whereIn('study_program_id', $studyProgramId)
                ->oldest()
                ->select('id', 'code', 'title', 'resident_id', 'report_category_id', 'study_program_id')
                ->get();
        } else if ($user->hasRole('superadmin')) {
            return Report::with([
                'resident' => function (Builder $query) {
                    $query->with(['user' => function (Builder $query) {
                        $query->select('id', 'name');
                    }])->select('id', 'user_id');
                },
                'reportCategory' => fn(Builder $query) => $query->select('id', 'name'),
                'studyProgram' =>  fn(Builder $query) => $query->select('id', 'name'),
            ])
                ->oldest()
                ->select('id', 'code', 'title', 'resident_id', 'report_category_id', 'study_program_id')
                ->get();
        }
    }

    public function getReportById(int $id)
    {
        return Report::select(
            'id',
            'code',
            'title',
            'description',
            'address',
            'image',
            'longitude',
            'latitude',
            'description',
            'resident_id',
            'report_category_id',
            'study_program_id'
        )->find($id)
            ->load([
                'studyProgram' => function (Builder $query) {
                    $query->select('id', 'name');
                },
                'reportCategory' => fn(Builder $query) => $query->select('id', 'name'),
                'resident' => function (Builder $query) {
                    $query->with(['user' => function (Builder $query) {
                        $query->select('id', 'name');
                    }])->select('id', 'user_id', 'nim');
                },
            ]);
    }

    public function getReportsByCategory(string $category)
    {
        return ReportCategory::with('reports', 'reportStatuses')
            ->where('name', $category)
            ->first();
    }

    public function latestReports()
    {
        return Report::with('reportStatuses')->latest()->take(3)->get();
    }

    public function createReport(array $data)
    {
        $data['code'] = (string) Ulid::generate();

        if (isset($data['image'])) {
            $data['image'] = $data['image']->store('assets/report', 'public');
        };

        $report = Report::create($data);
        $report->reportStatuses()->create([
            'status' => 'delivered',
            'description' => 'Laporanmu sudah kami terima'
        ]);

        return $report;
    }

    public function updateReport(array $data, int $id)
    {
        $report = $this->getReportById($id);

        if (isset($data['image'])) {
            if (!is_null($report->image)) {
                Storage::disk('public')->delete($report->image);
            }
            $data['image'] = $data['image']->store('assets/report', 'public');
        }

        return $report->update($data);
    }

    public function deleteReport(int $id)
    {
        $report = $this->getReportById($id);

        if ($report->reportStatuses->count()) {
            $reportStatuses = ReportStatus::where('report_id', $report->id)->get();
            foreach ($reportStatuses as $reportStatus) {
                if (!is_null($reportStatus->image)) {
                    Storage::disk('public')->delete($reportStatus->image);
                }
            }
        }
        $report->reportStatuses()->delete();

        if (!is_null($report->image)) {
            Storage::disk('public')->delete($report->image);
        }

        $report->delete();
    }
}
