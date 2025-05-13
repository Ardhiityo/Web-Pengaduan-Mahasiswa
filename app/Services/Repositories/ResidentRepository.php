<?php

namespace App\Services\Repositories;

use App\Models\User;
use App\Models\Resident;
use App\Models\StudyProgram;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\Database\Eloquent\Builder;
use App\Services\Interfaces\ResidentRepositoryInterface;

class ResidentRepository implements ResidentRepositoryInterface
{
    public function getAllResidents()
    {
        $user = Auth::user();

        if ($user->hasRole('admin')) {
            $facultyIds = $user->faculties()->pluck('faculty_id');
            $studyProgramIds = StudyProgram::whereIn('faculty_id', $facultyIds)->pluck('id');

            return Resident::with([
                'studyProgram' => fn(Builder $query) => $query
                    ->with('faculty', fn(Builder $query) => $query->select('id', 'name'))
                    ->select('id', 'name', 'faculty_id'),
                'user' => fn(Builder $query) => $query->select('id', 'name', 'email')
            ])
                ->whereIn('study_program_id', $studyProgramIds)
                ->select('id', 'nim', 'user_id', 'study_program_id', 'avatar')
                ->get();
        } else if ($user->hasRole('superadmin')) {
            return Resident::with('studyProgram')
                ->select('id', 'nim', 'user_id', 'study_program_id', 'avatar')
                ->get();
        }
    }

    public function getResidentById(string $id)
    {
        try {
            return Resident::with([
                'user' => fn(Builder $query) => $query->select('id', 'name', 'email', 'password'),
                'studyProgram' => fn(Builder $query) => $query->select('id', 'name')
            ])
                ->select('id', 'nim', 'user_id', 'study_program_id', 'avatar')
                ->findOrFail($id);
        } catch (\Throwable $th) {
            return abort(404);
        }
    }

    public function createResident(array $data)
    {
        $user = User::create($data);

        $user->assignRole('resident');

        $user->resident()->create($data);

        return $user;
    }

    public function updateResident(string $id, array $data)
    {
        $resident = $this->getResidentById($id);

        is_null($data['password']) ? $data['password'] = $resident->user->password : $data['password'] = Hash::make($data['password']);

        $resident->user()->update([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password'],
        ]);

        if (isset($data['avatar'])) {
            //delete old photo profile
            if ($resident->avatar) {
                Storage::disk('public')->delete($resident->avatar);
            }
            //save new photo profile
            $data['avatar'] = $data['avatar']->store('assets/avatar', 'public');
        }

        $resident->update($data);
    }

    public function deleteResident(string $id)
    {
        $resident = $this->getResidentById($id);

        if ($resident->avatar) {
            Storage::disk('public')->delete($resident->avatar);
        }

        return $resident->user->delete();
    }
}
