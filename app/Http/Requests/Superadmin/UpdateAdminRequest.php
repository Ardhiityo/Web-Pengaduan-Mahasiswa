<?php

namespace App\Http\Requests\Superadmin;

use App\Models\Admin;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Foundation\Http\FormRequest;
use App\Services\Repositories\DecryptParameterRepository;

class UpdateAdminRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $user_id = Admin::find(Crypt::decrypt($this->route()->parameter('admin')))->user_id;

        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                Rule::unique('users')->ignore($user_id),
                'string',
                'email',
                'max:255',
            ],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'faculty_id' => ['required', 'exists:faculties,id'],
        ];
    }
}
