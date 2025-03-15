<?php

namespace Tests\Feature\User;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileControllerTest extends TestCase
{
    public function testProfileView()
    {
        $this->seed(DatabaseSeeder::class);

        $user = User::where('email', 'hello@test.com')->first();
        $user->email_verified_at = now();
        $user->save();

        Auth::login($user);

        $this->get('/profile')
            ->assertSeeText($user->name)
            ->assertStatus(200);
    }

    public function testProfileEditView()
    {
        $this->seed(DatabaseSeeder::class);

        $user = User::where('email', 'hello@test.com')->first();
        $user->email_verified_at = now();
        $user->save();

        Auth::login($user);

        $this->get('/profile/edit')
            ->assertSeeText('Nama lengkap')
            ->assertSeeText('Avatar')
            ->assertSeeText('Password')
            ->assertSeeText('Konfirmasi password')
            ->assertStatus(200);
    }

    public function testProfileUpdate()
    {
        $this->seed(DatabaseSeeder::class);

        $user = User::where('email', 'hello@test.com')->first();
        $user->email_verified_at = now();
        $user->save();

        Auth::login($user);

        $this->patch('/profile', [
            'name' => 'Updated',
            'password' => 'rahasia123',
            'password_confirmation' => 'rahasia123'
        ])
            ->assertRedirect(url('/profile'))
            ->assertStatus(302);

        self::assertNotNull(User::where('name', 'Updated')->first());
    }
}
