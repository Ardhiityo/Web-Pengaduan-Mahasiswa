<?php

namespace Tests\Feature\User;

use Tests\TestCase;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Support\Facades\Auth;

class HomeControllerTest extends TestCase
{
    public function testHomeView()
    {
        $this->seed(DatabaseSeeder::class);

        $user = User::where('email', 'hello@test.com')->first();

        Auth::login($user);

        $this->get('/')
            ->assertSeeText('Hai, ' . $user->name)
            ->assertStatus(200);
    }

    public function testHomeViewUnauthenticate()
    {
        $this->seed(DatabaseSeeder::class);

        $this->get('/')
            ->assertSeeText('Selamat datang')
            ->assertStatus(200);
    }
}
