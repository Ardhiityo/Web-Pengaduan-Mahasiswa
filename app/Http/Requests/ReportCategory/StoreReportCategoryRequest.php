<?php

namespace App\Http\Requests\ReportCategory;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class StoreReportCategoryRequest extends FormRequest
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
            'name' => ['required', 'unique:report_categories'],
            'image' => ['required', 'mimes:jpg,png', 'unique:report_categories']
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Nama kategori wajib di isi',
            'name.unique' => 'Nama kategori sudah terdaftar',
            'image.required' => 'Ikon wajib di isi',
            'image.unique' => 'Ikon sudah terdaftar',
            'image.mimes' => 'Ikon harus berupa file dengan ekstensi jpg atau png'
        ];
    }
}
