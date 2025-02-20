<?php

namespace App\Http\Requests\Report;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class UpdateReportRequest extends FormRequest
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
            'title' => ['required', 'max:30'],
            'description' => ['required', 'max:255'],
            'image' => ['nullable', 'mimes:jpg,png'],
            'latitude' => ['required', 'max:255'],
            'longitude' => ['required', 'max:255'],
            'address' => ['required', 'max:255']
        ];
    }

    public function messages()
    {
        return
            [
                'latitude.max' => 'Latitude max 255 karakter',
                'longitude.max' => 'Longitude max 255 karakter',
                'address.max' => 'Alamat max 255 karakter',
                'resident_id.required' => 'Pelapor wajib diisi',
                'description.max' => 'Deskripsi max 255 karakter',
                'resident_id.exists' => 'Pelapor tidak ditemukan',
                'report_category_id.required' => 'Kategori laporan wajib diisi',
                'report_category_id.exists' => 'Kategori laporan tidak ditemukan',
                'title.required' => 'Judul laporan wajib diisi',
                'title.max' => 'Judul laporan tidak boleh lebih dari 30 karakter',
                'description.required' => 'Deskripsi laporan wajib diisi',
                'image.mimes' => 'Bukti laporan harus berekstensi jpg atau png',
                'latitude.required' => 'Latitude wajib diisi',
                'longitude.required' => 'Longitude wajib diisi',
                'address.required' => 'Alamat wajib diisi'
            ];
    }
}
