<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Report\StoreReportRequest;
use App\Http\Requests\Report\UpdateReportRequest;
use App\Services\Interfaces\ReportRepositoryInterface;
use App\Services\Interfaces\ResidentRepositoryInterface;
use App\Services\Interfaces\ReportCategoryRepositoryInterface;
use App\Services\Interfaces\StudyProgramRepositoryInterface;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ReportController extends Controller
{
    public function __construct(
        private ReportRepositoryInterface $reportRepository,
        private ResidentRepositoryInterface $residentRepository,
        private ReportCategoryRepositoryInterface $reportCategoryRepository,
        private StudyProgramRepositoryInterface $studyProgramRepository
    ) {}

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = $this->reportRepository->getAllReports();

            return DataTables::eloquent($query)
                ->addIndexColumn()
                ->addColumn('resident_name', fn($row) => $row->resident->user->name ?? '-')
                ->addColumn('category_name', fn($row) => $row->reportCategory->name ?? '-')
                ->addColumn('study_program_name', fn($row) => $row->studyProgram->name ?? '-')
                ->addColumn('action', function ($row) {
                    return '
                        <a href="' . route('admin.report.show', $row->id) . '" class="my-1 btn btn-sm btn-info">Show</a>
                        <a href="' . route('admin.report.edit', $row->id) . '" class="my-1 btn btn-sm btn-warning">Edit</a>
                        <form action="' . route('admin.report.destroy', $row->id) . '" method="POST" class="d-inline">
                            ' . csrf_field() . method_field('DELETE') . '
                            <button type="submit" class="my-1 btn btn-sm btn-danger">Delete</button>
                        </form>
                    ';
                })
                ->filterColumn('resident_name', fn($query, $keyword) =>
                    $query->whereHas('resident.user', fn($q) => $q->where('name', 'like', "%{$keyword}%"))
                )
                ->filterColumn('category_name', fn($query, $keyword) =>
                    $query->whereHas('reportCategory', fn($q) => $q->where('name', 'like', "%{$keyword}%"))
                )
                ->filterColumn('study_program_name', fn($query, $keyword) =>
                    $query->whereHas('studyProgram', fn($q) => $q->where('name', 'like', "%{$keyword}%"))
                )
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('pages.admin.report.index');
    }

    public function create()
    {
        $residents = $this->residentRepository->getAllResidents()->get();

        $reportCategories = $this->reportCategoryRepository->getAllReportCategories()->get();

        $studyPrograms = $this->studyProgramRepository->getAllStudyPrograms();

        return view('pages.admin.report.create', compact('residents', 'reportCategories', 'studyPrograms'));
    }

    public function store(StoreReportRequest $request)
    {
        $this->reportRepository->createReport($request->validated());

        toast(title: 'Data laporan sukses ditambahkan', type: 'success')
            ->timerProgressBar();

        return redirect()->route('admin.report.index');
    }

    public function show(string $id)
    {
        $report = $this->reportRepository->getReportById($id);

        return view('pages.admin.report.show', compact('report'));
    }

    public function edit(string $id)
    {
        $report = $this->reportRepository->getReportById($id);

        $residents = $this->residentRepository->getAllResidents()->get();

        $reportCategories = $this->reportCategoryRepository->getAllReportCategories()->get();

        $studyPrograms = $this->studyProgramRepository->getAllStudyPrograms();

        return view('pages.admin.report.edit', compact('report', 'residents', 'reportCategories', 'studyPrograms'));
    }

    public function update(UpdateReportRequest $request, string $id)
    {
        $this->reportRepository->updateReport($id, $request->validated());

        toast(title: 'Data laporan sukses diupdate', type: 'success')
            ->timerProgressBar();

        return redirect()->route('admin.report.index');
    }

    public function destroy(string $id)
    {
        $this->reportRepository->deleteReport($id);

        toast(title: 'Data laporan sukses dihapus', type: 'success')
            ->timerProgressBar();

        return redirect()->route('admin.report.index');
    }
}
