<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePelangganRequest extends FormRequest
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
            'kode' => 'required|string|unique:pelanggans,kode',
            'nama' => 'required|string',
            'domisili' => 'required|string',
            'jenis_kelamin' => 'required|in:PRIA,WANITA',
        ];
    }
}
