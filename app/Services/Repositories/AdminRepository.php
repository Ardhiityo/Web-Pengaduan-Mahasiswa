<?php

namespace App\Services\Repositories;

use App\Models\User;
use Illuminate\Contracts\Database\Eloquent\Builder;
use App\Services\Interfaces\AdminRepositoryInterface;

class AdminRepository implements AdminRepositoryInterface
{
    public function updateAdmin($id, $data)
    {
        $admin = $this->getAdminById($id);

        is_null($data['password']) ? $data['password'] = $admin->password : $data['password'];

        return $admin->update($data);
    }

    public function getAllAdmins(int $per_page = 0, string $search = '')
    {
        $query = User::role('admin')
            ->select('id', 'name', 'email')
            ->with([
                'faculties' => function (Builder $query) {
                    $query->select('faculties.id', 'faculties.name', 'admin_faculty.user_id')
                        ->withPivot(['user_id']);
                }
            ])
            ->when($search, function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%');
            });

        return $per_page > 0 ? $query->paginate(perPage: $per_page) : $query->get();
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
                ->select('id', 'name', 'email', 'password')
                ->findOrFail($id);
        } catch (\Throwable $th) {
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
