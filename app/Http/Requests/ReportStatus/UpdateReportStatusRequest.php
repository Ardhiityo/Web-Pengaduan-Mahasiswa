<?php

namespace App\Http\Requests\ReportStatus;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class UpdateReportStatusRequest extends FormRequest
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
            'report_id' => ['required', 'exists:reports,id'],
            'image' => ['nullable', 'mimes:jpg,png'],
            'status' => ['required'],
            'description' => ['required']
        ];
    }

    public function messages()
    {
        return [
            'report_id.required' => 'Kode laporan wajib diisi',
            'report_id.exists' => 'Kode laporan tidak ditemukan',
            'image.mimes' => 'Bukti laporan harus berekstensi jpg atau png',
            'status.required' => 'Status laporan wajib diisi.',
            'description.required' => 'Deskripsi laporan wajib diisi.',
        ];
    }
}
