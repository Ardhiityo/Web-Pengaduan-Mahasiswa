<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\Interfaces\AuthGoogleRepositoryInterface;

class AuthGoogleController extends Controller
{
    public function __construct(private AuthGoogleRepositoryInterface $authGoogleRepository) {}

    public function redirect()
    {
        return $this->authGoogleRepository->redirect();
    }

    public function callback()
    {
        return $this->authGoogleRepository->callback();
    }
}
