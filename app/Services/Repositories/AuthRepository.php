<?php

namespace App\Services\Repositories;

use Illuminate\Support\Facades\Auth;
use App\Services\Interfaces\AuthRepositoryInterface;

class AuthRepository implements AuthRepositoryInterface
{
    public function login(array $credentials): bool
    {
        return Auth::attempt($credentials);
    }

    public function logout()
    {
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();
        return redirect()->route('login');
    }
}
