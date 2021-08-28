<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CouponRequest extends FormRequest
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
            'code'      => 'required',
            'expired_date'  => 'required|date',
            'amount' => 'required|numeric'
        ];
    }

    public function messages(){
        return [
            'code.required' => 'Kode kupon wajib di isi',
            'expired_date.required' => 'Tanggal kadaluarsa wajib di isi',
            'expired_date.date' => 'Format tanggal tidak dikenali',
            'amount.required' => 'Jumlah potongan ada wajib diisi',
            'amount.numeric' => 'Input hanya bilangan bulat'
        ];
    }
}
