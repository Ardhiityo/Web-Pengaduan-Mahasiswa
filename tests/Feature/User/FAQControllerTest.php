<?php

namespace Tests\Feature\User;

use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class FAQControllerTest extends TestCase
{
    public function testFAQView()
    {
        $this->seed(DatabaseSeeder::class);

        $this->get('/faq')
            ->assertSeeText('FAQ (Frequently Asked Questions)')
            ->assertStatus(200);
    }
}
