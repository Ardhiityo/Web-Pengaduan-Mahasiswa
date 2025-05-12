<?php

namespace App\Http\Requests\ReportCategory;

use Illuminate\Foundation\Http\FormRequest;

class UpdateReportCategoryRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'max:30', 'min:3'],
            'image' => ['nullable', 'mimetypes:image/jpeg,image/png'],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Nama kategori wajib diisi',
            'name.max' => 'Nama kategori maksimal 30 karakter',
            'name.min' => 'Nama kategori minimal 3 karakter',
            'image.mimetypes' => 'Ikon harus berupa file dengan format jpeg atau png'
        ];
    }
}
