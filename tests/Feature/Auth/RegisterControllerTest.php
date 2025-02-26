<?php

namespace Tests\Feature\Auth;

use Tests\TestCase;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Validation\ValidationException;

class RegisterControllerTest extends TestCase
{
    public function testRegisterView()
    {
        $this->seed(DatabaseSeeder::class);

        $this->get('register')
            ->assertSeeText('Email')
            ->assertSeeText('Nama Lengkap')
            ->assertSeeText('Password')
            ->assertSeeText('Konfirmasi Password')
            ->assertStatus(200);
    }

    public function testRegisterSuccess()
    {
        $this->post('/register', [
            'email' => 'test@gmail.com',
            'name' => 'test',
            'password' => 'rahasia123',
            'password_confirmation' => 'rahasia123'
        ])
            ->assertSessionHas('success')
            ->assertRedirect(url('/login'))
            ->assertStatus(302);
    }

    public function testRegisterAlreadyExists()
    {
        $this->seed(DatabaseSeeder::class);

        $user = User::where('email', 'hello@test.com')->first();

        $this->expectException(ValidationException::class);

        $this
            ->post('/register', [
                'email' => $user->email,
                'name' => $user->name,
                'password' => 11111111,
                'password_confirmation' => 11111111
            ])
            ->assertJson(['email' => 'Email sudah terdaftar.'])
            ->assertStatus(400);
    }
}
