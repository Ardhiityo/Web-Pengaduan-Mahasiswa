<?php

namespace App\Http\Requests\Superadmin\AdminFaculty;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class StoreAdminFacultyRequest extends FormRequest
{
    public function prepareForValidation()
    {
        $this->merge([
            'user_id' => $this->route('admin'),
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'user_id' => 'required|uuid|exists:users,id',
            'faculty_id' => [
                'required',
                'uuid',
                'exists:faculties,id',
                Rule::unique('admin_faculty', 'faculty_id')
                    ->where('user_id', $this->user_id)
            ]
        ];
    }

    public function messages(): array
    {
        return [
            'user_id.required' => 'ID pengguna wajib diisi',
            'user_id.uuid' => 'Format ID pengguna tidak valid',
            'user_id.exists' => 'ID pengguna tidak ditemukan dalam database',
            'faculty_id.required' => 'Fakultas wajib diisi',
            'faculty_id.uuid' => 'Format ID fakultas tidak valid',
            'faculty_id.exists' => 'Fakultas tidak ditemukan dalam database',
            'faculty_id.unique' => 'Admin ini sudah terdaftar di fakultas yang dipilih'
        ];
    }
}
