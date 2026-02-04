<?php

namespace App\Http\Requests\Lead;

use App\Enums\StatusProspek;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateLeadRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nama_customer' => 'required|string|max:100',
            'no_hp' => 'required|string|max:20',
            'status_prospek' => ['required', Rule::enum(StatusProspek::class)],
            'fase_followup' => 'nullable|integer|min:0|max:3',
            'tgl_next_followup' => 'nullable|date',
            'catatan_terakhir' => 'nullable|string',
            'assigned_to' => 'nullable|exists:users,id',
        ];
    }

    public function messages(): array
    {
        return [
            'nama_customer.required' => 'Nama customer wajib diisi.',
            'nama_customer.max' => 'Nama customer maksimal 100 karakter.',
            'no_hp.required' => 'No HP wajib diisi.',
            'no_hp.max' => 'No HP maksimal 20 karakter.',
            'status_prospek.required' => 'Status prospek wajib dipilih.',
            'assigned_to.exists' => 'Marketing tidak valid.',
        ];
    }
}
