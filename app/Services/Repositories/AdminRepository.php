<?php

namespace App\Services\Repositories;

use App\Models\User;
use App\Models\Admin;
use Illuminate\Contracts\Database\Eloquent\Builder;
use App\Services\Interfaces\AdminRepositoryInterface;

class AdminRepository implements AdminRepositoryInterface
{
    public function updateAdmin($id, $data)
    {
        $admin = Admin::find($id);

        is_null($data['password']) ?
            $data['password'] = $admin->user->password : $data['password'];

        $admin->user->update($data);
        $admin->update($data);
    }

    public function getAllAdmins()
    {
        return Admin::with([
            'user' => function (Builder $query) {
                $query->select('id', 'name', 'email');
            },
            'faculty' => function (Builder $query) {
                $query->select('id', 'name');
            },
        ])
            ->select('id', 'user_id', 'faculty_id')
            ->get();
    }

    public function createAdmin($data)
    {
        $user = User::create($data);

        $user->assignRole('admin');

        $data['user_id'] = $user->id;

        Admin::create($data);

        return $user;
    }

    public function getAdminById($id)
    {
        return Admin::with([
            'faculty' => function (Builder $query) {
                $query->select('id', 'name');
            },
            'user' => function (Builder $query) {
                $query->select('id', 'name', 'email');
            }
        ])
            ->select('id', 'user_id', 'faculty_id')
            ->find($id);
    }

    public function deleteAdminById($id)
    {
        $admin = Admin::find($id);
        $admin->delete();

        return $admin->user->delete();
    }
}
