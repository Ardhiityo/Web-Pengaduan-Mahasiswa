<?php

namespace App\Services\Repositories;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use App\Services\Interfaces\AuthGoogleRepositoryInterface;
use Exception;
use Laravel\Socialite\Two\InvalidStateException;

class AuthGoogleRepository implements AuthGoogleRepositoryInterface
{
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback()
    {
        try {
            $userFromGoogle = Socialite::driver('google')->stateless()->user();

            $user = User::where('email', $userFromGoogle->getEmail())->first();

            //apabila belum terdaftar
            if (is_null($user)) {
                $newUser = User::create([
                    'email' => $userFromGoogle->getEmail(),
                    'name' => $userFromGoogle->getName(),
                    'password' => Hash::make(Str::random(16))
                ])->assignRole('resident');

                $newUser->resident()->create([
                    'avatar' => 'assets/avatar/default/profile.jpg'
                ]);

                $user = $newUser;
            }

            Auth::login($user);

            //apabila sudah terdaftar
            if ($user->hasRole('admin')) {
                return redirect()->route('admin.dashboard');
            } else if ($user->hasRole('resident')) {
                return redirect()->route('profile');
            }
        } catch (InvalidStateException $invalidStateException) {
            return redirect()->route('login')->with(['error' => 'Ups, terjadi kesalahan, coba lagi atau ganti metode lain.']);
        }
    }
}
