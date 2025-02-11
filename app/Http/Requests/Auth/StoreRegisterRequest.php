<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class StoreRegisterRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email' => ['required', 'email', 'unique:users,email'],
            'name' => ['required', 'min:3', 'max:25'],
            'avatar' => ['mimes:jpg,png', 'required'],
            'password' => ['required', 'confirmed', 'min:8']
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Email harus berupa alamat email yang valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'name.required' => 'Nama lengkap wajib diisi.',
            'name.min' => 'Nama lengkap harus terdiri dari minimal 3 karakter.',
            'name.max' => 'Nama lengkap tidak boleh lebih dari 25 karakter.',
            'avatar.required' => 'Foto profil wajib diunggah.',
            'avatar.mimes' => 'Foto profil harus berekstensi jpg atau png.',
            'password.required' => 'Kata sandi wajib diisi.',
            'password.confirmed' => 'Konfirmasi kata sandi tidak sesuai.',
            'password.min' => 'Kata sandi harus terdiri dari minimal 8 karakter.'
        ];
    }
}
