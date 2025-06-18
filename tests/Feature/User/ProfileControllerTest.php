<?php

namespace Tests\Feature\User;

use Tests\TestCase;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Support\Facades\Auth;

class ProfileControllerTest extends TestCase
{
    public function testProfileView()
    {
        $this->seed(DatabaseSeeder::class);

        $user = User::where('email', 'hello@test.com')->first();

        Auth::login($user);

        $this->get('/profile')
            ->assertSeeText($user->name)
            ->assertStatus(200);
    }

    public function testProfileEditView()
    {
        $this->seed(DatabaseSeeder::class);

        $user = User::where('email', 'hello@test.com')->first();

        Auth::login($user);

        $this->get('/profile/edit')
            ->assertSeeText('Nama lengkap')
            ->assertSeeText('Avatar')
            ->assertStatus(200);
    }

    public function testProfileUpdate()
    {
        $this->seed(DatabaseSeeder::class);

        $user = User::where('email', 'hello@test.com')->first();

        Auth::login($user);

        $this->patch('/profile', [
            'name' => 'Updated',
            'email' => $user->email,
            'study_program_id' => $user->resident->study_program_id,
            'nim' => $user->resident->nim,
            'password' => 'rahasia123',
            'password_confirmation' => 'rahasia123'
        ])
            ->assertRedirect(url('/profile'))
            ->assertStatus(302);

        self::assertNotNull(User::where('name', 'Updated')->first());
    }
}
