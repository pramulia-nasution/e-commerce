<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ManufacutureRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'      => 'required|string',
            'image_id'  => 'required|numeric',
        ];
    }

    public function messages(){
        return [
            'name.required' => 'Nama brand wajib di isi',
            'name.string'   => 'Format input harus string',
            'image_id.required' => 'Gambar wajib dipilih',
            'image_id.numeric'  => 'Gambar tidak ditemukan',
        ];
    }
}
