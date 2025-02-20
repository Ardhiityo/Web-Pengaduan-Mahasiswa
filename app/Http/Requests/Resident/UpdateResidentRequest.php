<?php

namespace App\Http\Requests\Resident;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class UpdateResidentRequest extends FormRequest
{
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
            'password' => ['nullable', 'min:8', 'confirmed', 'max:255'],
            'avatar' => ['mimes:jpg,png']
        ];
    }

    public function messages()
    {
        return [
            'name.max' => 'Nama max 30 karakter',
            'password.max' => 'Password max 255 karakter',
            'name.required' => 'Nama lengkap wajib di isi',
            'password.min' => 'Password harus memiliki minimal 8 karakter',
            'password.confirmed' => 'Konfirmasi kata sandi tidak sesuai.',
            'avatar.mimes' => 'Foto profil harus berekstensi jpg atau png',
        ];
    }
}
