<?php

namespace Tests;

use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    public function setUp(): void
    {
        parent::setUp();

        DB::delete('DELETE FROM report_statuses');
        DB::delete('DELETE FROM reports');
        DB::delete('DELETE FROM report_categories');
        DB::delete('DELETE FROM residents');
        DB::delete('DELETE FROM users');
        DB::delete('DELETE FROM faqs');
    }
}
