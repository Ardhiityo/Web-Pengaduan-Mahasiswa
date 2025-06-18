<?php

namespace App\Http\Requests\Resident;

use App\Models\Resident;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class UpdateResidentRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        if (Auth::user()->hasRole('admin') || Auth::user()->hasRole('superadmin')) {
            $userId = Resident::find($this->route('resident'))->user_id;
        } else if (Auth::user()->hasRole('resident')) {
            $userId = Auth::user()->id;
        }

        return [
            'name' => ['required', 'string', 'max:30'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($userId)],
            'nim' => ['required', 'numeric', 'digits_between:8,10', Rule::unique('residents', 'nim')->ignore(Auth::user()->id)],
            'study_program_id' => ['required', 'exists:study_programs,id'],
            'password' => ['nullable', 'min:8', 'confirmed', 'max:255'],
            'avatar' => ['mimes:jpg,png']
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Nama lengkap wajib di isi',
            'name.string' => 'Nama harus berupa teks',
            'name.max' => 'Nama maksimal 30 karakter',

            'email.required' => 'Email wajib di isi',
            'email.email' => 'Format email tidak valid',
            'email.max' => 'Email maksimal 255 karakter',
            'email.unique' => 'Email sudah digunakan',

            'nim.required' => 'NIM wajib di isi',
            'nim.numeric' => 'NIM harus berupa angka',
            'nim.digits_between' => 'NIM memiliki 8-10 digit',
            'nim.unique' => 'NIM telah digunakan mahasiswa lain.',

            'study_program_id.required' => 'Program studi wajib di pilih',
            'study_program_id.exists' => 'Program studi tidak valid',

            'password.min' => 'Password harus memiliki minimal 8 karakter',
            'password.confirmed' => 'Konfirmasi kata sandi tidak sesuai',
            'password.max' => 'Password maksimal 255 karakter',

            'avatar.mimes' => 'Foto profil harus berekstensi jpg atau png'
        ];
    }
}
