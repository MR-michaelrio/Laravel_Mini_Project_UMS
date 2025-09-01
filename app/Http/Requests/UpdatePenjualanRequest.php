<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePenjualanRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nota' => 'required|string|unique:penjualans,nota,' . $this->penjualan->id,
            'tgl' => 'required|string',
            'kode_pelanggan' => 'required|string|exists:pelanggans,kode',
            'items' => 'required|array|min:1',
            'items.*.kode_barang' => 'required|string|exists:barangs,kode',
            'items.*.qty' => 'required|integer|min:1',
        ];
    }
}
