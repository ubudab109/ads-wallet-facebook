<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Repositories\UserBank\UserBankInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class BankController extends Controller
{
    public $bank;

    public function __construct(UserBankInterface $bank)
    {
        $this->bank = $bank;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = $this->bank->ListBankUser();
            return response()->json($data, 200);
        }

        return view('pages.user.bank.index');
    }

    public function detailBank($id)
    {
        $data = $this->bank->DetailBank($id);
        return response()->json($data, 200);
    }
    
    public function addBank(Request $request)
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
            $input['user_id'] = Auth::id();
            $this->bank->CreateBank($input);
            DB::commit();
            return redirect()->back()->with('success','Bank Berhasil Ditambahkan');
        } catch (\Exception $err) {
            DB::rollBack();
            return redirect()->back()->with('errors','Terjadi Kesalah. Mohon Diulangi');
        }
    }

    public function deleteBank($id)
    {
        DB::beginTransaction();
        try {
            $this->bank->DeleteBank($id);
            DB::commit();
            return response()->json(true, 200);
        } catch (\Exception $err) {
            DB::rollBack();
            return response()->json(false, 500);
        }
    }

    
}
