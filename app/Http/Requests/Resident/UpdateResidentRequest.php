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
            'name' => ['required'],
            'password' => ['nullable', 'min:8'],
            'avatar' => ['mimes:jpg,png']
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Nama masyarakat wajib di isi',
            'password.min' => 'Password harus memiliki minimal 8 karakter',
            'avatar.mimes' => 'Foto profil harus berupa file dengan ekstensi jpg atau png',
        ];
    }
}
