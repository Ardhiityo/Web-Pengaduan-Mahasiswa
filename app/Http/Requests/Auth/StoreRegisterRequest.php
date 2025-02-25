<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class StoreRegisterRequest extends FormRequest
{
    public function prepareForValidation()
    {
        $this->merge(['avatar' => 'assets/avatar/default/profile.jpg', 'public']);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email' => ['required', 'email', 'unique:users,email', 'max:255'],
            'name' => ['required', 'min:3', 'max:25'],
            'password' => ['required', 'confirmed', 'min:8', 'max:255'],
            'avatar' => ['nullable']
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'Email wajib diisi.',
            'password.max' => 'Password max 255 karakter.',
            'email.max' => 'Email max 255 karakter.',
            'email.email' => 'Email harus berupa alamat email yang valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'name.required' => 'Nama lengkap wajib diisi.',
            'name.min' => 'Nama lengkap harus terdiri dari minimal 3 karakter.',
            'name.max' => 'Nama lengkap tidak boleh lebih dari 25 karakter.',
            'password.required' => 'Kata sandi wajib diisi.',
            'password.confirmed' => 'Konfirmasi kata sandi tidak sesuai.',
            'password.min' => 'Kata sandi harus terdiri dari minimal 8 karakter.'
        ];
    }
}
