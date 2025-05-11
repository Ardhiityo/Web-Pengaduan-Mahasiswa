<?php

namespace App\Services\Repositories;

use App\Models\User;
use App\Models\Admin;
use App\Models\Resident;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Services\Interfaces\ResidentRepositoryInterface;

class ResidentRepository implements ResidentRepositoryInterface
{
    public function getAllResidents()
    {
        $user = Auth::user();

        if ($user->hasRole('admin')) {
            $admin = Admin::with('faculty')->where('user_id', $user->id)->first();
            $studyProgramId = $admin->faculty->studyPrograms->pluck('id')->toArray();

            return Resident::with('studyProgram')
                ->whereIn('study_program_id', $studyProgramId)
                ->select('nim', 'user_id', 'study_program_id', 'avatar')
                ->get();
        } else if ($user->hasRole('superadmin')) {
            return Resident::with('studyProgram')
                ->select('nim', 'user_id', 'study_program_id', 'avatar')
                ->get();
        }
    }

    public function getResidentById(int $id)
    {
        return Resident::findOrFail($id);
    }

    public function createResident(array $data)
    {
        $user = User::create($data);

        $user->assignRole('resident');

        $user->resident()->create($data);

        return $user;
    }

    public function updateResident(array $data, int $id)
    {
        $resident = $this->getResidentById($id);

        $resident->user()->update([
            'name' => $data['name'],
            'password' => isset($data['password']) ?
                $data['password'] : $resident->user->password
        ]);

        if (isset($data['avatar'])) {
            //delete old photo profile
            if (Storage::disk('public')->exists($resident->avatar)) {
                Storage::disk('public')->delete($resident->avatar);
            }
            //save new photo profile
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
            if (!is_null($resident->avatar)) {
                Storage::disk('public')->delete($resident->avatar);
            }
            $resident->delete();
            $resident->user()->delete();
            return true;
        }
    }
}
