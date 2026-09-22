<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateNilaiRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isGuru() ?? false;
    }

    public function rules(): array
    {
        $nilai = $this->route('nilai');

        return [
            'semester' => ['required', 'integer', 'min:1', 'max:12'],
            'tahun_ajaran' => ['required', 'string', 'max:20'],
            'jenis_nilai' => [
                'required',
                'in:tugas,uts,uas',
                // Cegah duplikat saat update, kecuali record dirinya sendiri
                Rule::unique('nilai')->where(function ($query) use ($nilai) {
                    return $query
                        ->where('siswa_id', $nilai?->siswa_id)
                        ->where('semester', $this->input('semester'))
                        ->where('tahun_ajaran', $this->input('tahun_ajaran'));
                })->ignore($nilai?->id),
            ],
            'nilai' => ['required', 'numeric', 'min:0', 'max:100'],
            'keterangan' => ['nullable', 'string', 'max:500'],
        ];
    }

    public function messages(): array
    {
        return [
            'jenis_nilai.unique' => 'Nilai jenis ini untuk siswa, semester, dan tahun ajaran tersebut sudah ada.',
        ];
    }
}
