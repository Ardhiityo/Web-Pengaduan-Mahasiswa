<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Resident\StoreResidentRequest;
use App\Http\Requests\Resident\UpdateResidentRequest;
use App\Services\Interfaces\ResidentRepositoryInterface;

class ResidentController extends Controller
{
    public function __construct(private ResidentRepositoryInterface $residentRepository) {}

    public function index()
    {
        $residents = $this->residentRepository->getAllResidents();
        return view('pages.admin.resident.index', compact('residents'));
    }

    public function create()
    {
        return view('pages.admin.resident.create');
    }

    public function store(StoreResidentRequest $request)
    {
        $data = $request->validated();
        $this->residentRepository->createResident($data);
        toast('Data masyarakat sukses ditambahkan', 'success')->timerProgressBar();
        return redirect()->route('admin.resident.index');
    }

    public function show(string $id)
    {
        $resident = $this->residentRepository->getResidentById($id);
        return view('pages.admin.resident.show', compact('resident'));
    }

    public function edit(string $id)
    {
        $resident = $this->residentRepository->getResidentById($id);
        return view('pages.admin.resident.edit', compact('resident'));
    }

    public function update(UpdateResidentRequest $request, string $id)
    {
        $data = $request->validated();
        $this->residentRepository->updateResident(data: $data, id: $id);
        toast('Data masyarakat sukses diupdate', 'success')->timerProgressBar();
        return redirect()->route('admin.resident.index');
    }

    public function destroy(string $id)
    {
        $this->residentRepository->deleteResident($id);
        toast('Data masyarakat sukses dihapus', 'success')->timerProgressBar();
        return redirect()->route('admin.resident.index');
    }
}
