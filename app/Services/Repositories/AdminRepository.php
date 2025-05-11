<?php

namespace App\Services\Repositories;

use App\Models\User;
use App\Models\Admin;
use Illuminate\Support\Facades\Log;
use Illuminate\Contracts\Database\Eloquent\Builder;
use App\Services\Interfaces\AdminRepositoryInterface;

class AdminRepository implements AdminRepositoryInterface
{
    public function updateAdmin($id, $data)
    {
        $admin = $this->getAdminById($id);

        is_null($data['password']) ?
            $data['password'] = $admin->user->password : $data['password'];

        $admin->user->update($data);
        $admin->update($data);
    }

    public function getAllAdmins()
    {
        return User::role('admin')
            ->select('id', 'name', 'email')  // tambahkan id karena diperlukan untuk relasi
            ->with([
                'faculties' => function (Builder $query) {
                    $query->select('faculties.id', 'faculties.name', 'admin_faculty.user_id')
                        ->withPivot(['user_id']);  // jika perlu data dari tabel pivot
                }
            ])
            ->get();
    }

    public function createAdmin(array $data)
    {
        $user = User::create($data);

        $user->assignRole('admin');

        $user->faculties()->attach($data['faculty_id']);

        return $user;
    }

    public function getAdminById($id)
    {
        try {
            return User::with([
                'faculties' => function (Builder $query) {
                    $query->select('id', 'name');
                },
            ])
                ->select('id', 'name', 'email')
                ->findOrFail($id);
        } catch (\Throwable $th) {
            Log::info($th->getMessage());
            return abort(404, 'Admin not found');
        }
    }

    public function deleteAdminById($id)
    {
        try {
            $admin = User::findOrFail($id);
            return $admin->delete();
        } catch (\Throwable $th) {
            return abort(404, 'Admin not found');
        }
    }

    public function addAdminFaculty(array $data)
    {
        try {
            $admin = User::findOrFail($data['user_id']);
            return $admin->faculties()->attach($data['faculty_id']);
        } catch (\Throwable $th) {
            return abort(404, 'Admin not found');
        }
    }

    public function deleteAdminFaculty($adminId, $facultyId)
    {
        try {
            return User::findOrFail($adminId)->faculties()->detach($facultyId);
        } catch (\Throwable $th) {
            return abort(404, 'Admin not found');
        }
    }
}
