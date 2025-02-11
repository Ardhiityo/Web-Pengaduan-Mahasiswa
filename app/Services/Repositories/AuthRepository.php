<?php

namespace App\Services\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Services\Interfaces\AuthRepositoryInterface;
use App\Services\Interfaces\ResidentRepositoryInterface;

class AuthRepository implements AuthRepositoryInterface
{
    public function __construct(private ResidentRepositoryInterface $residentRepository) {}

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

    public function register(array $data)
    {
        return $this->residentRepository->createResident($data);
    }
}
