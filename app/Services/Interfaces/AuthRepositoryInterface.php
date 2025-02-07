<?php

namespace App\Services\Interfaces;

interface AuthRepositoryInterface
{
    public function login(array $credentials): bool;
    public function logout();
}
