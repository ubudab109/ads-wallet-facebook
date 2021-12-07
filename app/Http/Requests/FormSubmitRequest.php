<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FormSubmitRequest extends FormRequest
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
            'applicants_name'           => ['required'],
            'account_type'              => ['required'],
            'account_information'       => ['required'],
            'address'                   => ['required'],
            'company_email'             => ['required','email'],
            'time_zone'                 => ['required'],
            'ads_type'                  => ['required'],
            'ads_type_other'            => ['required_if:ads_type,==,0'],
            'cost_spending'             => ['required'],
            'account_ads_name'          => ['required'],
            'facebook_home_url'         => ['required'],
            'facebook_app_id'           => ['required'],
            'url_ads'                   => ['required'],
        ];
    }

    public function messages()
    {
        return [
            'applicants_name.required'           => 'Harap mengisi nama pemohon',
            'account_type.required'              => 'Harap memilih tipe akun',
            'account_information.required'       => 'Harap mengisi informasi akun',
            'address.required'                   => 'Harap mengisi alamat lengkap',
            'company_email.required'             => 'Harap email perusahaan',
            'company_email.email'                => 'Email tidak valid',
            'time_zone.required'                 => 'Harap mengisi zona waktu',
            'ads_type.required'                  => 'Harap memilih tipe iklan',
            'ads_type_other.required_if'         => 'Harap mengisi tipe iklan',
            'cost_spending.required'             => 'Harap memilih spending budget iklan bulanan',
            'account_ads_name.required'          => 'Harap mengisi nama akun iklan',
            'facebook_home_url.required'         => 'Harap mengisi URL halaman Facebook',
            'facebook_app_id.required'           => 'Harap mengisi Facebook APP ID',
            'url_ads.required'                   => 'Harap mengisi URL yang akan diiklankan',
        ];
    }
}
