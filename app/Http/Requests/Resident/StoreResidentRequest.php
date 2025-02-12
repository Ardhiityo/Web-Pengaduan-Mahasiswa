<?php

namespace App\Http\Requests\Resident;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class StoreResidentRequest extends FormRequest
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
            'name' => ['required'],
            'email' => ['required', 'email', 'unique:users'],
            'password' => ['required', 'min:8'],
            'avatar' => ['mimes:jpg,png', 'required']
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'Email wajib di isi',
            'email.unique' => 'Email sudah terdaftar',
            'password.required' => 'Password wajib di isi',
            'password.min' => 'Password harus memiliki minimal 8 karakter',
            'name.required' => 'Nama masyarakat wajib di isi',
            'avatar.mimes' => 'Foto profil harus berupa file dengan ekstensi jpg atau png',
            'avatar.required' => 'Foto profil wajib di isi'
        ];
    }
}
