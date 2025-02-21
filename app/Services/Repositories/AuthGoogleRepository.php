<?php

namespace App\Services\Repositories;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use App\Services\Interfaces\AuthGoogleRepositoryInterface;
use Exception;

class AuthGoogleRepository implements AuthGoogleRepositoryInterface
{
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback()
    {
        try {
            $userFromGoogle = Socialite::driver('google')->user();

            $user = User::where('email', $userFromGoogle->getEmail())->first();

            //apabila belum terdaftar
            if (is_null($user)) {
                $newUser = User::create([
                    'email' => $userFromGoogle->getEmail(),
                    'name' => $userFromGoogle->getName(),
                    'password' => Hash::make(Str::random(16))
                ])->assignRole('resident');

                Auth::login($newUser);

                $newUser->resident()->create([
                    'avatar' => 'assets/avatar/default/profile.jpg'
                ]);
                session()->regenerate();
                session()->regenerateToken();
                return redirect()->route('profile');
            }

            //apabila sudah terdaftar
            session()->regenerate();
            session()->regenerateToken();
            Auth::login($user);
            if ($user->hasRole('admin')) {
                return redirect()->route('admin.dashboard');
            } else if ($user->hasRole('resident')) {
                return redirect()->route('profile');
            }
        } catch (Exception $exception) {
            return redirect()->route('login')->with(['success' => $exception->getMessage()]);
        }
    }
}
