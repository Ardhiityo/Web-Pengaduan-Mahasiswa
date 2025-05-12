<?php

namespace App\Http\Requests\Superadmin\StudyProgram;

use Illuminate\Foundation\Http\FormRequest;

class StoreStudyProgramRequest extends FormRequest
{

    public function prepareForValidation()
    {
        $this->merge([
            'faculty_id' => $this->route('faculty'),
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
            'name' => 'required|string|max:255|unique:study_programs,name|min:3',
            'faculty_id' => 'required|uuid|exists:faculties,id'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Nama program studi harus diisi',
            'name.string' => 'Nama program studi harus berupa string',
            'name.max' => 'Nama program studi maksimal 255 karakter',
            'name.unique' => 'Nama program studi sudah ada',
            'name.min' => 'Nama program studi minimal 3 karakter',
            'faculty_id.required' => 'Fakultas harus diisi',
            'faculty_id.uuid' => 'Fakultas harus berupa uuid',
            'faculty_id.exists' => 'Fakultas tidak ditemukan',
        ];
    }
}
