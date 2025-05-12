<?php

namespace App\Http\Requests\Superadmin\StudyProgram;

use Illuminate\Foundation\Http\FormRequest;

class UpdateStudyProgramRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "name" => "required|min:3|string|max:255"
        ];
    }

    public function messages()
    {
        return [
            "name.required" => "Nama program studi tidak boleh kosong",
            "name.min" => "Nama program studi minimal 3 karakter",
            "name.max" => "Nama program studi maksimal 255 karakter",
            "name.string" => "Nama program studi harus berupa string"
        ];
    }
}
