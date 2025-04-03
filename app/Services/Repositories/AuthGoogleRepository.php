<?php

namespace App\Services\Repositories;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\InvalidStateException;
use App\Services\Interfaces\AuthGoogleRepositoryInterface;

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

                // Path file in public
                $publicPath = public_path('assets/avatar/default/profile.jpg');
                $extension = pathinfo($publicPath, PATHINFO_EXTENSION);

                // New path in storage
                $storedPath = 'assets/avatar/' . uniqid() . ".$extension";

                // Copy file to storage
                if (file_exists($publicPath)) {
                    Storage::disk('public')->put($storedPath, file_get_contents($publicPath));
                }

                $newUser->resident()->create([
                    'avatar' => $storedPath
                ]);

                $user = $newUser;
            }

            Auth::login($user);
            session()->regenerate();

            //apabila sudah terdaftar
            if ($user->hasRole('admin')) {
                return redirect()->route('admin.dashboard');
            } else if ($user->hasRole('resident')) {
                return redirect()->route('profile');
            }
        } catch (InvalidStateException $invalidStateException) {
            return redirect()
                ->route('login')
                ->with(['error' => 'Ups, terjadi kesalahan, coba lagi atau ganti metode lain.']);
        }
    }
}
