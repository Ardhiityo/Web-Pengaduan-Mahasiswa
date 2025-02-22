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

    public function login(array $credentials)
    {
        $result = Auth::attempt($credentials);
        if ($result) {
            session()->regenerate();
            session()->regenerateToken();
            if (Auth::user()->hasRole('admin')) {
                return redirect()->route('admin.dashboard');
            }
            if (Auth::user()->hasRole('resident')) {
                return redirect()->route('profile');
            }
        } else {
            return redirect()->route('login')->withErrors([
                'email' => 'Email atau password salah'
            ])->withInput();
        }
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
