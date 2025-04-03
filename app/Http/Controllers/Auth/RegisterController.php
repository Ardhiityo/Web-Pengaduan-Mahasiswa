<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\StoreRegisterRequest;
use App\Services\Interfaces\AuthRepositoryInterface;

class RegisterController extends Controller
{
    public function __construct(private AuthRepositoryInterface $authRepository) {}

    public function index()
    {
        return view('pages.auth.register');
    }

    public function store(StoreRegisterRequest $request)
    {
        $this->authRepository->register($request->validated());

        return redirect()->route('login')
            ->with('success', 'Yeay, akunmu berhasil dibuat, mari login!');
    }
}
