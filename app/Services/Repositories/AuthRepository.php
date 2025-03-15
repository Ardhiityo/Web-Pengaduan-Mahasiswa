<?php

namespace App\Services\Repositories;

use Illuminate\Support\Facades\Auth;
use App\Services\Interfaces\AuthRepositoryInterface;
use App\Services\Interfaces\ResidentRepositoryInterface;

class AuthRepository implements AuthRepositoryInterface
{
    public function __construct(private ResidentRepositoryInterface $residentRepository) {}

    public function login(array $credentials)
    {
        if (Auth::attempt($credentials)) {
            session()->regenerate();
            if (Auth::user()->hasRole('admin')) {
                return redirect()->route('admin.dashboard');
            }
            return redirect()->intended(route('profile'));
        } else {
            return redirect()->route('login')->withErrors([
                'email' => 'Email atau password salah'
            ])->withInput();
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }

    public function register(array $data)
    {
        return $this->residentRepository->createResident($data);
    }
}
