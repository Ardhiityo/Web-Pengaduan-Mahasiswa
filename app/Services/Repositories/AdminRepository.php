<?php

namespace App\Services\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Services\Interfaces\AdminRepositoryInterface;

class AdminRepository implements AdminRepositoryInterface
{
    public function updateAdmin($data)
    {
        $user = Auth::user();
        $admin = User::find($user->id);

        is_null($data['password']) ?
            $data['password'] = $admin->password : $data['password'];

        return $admin->update($data);
    }
}
