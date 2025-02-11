<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
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
        $credentials = $request->validated();
        if ($this->authRepository->login($credentials)) {
            if (Auth::user()->hasRole('admin')) {
                return redirect()->route('admin.dashboard');
            }
            if (Auth::user()->hasRole('resident')) {
                return redirect()->route('home');
            }
        }
        return redirect()->route('login')->withErrors([
            'email' => 'Email atau password salah'
        ])->withInput();
    }

    public function logout()
    {
        return $this->authRepository->logout();
    }
}
