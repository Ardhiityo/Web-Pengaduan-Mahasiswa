<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Faq\StoreFaqRequest;
use App\Http\Requests\Faq\UpdateFaqRequest;
use App\Services\Interfaces\FaqRepositoryInterface;
use App\Services\Interfaces\DecryptParameterRepositoryInterface;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class FaqController extends Controller
{
    public function __construct(
        private FaqRepositoryInterface $faqRepository,
        private DecryptParameterRepositoryInterface $decryptParameterRepository
    ) {}

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = $this->faqRepository->getAllFaqs();

            return DataTables::eloquent($query)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    return '
                        <a href="' . route('admin.faq.show', $row->id) . '" class="my-1 btn btn-info btn-sm">Show</a>
                        <a href="' . route('admin.faq.edit', $row->id) . '" class="my-1 btn btn-warning btn-sm">Edit</a>
                        <form action="' . route('admin.faq.destroy', $row->id) . '" method="POST" class="d-inline">
                            ' . csrf_field() . method_field('DELETE') . '
                            <button type="submit" class="my-1 btn btn-sm btn-danger">Delete</button>
                        </form>
                    ';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('pages.admin.faq.index');
    }

    public function create()
    {
        return view('pages.admin.faq.create');
    }

    public function store(StoreFaqRequest $request)
    {
        $this->faqRepository->createFaq(data: $request->validated());

        toast(title: 'Data FAQ sukses ditambahkan', type: 'success')
            ->timerProgressBar();

        return redirect()->route('admin.faq.index');
    }

    public function show(string $faqId)
    {
        $faq = $this->faqRepository->getFaqById(faqId: $faqId);

        return view('pages.admin.faq.show', compact('faq'));
    }

    public function edit($faqId)
    {
        $faq = $this->faqRepository->getFaqById(faqId: $faqId);

        return view('pages.admin.faq.edit', compact('faq'));
    }

    public function update(UpdateFaqRequest $request, $faqId)
    {
        $this->faqRepository->updateFaq(faqId: $faqId, data: $request->validated());

        toast(title: 'Data FAQ sukses diupdate', type: 'success')
            ->timerProgressBar();

        return redirect()->route('admin.faq.index');
    }

    public function destroy($faqId)
    {
        $this->faqRepository->deleteFaq(faqId: $faqId);

        toast(title: 'Data FAQ sukses dihapus', type: 'success')
            ->timerProgressBar();

        return redirect()->route('admin.faq.index');
    }
}
