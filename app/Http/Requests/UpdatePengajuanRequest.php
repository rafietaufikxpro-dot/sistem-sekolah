<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePengajuanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isAdmin() ?? false;
    }

    public function rules(): array
    {
        return [
            'jenis_pengajuan' => ['required', 'string', 'max:255'],
            'keterangan' => ['required', 'string'],
            // Admin tidak bisa reset status ke 'menunggu' jika sudah diproses
            'status' => ['required', 'in:disetujui,ditolak'],
            'catatan_guru' => ['nullable', 'string', 'max:1000'],
        ];
    }
}
