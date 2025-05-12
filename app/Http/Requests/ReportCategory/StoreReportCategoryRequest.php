<?php

namespace App\Http\Requests\ReportCategory;

use Illuminate\Foundation\Http\FormRequest;

class StoreReportCategoryRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'unique:report_categories', 'max:30'],
            'image' => ['required', 'mimes:jpg,png', 'unique:report_categories']
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Nama kategori wajib di isi',
            'name.max' => 'Nama max 30 karakter',
            'name.unique' => 'Nama kategori sudah terdaftar',
            'image.required' => 'Ikon wajib di isi',
            'image.unique' => 'Ikon sudah terdaftar',
            'image.mimes' => 'Ikon harus berupa file dengan ekstensi jpg atau png'
        ];
    }
}
