<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\Admin\AdminBankInterface;
use App\Repositories\AdminSetting\AdminSettingInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AdminSettingController extends Controller
{
    public $setting, $bank;

    public function __construct(AdminBankInterface $bank, AdminSettingInterface $setting)
    {
        $this->bank = $bank;
        $this->setting = $setting;
    }

    public function mailSetting()
    {
        $data['mailDriver'] = $this->setting->GetSetting('mail_driver');
        $data['mailHost'] = $this->setting->GetSetting('mail_host');
        $data['mailPort'] = $this->setting->GetSetting('mail_port');
        $data['mailUsername'] = $this->setting->GetSetting('mail_username');
        $data['mailPassword'] = $this->setting->GetSetting('mail_password');
        $data['mailFromAddress'] = $this->setting->GetSetting('mail_from_address');
        $data['mailEcnryp'] = $this->setting->GetSetting('mail_encryption');

        return view('pages.admin.setting.mail', $data);
    }

    public function topupSetting()
    {
        $data['topup_minimum'] = $this->setting->GetSetting('topup_minimum');
        $data['topup_fee_percent'] = $this->setting->GetSetting('topup_fee_percent');

        return view('pages.admin.setting.topup-setting', $data);
    }

    public function appSetting()
    {
        $data['logo'] = $this->setting->GetSetting('logo');
        $data['company_name'] = $this->setting->GetSetting('company_name');

        return view('pages.admin.setting.apps-setting', $data);
    }

    public function listBank(Request $request)
    {
        if ($request->ajax()) {
            $data = $this->bank->ListBankAdmin();
            return response()->json($data, 200);
        }

        return view('pages.admin.setting.bank');
    }

    public function detailBankAdmin($id)
    {
        $data = $this->bank->GetDetailBankAdmin($id);
        return response()->json($data, 200);
    }

    public function deleteBankAdmin($id)
    {
        DB::beginTransaction();
        try {
            $this->bank->DeleteBankAdmin($id);
            DB::commit();
            return response()->json(true, 200);
        } catch (\Exception $err) {
            DB::rollBack();
            return response()->json($err->getMessage(), 500);
        }
    }


    public function uploadLogo(Request $request)
    {
        try {
            uploadimage($request->file('file'),'company-logo/',allsetting()['logo']);
            // dd($request);
            $data['success'] = 1;
            $data['message'] = 'File uploaded.'; 
            return response()->json($data,200);
        } catch (\Exception $err) {
            $data['success'] = 0;
            $data['message'] = $err->getMessage(); 
            return response()->json($data, 500);
        }
        
    }

    public function deleteLogo(Request $request) 
    {   
        try {
            deleteimage('company-logo/', $request->file);
            $data['success'] = 1;
            $data['message'] = 'File Deleted.'; 
            return response()->json($data,200);
        } catch (\Exception $err) {
            $data['success'] = 0;
            $data['message'] = $err->getMessage(); 
            return response()->json($data, 500);
        }
    }



    public function addBankAdmin(Request $request)
    {
        $validate = Validator::make($request->all(),[
            'bank_name'             => ['required'],
            'bank_number'           => ['required'],
            'account_holder_bank'   => ['required'],
        ]);

        if ($validate->fails()) {
            return redirect()->back()->with('errors', 'Harap Periksa Semua Form');
        }

        DB::beginTransaction();
        try {
            $input = $request->all();
            $this->bank->CreateBankAdmin($input);
            DB::commit();
            return redirect()->back()->with('success', 'Bank Berhasil Ditambahkan');

        } catch (\Exception $err) {
            DB::rollBack();
            return redirect()->back()->with('errors', 'Terjadi Kesalahan. Mohon Diulangi');

        }
    }


    public function updateBankAdmin(Request $request, $id)
    {
        $validate = Validator::make($request->all(),[
            'bank_name'             => ['required'],
            'bank_number'           => ['required'],
            'account_holder_bank'   => ['required'],
        ]);

        if ($validate->fails()) {
            return response()->json(false, 422);
        }

        DB::beginTransaction();
        try {
            $input = $request->all();
            $this->bank->UpdateBankAdmin($id, $input);
            DB::commit();
        } catch (\Exception $err) {
            DB::rollBack();
            return response()->json($err->getMessage(), 500);
        }
    }

    public function saveEmailSetting(Request $request)
    {
        if ($request->post()) {
            $validate = Validator::make($request->all(), [
                'mail_driver' => 'required',
                'mail_host' => 'required',
                'mail_port' => 'required',
                'mail_username' => 'required',
                'mail_password' => 'required',
                'mail_encryption' => 'required',
                'mail_from_address' => 'required',
            ], [
                'mail_host.required'        => 'Mohon untuk mengisi mail host',
                'mail_port.required'        => 'Mohon untuk mengisi mail port',
                'mail_username.required'    => 'Mohon untuk mengisi mail username',
                'mail_password.required'    => 'Mohon untuk mengisi mail password',
                'mail_from_address'         => 'Mohon untuk mengisi mail address',
                'mail_encryption.required'  => 'Mohon untuk mengisi mail encryption',

            ]);

            if ($validate->fails()) {
                $errors = [];
                $errVal = $validate->errors()->all();
                foreach ($errVal as $err) {
                    $errors[] = $err;
                }
                return redirect()->back()->with('error',$errors[0]);
            }
            try {
                $response = $this->setting->SaveEmailSetting($request);
                if ($response['success'] == true) {
                    return redirect()->back()->with('success',$response['message']);
                } else {
                    return redirect()->back()->with('errors',$response['message']);
                }
            } catch (\Exception $err) {
                return redirect()->back()->with('errors','Terjadi Kesalahan. Mohon diulangi');
            }
        }
    }

    public function saveAppSetting(Request $request)
    {
        $rules = [];
        $messages = [];

        if (!empty($request->logo)) {
            $rules['logo'] = ['required'];
            $messages['logo.required'] = 'Mohon untuk upload logo Anda';
        }

        if (!empty($request->company_name)) {
            $rules['company_name'] = ['required'];
            $messages['company_name.required'] = 'Mohon untuk mengisi nama perusahaan Anda';
        }

        $validate = Validator::make($request->all(),$rules,$messages);

        if ($validate->fails()) {
            $errors = [];
            $errVal = $validate->errors()->all();
            foreach ($errVal as $err) {
                $errors[] = $err;
            }

            return redirect()->back()->with('errors', $errors[0]);
        }

        try {
            if ($request->post()) {
                $response = $this->setting->SaveAppsSetting($request);
                if ($response['success'] == true) {
                    return redirect()->back()->with('success', $response['message']);
                } else {
                    return redirect()->back()->with('errors', $response['message']);
                }
            }
        } catch (\Exception $err) {
            return redirect()->back()->with('errors', 'Terjadi Kesalahan. Mohon diulangi');
        }
    }

    public function saveTopupSetting(Request $request)
    {
        $rules = [];
        $messages = [];

        if (!empty($request->topup_minimum)) {
            $rules['topup_minimum'] = ['required','numeric'];
            $messages['topup_minimum.required'] = 'Harap mengisi minimal topup';
            $messages['topup_minimum.numeric'] = 'Inputan hanya boleh berupa angka';
        }

        if (!empty($request->topup_fee_percent)) {
            $rules['topup_fee_percent'] = ['required','numeric'];
            $messages['topup_fee_percent.required'] = 'Harap mengisi fee percent topup';
            $messages['topup_fee_percent.numeric'] = 'Inputan hanya boleh berupa angka';
        }

        $validate = Validator::make($request->all(), $rules, $messages);

        if ($validate->fails()) {
            $errors = [];
            $errVal = $validate->errors()->all();
            foreach ($errVal as $err) {
                $errors[] = $err; 
            }

            return redirect()->back()->with('errors', $errors[0]);
        }

        try {
            $response = $this->setting->SaveTopupSetting($request);
            if ($response['success'] == true) {
                return redirect()->back()->with('success', $response['message']);
            } else {
                return redirect()->back()->with('errros', $response['message']);
            }
        } catch (\Exception $err) {
            return redirect()->back()->with('errors','Terjadi kesalahan mohon diulangi');
        }
    }
}
