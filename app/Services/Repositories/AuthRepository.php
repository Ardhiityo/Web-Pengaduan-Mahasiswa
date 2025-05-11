<?php

namespace App\Services\Repositories;

use Illuminate\Support\Facades\Log;
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
            $user = Auth::user();
            if ($user->hasRole('admin') || $user->hasRole('superadmin')) {
                return redirect()->route('admin.dashboard');
            }
            Log::info($user->hasVerifiedEmail());
            Log::info($user);
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
        session()->invalidate();

        return redirect()->route('login');
    }

    public function register(array $data)
    {
        return $this->residentRepository->createResident($data);
    }
}
