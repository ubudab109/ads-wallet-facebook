<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TopupRequest extends FormRequest
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
            'bank_sleep'        => ['required'],
            'amount_topup'      => ['required'],
            'dollar_amount'     => ['required'],
            'admin_bank_id'     => ['required'],
        ];
    }

    public function messages()
    {
        return [
            'bank_sleep.required'       => 'Harap upload bukti pembayaran Anda',
            'bank_sleep.mimes'          => 'Format upload hanya memperbolehkan JPEG, PNG dan JPG',
            'bank_sleep.max'            => 'Maximal upload gambar 2MB',
            'amount_topup.required'     => 'Mohon memasukan jumlah topup Anda',
            'admin_bank_id.required'    => 'Harap pilih Bank yang akan ditransfer',
        ];
    }
}
