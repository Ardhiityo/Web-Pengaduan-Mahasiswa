<?php

namespace App\Services\Repositories;

use App\Models\User;
use App\Models\Resident;
use Illuminate\Support\Facades\Hash;
use App\Services\Interfaces\ResidentRepositoryInterface;

class ResidentRepository implements ResidentRepositoryInterface
{

    public function getAllResidents()
    {
        return Resident::all();
    }

    public function getResidentById(int $id)
    {
        return Resident::find($id);
    }

    public function createResident(array $data)
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password'])
        ])->assignRole('resident');
        return $user->resident()->create($data);
    }

    public function updateResident(array $data, int $id)
    {
        $resident = $this->getResidentById($id);
        $resident->user()->update([
            'name' => $data['name'],
            'password' => isset($data['password']) ?
                Hash::make($data['password']) : $resident->user->password
        ]);
        if (isset($data['avatar'])) {
            $data['avatar'] = $data['avatar']->store('assets/avatar', 'public');
        }
        return $resident->update($data);
    }

    public function deleteResident(int $id)
    {
        $resident = $this->getResidentById($id);
        if ($resident->reports()->count() >= 1) {
            return false;
        } else {
            $resident->user()->delete();
            $resident->delete();
            return true;
        }
    }
}
