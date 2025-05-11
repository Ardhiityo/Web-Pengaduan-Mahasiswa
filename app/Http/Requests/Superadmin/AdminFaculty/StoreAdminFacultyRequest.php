<?php

namespace App\Http\Requests\Superadmin\AdminFaculty;

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
            'faculty_id' => 'required|uuid|exists:faculties,id'
        ];
    }
}
