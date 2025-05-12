<?php

namespace App\Http\Requests\Resident;

use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Http\FormRequest;
use Ramsey\Uuid\Uuid;

class StoreResidentRequest extends FormRequest
{
    public function prepareForValidation()
    {
        // Path file in public
        $publicPath = public_path('assets/avatar/default/profile.jpg');
        $extension = pathinfo($publicPath, PATHINFO_EXTENSION);

        // New path in storage
        $storedPath = 'assets/avatar/' . Uuid::uuid4() . ".$extension";

        // Copy file to storage
        if (file_exists($publicPath)) {
            Storage::disk('public')->put($storedPath, file_get_contents($publicPath));

            // Change avatar input with a new path in storage
            $this->merge(['avatar' => $storedPath]);
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'max:30', 'string'],
            'nim' => ['required', 'digits_between:8,10', 'numeric', 'unique:residents,nim'],
            'study_program_id' => ['required', 'exists:study_programs,id'],
            'email' => ['required', 'email', 'unique:users', 'max:255'],
            'password' => ['required', 'min:8', 'max:255', 'confirmed'],
            'avatar' => ['nullable'],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Nama wajib di isi',
            'name.max' => 'Nama maksimal 30 karakter',
            'name.string' => 'Nama harus berupa teks',

            'nim.required' => 'NIM wajib di isi',
            'nim.numeric' => 'NIM harus berupa angka',
            'nim.unique' => 'NIM sudah terdaftar',
            'nim.digits_between' => 'NIM harus memiliki panjang antara 8-10 digit',

            'study_program_id.required' => 'Program studi wajib di isi',
            'study_program_id.exists' => 'Program studi tidak valid',

            'email.required' => 'Email wajib di isi',
            'email.email' => 'Format email tidak valid',
            'email.unique' => 'Email sudah terdaftar',
            'email.max' => 'Email maksimal 255 karakter',

            'password.required' => 'Password wajib di isi',
            'password.min' => 'Password minimal 8 karakter',
            'password.max' => 'Password maksimal 255 karakter',
            'password.confirmed' => 'Konfirmasi password tidak sesuai'
        ];
    }
}
