<?php

namespace App\Http\Requests\Superadmin\Faculty;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateFacultyRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', Rule::unique('faculties', 'name')->ignore($this->route('faculty'))]
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Nama Fakultas Wajib di isi.',
            'name.unique' => 'Nama Fakultas sudah dimiliki.'
        ];
    }
}
