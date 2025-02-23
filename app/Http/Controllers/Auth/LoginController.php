<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\StoreLoginRequest;
use App\Services\Interfaces\AuthRepositoryInterface;

class LoginController extends Controller
{
    public function __construct(private AuthRepositoryInterface $authRepository) {}

    public function index()
    {
        return view('pages.auth.login');
    }

    public function store(StoreLoginRequest $request)
    {
        return $this->authRepository->login($request->validated());
    }

    public function logout()
    {
        return $this->authRepository->logout();
    }
}
