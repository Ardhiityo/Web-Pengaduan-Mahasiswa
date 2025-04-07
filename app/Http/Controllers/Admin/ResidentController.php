<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\Resident\StoreResidentRequest;
use App\Http\Requests\Resident\UpdateResidentRequest;
use App\Services\Interfaces\DecryptParameterRepositoryInterface;
use App\Services\Interfaces\ResidentRepositoryInterface;

class ResidentController extends Controller
{
    public function __construct(
        private ResidentRepositoryInterface $residentRepository,
        private DecryptParameterRepositoryInterface $decryptParameterRepository
    ) {}

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
        toast('Data mahasiswa sukses ditambahkan', 'success')->timerProgressBar();

        return redirect()->route('admin.resident.index');
    }

    public function show(string $id)
    {
        $decrypt = $this->decryptParameterRepository->getData(id: $id, message: 'Ups, Mahasiswa tidak ditemukan!', route: 'admin.resident.index');

        if ($decrypt instanceof RedirectResponse) return $decrypt;

        $resident = $this->residentRepository->getResidentById($decrypt);

        return view('pages.admin.resident.show', compact('resident'));
    }

    public function edit(string $id)
    {
        $decrypt = $this->decryptParameterRepository->getData(id: $id, message: 'Ups, Mahasiswa tidak ditemukan!', route: 'admin.resident.index');

        if ($decrypt instanceof RedirectResponse) return $decrypt;

        $resident = $this->residentRepository->getResidentById($decrypt);

        return view('pages.admin.resident.edit', compact('resident'));
    }

    public function update(UpdateResidentRequest $request, string $id)
    {
        $decrypt = $this->decryptParameterRepository->getData(id: $id, message: 'Ups, Mahasiswa tidak ditemukan!', route: 'admin.resident.index');

        if ($decrypt instanceof RedirectResponse) return $decrypt;

        $data = $request->validated();
        $this->residentRepository->updateResident(data: $data, id: $decrypt);
        toast('Data mahasiswa sukses diupdate', 'success')->timerProgressBar();

        return redirect()->route('admin.resident.index');
    }

    public function destroy(string $id)
    {
        $decrypt = $this->decryptParameterRepository->getData(id: $id, message: 'Ups, Mahasiswa tidak ditemukan!', route: 'admin.resident.index');

        if ($decrypt instanceof RedirectResponse) return $decrypt;

        if (!$this->residentRepository->deleteResident($decrypt)) {
            toast('Gagal dihapus! Pastikan data mahasiswa yang hendak dihapus tidak memiliki laporan', 'error')->timerProgressBar();

            return redirect()->route('admin.resident.index');
        }
        toast('Data mahasiswa sukses dihapus', 'success')->timerProgressBar();

        return redirect()->route('admin.resident.index');
    }
}
