<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Admin\UpdateAdminRequest;
use App\Services\Interfaces\AdminRepositoryInterface;

class ProfileController extends Controller
{
    public function __construct(private AdminRepositoryInterface $adminRepository) {}

    public function edit()
    {
        $user = Auth::user();

        return view('pages.admin.profile.edit-profile', compact('user'));
    }

    public function update(UpdateAdminRequest $request)
    {
        $user = Auth::user();

        $this->adminRepository->updateAdmin($user->id, data: $request->validated());

        return redirect()->route('admin.dashboard');
    }
}
