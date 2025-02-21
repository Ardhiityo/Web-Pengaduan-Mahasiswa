<?php

namespace App\Services\Interfaces;

interface AuthGoogleRepositoryInterface
{
    public function redirect();
    public function callback();
}
