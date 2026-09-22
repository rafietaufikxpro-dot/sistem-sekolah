<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreNilaiRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isGuru() ?? false;
    }

    public function rules(): array
    {
        return [
            'siswa_id' => ['required', 'exists:siswa,id'],
            'semester' => ['required', 'integer', 'min:1', 'max:12'],
            'tahun_ajaran' => ['required', 'string', 'max:20'],
            'jenis_nilai' => ['required', 'in:tugas,uts,uas'],
            'nilai' => ['required', 'numeric', 'min:0', 'max:100'],
            'keterangan' => ['nullable', 'string', 'max:500'],
            // Cegah duplikat di level aplikasi
            'jenis_nilai' => [
                'required',
                'in:tugas,uts,uas',
                Rule::unique('nilai')->where(function ($query) {
                    return $query
                        ->where('siswa_id', $this->input('siswa_id'))
                        ->where('semester', $this->input('semester'))
                        ->where('tahun_ajaran', $this->input('tahun_ajaran'));
                }),
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'jenis_nilai.unique' => 'Nilai jenis ini untuk siswa, semester, dan tahun ajaran tersebut sudah ada.',
        ];
    }
}
