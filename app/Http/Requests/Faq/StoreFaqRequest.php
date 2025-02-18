<?php

namespace App\Http\Requests\Faq;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class StoreFaqRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::user() != null;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required'],
            'description' => ['required']
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'Judul FAQ wajib diisi.',
            'description.required' => 'Deskripsi FAQ wajib diisi.'
        ];
    }
}
