<?php

namespace App\Http\Requests\Resident;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Http\FormRequest;

class StoreResidentRequest extends FormRequest
{
    public function prepareForValidation()
    {
        // Path file in public
        $publicPath = public_path('assets/avatar/default/profile.jpg');
        $extension = pathinfo($publicPath, PATHINFO_EXTENSION);

        // New path in storage
        $storedPath = 'assets/avatar/' . uniqid('profile-default-') . ".$extension";

        // Copy file to storage
        if (file_exists($publicPath)) {
            Storage::disk('public')->put($storedPath, file_get_contents($publicPath));

            // Change avatar input with a new path in storage
            $this->merge(['avatar' => $storedPath]);
        }
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::user() != null;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'max:30'],
            'email' => ['required', 'email', 'unique:users', 'max:255'],
            'password' => ['required', 'min:8', 'max:255'],
            'avatar' => ['nullable']
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'Email wajib di isi',
            'email.max' => 'Email max 255 karakter',
            'email.unique' => 'Email sudah terdaftar',
            'password.required' => 'Password wajib di isi',
            'password.max' => 'Password max 255 karakter',
            'password.min' => 'Password harus memiliki minimal 8 karakter',
            'name.required' => 'Nama wajib di isi',
            'name.max' => 'Nama max 30 karakter'
        ];
    }
}
