<?php

namespace Tests\Feature\Admin;

use Tests\TestCase;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Support\Facades\Auth;

class ProfileControllerTest extends TestCase
{
    public function testProfileEditView()
    {
        $this->seed(DatabaseSeeder::class);

        $user = User::first();

        Auth::login($user);

        $this->get('/admin/profile/edit')
            ->assertSeeText('Nama')
            ->assertSeeText('Email')
            ->assertSeeText('Password')
            ->assertStatus(200);
    }

    public function testProfileUpdate()
    {
        $this->seed(DatabaseSeeder::class);

        $user = User::first();

        Auth::login($user);

        $this->patch('/admin/profile/edit', [
            'name' => 'updated',
            'email' => 'updated@test.com',
            'password' => ''
        ])
            ->assertRedirect(url('/admin/dashboard'))
            ->assertStatus(302);

        $updateUser = User::first();

        self::assertNotEquals($user->name, $updateUser->name);
        self::assertNotEquals($user->name, $updateUser->email);
    }
}
