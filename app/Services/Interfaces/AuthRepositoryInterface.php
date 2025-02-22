<?php

namespace App\Services\Interfaces;

interface AuthRepositoryInterface
{
    public function login(array $credentials);
    public function logout();
    public function register(array $data);
}
