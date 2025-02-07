<?php

namespace App\Http\Requests\Report;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class UpdateReportCategory extends FormRequest
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
            'resident_id' => ['required', 'exists:residents,id'],
            'report_category_id' => ['required', 'exists:report_categories,id'],
            'title' => ['required', 'max:255'],
            'description' => ['required'],
            'image' => ['nullable', 'mimes:jpg,png'],
            'latitude' => ['required'],
            'longitude' => ['required'],
            'address' => ['required']
        ];
    }

    public function messages()
    {
        return
            [
                'resident_id.required' => 'Pelapor wajib diisi',
                'resident_id.exists' => 'Pelapor tidak ditemukan',
                'report_category_id.required' => 'Kategori laporan wajib diisi',
                'report_category_id.exists' => 'Kategori laporan tidak ditemukan',
                'title.required' => 'Judul laporan wajib diisi',
                'title.max' => 'Judul laporan tidak boleh lebih dari 255 karakter',
                'description.required' => 'Deskripsi laporan wajib diisi',
                'image.mimes' => 'Bukti laporan harus berekstensi jpg atau png',
                'latitude.required' => 'Latitude wajib diisi',
                'longitude.required' => 'Longitude wajib diisi',
                'address.required' => 'Alamat wajib diisi'
            ];
    }
}
