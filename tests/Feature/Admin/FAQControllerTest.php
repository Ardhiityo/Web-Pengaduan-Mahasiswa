<?php

namespace Tests\Feature\Admin;

use App\Models\Faq;
use Tests\TestCase;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Support\Facades\Auth;

class FAQControllerTest extends TestCase
{
    public function testFAQView()
    {
        $this->seed(DatabaseSeeder::class);

        $user = User::role('superadmin')->first();

        Auth::login($user);

        $this->get('/admin/faq')
            ->assertSeeText('Daftar Data FAQ')
            ->assertStatus(200);
    }

    public function testFAQCreateView()
    {
        $this->seed(DatabaseSeeder::class);

        $user = User::role('superadmin')->first();

        Auth::login($user);

        $this->get('admin/faq/create')
            ->assertSeeText('Judul FAQ')
            ->assertSeeText('Deskripsi')
            ->assertStatus(200);
    }

    public function testFAQCreateSuccess()
    {
        $this->seed(DatabaseSeeder::class);

        $user = User::role('superadmin')->first();

        Auth::login($user);

        $this->post('/admin/faq', [
            'title' => 'Test',
            'description' => 'testing'
        ])
            ->assertRedirect(url('/admin/faq'))
            ->assertStatus(302);
    }

    public function testFAQCreateUnauthorized()
    {
        $this->seed(DatabaseSeeder::class);

        $this->post('/admin/faq', [
            'title' => 'Test',
            'description' => 'test'
        ])
            ->assertRedirect(url('/login'))
            ->assertStatus(302);
    }

    public function testFaqShow()
    {
        $this->seed(DatabaseSeeder::class);

        $user = User::role('superadmin')->first();

        Auth::login($user);

        $faq = Faq::first();

        $this->get('/admin/faq/' . $faq->id)
            ->assertSeeText('Judul')
            ->assertSeeText('Deskripsi')
            ->assertSeeText($faq->title)
            ->assertSeeText($faq->description)
            ->assertStatus(200);
    }

    public function testFaqEditView()
    {
        $this->seed(DatabaseSeeder::class);

        $user = User::role('superadmin')->first();

        Auth::login($user);

        $faq = Faq::first();

        $this->get('/admin/faq/' . $faq->id . '/edit')
            ->assertSeeText('Judul FAQ')
            ->assertSeeText('Deskripsi')
            ->assertStatus(200);
    }

    public function testFaqUpdate()
    {
        $this->seed(DatabaseSeeder::class);

        $user = User::role('superadmin')->first();

        Auth::login($user);

        $faq = Faq::first();

        $this->put('/admin/faq/' . $faq->id, [
            'title' => 'update',
            'description' => 'updated'
        ])
            ->assertRedirect(url('/admin/faq'))
            ->assertStatus(302);

        $newFaq = Faq::first();

        self::assertNotEquals($faq->title, $newFaq->title);
        self::assertNotEquals($faq->description, $newFaq->description);
    }

    public function testFaqDestroy()
    {
        $this->seed(DatabaseSeeder::class);

        $faq = Faq::first();

        $user = User::role('superadmin')->first();

        Auth::login($user);

        $this->delete('/admin/faq/' . $faq->id)
            ->assertRedirect('/admin/faq')
            ->assertStatus(302);

        $newFaq = Faq::find($faq->id);

        self::assertNull($newFaq);
    }
}
