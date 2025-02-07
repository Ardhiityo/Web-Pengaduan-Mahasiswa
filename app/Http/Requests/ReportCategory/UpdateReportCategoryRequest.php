<?php

namespace App\Http\Requests\ReportCategory;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class UpdateReportCategoryRequest extends FormRequest
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
            'name' => ['nullable'],
            'image' => ['nullable', 'mimes:jpg,png']
        ];
    }

    public function messages()
    {
        return [
            'image.mimes' => 'Ikon harus berupa file dengan ekstensi jpg atau png'
        ];
    }
}
