<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReviewPengajuanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isGuru() || $this->user()?->isAdmin();
    }

    public function rules(): array
    {
        return [
            'status' => ['required', 'in:disetujui,ditolak'],
            'catatan_guru' => ['nullable', 'string', 'max:1000'],
        ];
    }
}
