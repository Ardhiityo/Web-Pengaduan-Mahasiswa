<?php

namespace Tests\Feature\Admin;

use Tests\TestCase;
use App\Models\User;
use App\Models\Resident;
use App\Models\StudyProgram;
use Database\Seeders\AdminSeeder;
use Database\Seeders\DatabaseSeeder;
use Database\Seeders\ResidentSeeder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class ResidentControllerTest extends TestCase
{
    public function testResidentView()
    {
        $this->seed(DatabaseSeeder::class);

        $user = User::role('superadmin')->first();

        Auth::login($user);

        $this->get('/admin/resident')
            ->assertSeeText('Daftar Data Mahasiswa')
            ->assertStatus(200);
    }

    public function testResidentEditView()
    {
        $this->seed(DatabaseSeeder::class);

        $user = User::role('superadmin')->first();

        Auth::login($user);

        $user = User::where('email', 'hello@test.com')->first();

        $this->get('/admin/resident/' . $user->resident->id . '/edit')
            ->assertSeeText('Nama Mahasiswa')
            ->assertSeeText('Email')
            ->assertSeeText('Password')
            ->assertStatus(200);
    }

    public function testResidentCreate()
    {
        $this->seed(DatabaseSeeder::class);

        $user = User::role('superadmin')->first();

        Auth::login($user);

        $studyProgramId = StudyProgram::first()->id;

        $this->post('/admin/resident', [
            'name' => 'testing',
            'email' => 'test@test.com',
            'password' => 'rahasia123',
            'password_confirmation' => 'rahasia123',
            'study_program_id' => $studyProgramId,
            'nim' => 22041029
        ])
            ->assertRedirect(url('/admin/resident'))
            ->assertStatus(302);

        self::assertNotNull(User::where('email', 'test@test.com')->first());
    }

    public function testResidentShow()
    {
        $this->seed(DatabaseSeeder::class);

        $user = User::role('superadmin')->first();

        Auth::login($user);

        $user = User::where('email', 'hello@test.com')->first();

        $this->get('/admin/resident/' . $user->resident->id)
            ->assertSeeText($user->name)
            ->assertSeeText($user->email)
            ->assertStatus(200);
    }

    public function testResidentUpdate()
    {
        $this->seed(DatabaseSeeder::class);

        $user = User::role('superadmin')->first();

        Auth::login($user);

        $user = User::where('email', 'hello@test.com')->first();

        $this->patch('/admin/resident/' . $user->resident->id, [
            'name' => 'updated',
            'email' => $user->email,
            'password' => 'rahasia123',
            'password_confirmation' => 'rahasia123',
            'study_program_id' => $user->resident->study_program_id,
            'nim' => $user->resident->nim
        ])
            ->assertRedirect(url('/admin/resident'))
            ->assertStatus(302);

        self::assertNotNull(User::where('name', 'updated')->first());
    }

    public function testResidentDestroy()
    {
        $this->seed([DatabaseSeeder::class]);

        $user = User::role('superadmin')->first();
        self::assertNotNull($user);

        Auth::login($user);
        self::assertNotNull(Auth::user());

        $user = User::where('email', 'hello@test.com')->first();
        self::assertNotNull($user);

        $this->delete('/admin/resident/' . $user->resident->id)
            ->assertRedirect(url('/admin/resident'))
            ->assertStatus(302);

        $resident = Resident::find($user->id);
        self::assertNull($resident);
    }
}
