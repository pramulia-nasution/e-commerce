<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
            'categories'  => 'required',
            'price' => 'required|numeric',
            'image_id'  => 'required|numeric',
            'weight'    => 'required|numeric',
            'description'   => 'required'
        ];
    }

    public function messages(){
        return [
            'name.required' => 'Nama Atribut wajib di isi',
            'name.string'   => 'Format input harus string',
            'categories.required' => 'Pilih setidaknya satu kategori',
            'price.required'    => 'Harga Produk wajib diisi',
            'price.numeric' => 'Harga hanya bilangan bulat tanpa karakter apapun',
            'image_id.required' => 'Gambar utama produk wajib diisi',
            'image_id.numeric' => 'Harap memilih gambar yang sudah tersidia',
            'weight.required' => 'Berat produk wajib diisi',
            'weight.numeric' => 'Berat hanya berupa angka tanpa karakter apapun dalam satuan gr/gram',
            'description.required' => 'Deskripsi produk wajib diisi'
        ];
    }
}
