<?php

namespace App\Http\Requests\Superadmin\Admin;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateAdminRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                Rule::unique('users')->ignore($this->route()->parameter('admin')),
                'string',
                'email',
                'max:255',
            ],
            'password' => ['nullable', 'string', 'min:8', 'confirmed']
        ];
    }
}
