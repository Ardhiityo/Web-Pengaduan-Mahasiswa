<?php

namespace Tests;

use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    public function setUp(): void
    {
        parent::setUp();

        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::delete('DELETE FROM sessions');
        DB::delete('DELETE FROM model_has_roles');
        DB::delete('DELETE FROM model_has_permissions');
        DB::delete('DELETE FROM role_has_permissions');
        DB::delete('DELETE FROM permissions');
        DB::delete('DELETE FROM roles');
        DB::delete('DELETE FROM report_statuses');
        DB::delete('DELETE FROM reports');
        DB::delete('DELETE FROM residents');
        DB::delete('DELETE FROM study_programs');
        DB::delete('DELETE FROM report_categories');
        DB::delete('DELETE FROM admin_faculty');
        DB::delete('DELETE FROM faculties');
        DB::delete('DELETE FROM users');
        DB::delete('DELETE FROM faqs');
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }
}
