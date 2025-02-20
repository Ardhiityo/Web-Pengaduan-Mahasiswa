<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class StoreLoginRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email' => ['required', 'email', 'max:255'],
            'password' => ['required', 'max:255']
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'Email wajib di isi',
            'email.max' => 'Email max 255 karakter',
            'password.max' => 'Password max 255 karakter',
            'password.required' => 'Password wajib di isi'
        ];
    }
}
