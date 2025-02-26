<?php

namespace Tests\Feature\Auth;

use Tests\TestCase;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Support\Facades\Auth;

class LoginControllerTest extends TestCase
{
    public function testLoginView()
    {
        $this->seed(DatabaseSeeder::class);

        $this->get('/login')
            ->assertSeeText('Masuk / Daftar')
            ->assertSeeText('Email')
            ->assertSeeText('Password')
            ->assertStatus(200);
    }

    public function testLoginResidentSuccess()
    {
        $this->seed(DatabaseSeeder::class);

        $user = User::where('email', 'hello@test.com')
            ->first();

        $this->post('/login', [
            'password' => 11111111,
            'email' => $user->email
        ])
            ->assertRedirect(url('/profile'))
            ->assertStatus(302);
    }

    public function testLoginResidentFailed()
    {
        $this->seed(DatabaseSeeder::class);

        $user = User::where('email', 'hello@test.com')
            ->first();

        $this->post('/login', [
            'password' => 11111111,
            'email' => 'salah@test.com'
        ])
            ->assertRedirect(url('/login'))
            ->assertStatus(302);
    }

    public function testLoginAdminSuccess()
    {
        $this->seed(DatabaseSeeder::class);

        $user = User::first();

        $this->post('/login', [
            'password' => 11111111,
            'email' => $user->email
        ])
            ->assertRedirect(url('/admin/dashboard'))
            ->assertStatus(302);
    }

    public function testLoginAdminFailed()
    {
        $this->seed(DatabaseSeeder::class);

        $user = User::first();

        $this->post('/login', [
            'password' => 11111111,
            'email' => 'salah@test'
        ])
            ->assertRedirect(url('/login'))
            ->assertStatus(302);
    }

    public function testResidentLogout()
    {
        $this->seed(DatabaseSeeder::class);

        $user = User::where('email', 'hello@test.com')
            ->first();

        Auth::login($user);

        $this->post('/logout')
            ->assertRedirect(url('/login'))
            ->assertStatus(302);
    }

    public function testAdminLogout()
    {
        $this->seed(DatabaseSeeder::class);

        $user = User::first();

        Auth::login($user);

        $this->post('/logout')
            ->assertRedirect(url('/login'))
            ->assertStatus(302);
    }
}
