<?php

namespace App\Http\Requests\News;

use Illuminate\Foundation\Http\FormRequest;

class StoreNewsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'judul' => 'required|string|max:200',
            'isi_berita' => 'required|string',
            'tgl_post' => 'required|date',
        ];
    }

    public function messages(): array
    {
        return [
            'judul.required' => 'Judul wajib diisi.',
            'judul.max' => 'Judul maksimal 200 karakter.',
            'isi_berita.required' => 'Isi berita wajib diisi.',
            'tgl_post.required' => 'Tanggal post wajib diisi.',
            'tgl_post.date' => 'Format tanggal tidak valid.',
        ];
    }
}
