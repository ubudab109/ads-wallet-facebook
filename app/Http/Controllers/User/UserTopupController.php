<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\TopupRequest;
use App\Models\TopupTransactionUser;
use App\Models\User;
use App\Repositories\Admin\AdminBankInterface;
use App\Repositories\UserTopupBalance\UserTopupBalanceInterface;
use App\Services\CommonService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class UserTopupController extends Controller
{
    public $topup, $adminBank;

    public function __construct(UserTopupBalanceInterface $topup, AdminBankInterface $adminBank)
    {
        $this->topup = $topup;
        $this->adminBank = $adminBank;
    }

    public function uploadInvoice(Request $request)
    {
        try {
            uploadimage($request->file('file'),'user-topup/');
            // dd($request);
            $data['success'] = 1;
            $data['message'] = 'File uploaded.'; 
            return response()->json($data,200);
        } catch (\Exception $err) {
            $data['success'] = 0;
            $data['message'] = 'File not uploaded.'; 
            return response()->json($data, 500);
        }
        
    }

    public function deleteInvoice(Request $request) 
    {   
        try {
            deleteimage('user-topup/', $request->file);
            $data['success'] = 1;
            $data['message'] = 'File Deleted.'; 
            return response()->json($data,200);
        } catch (\Exception $err) {
            $data['success'] = 0;
            $data['message'] = $err->getMessage(); 
            return response()->json($data, 500);
        }
    }   

    public function topupView()
    {
        $adminBank = $this->adminBank->ListBankAdmin();
        return view('pages.user.balance.topup', compact('adminBank'));
    }

    public function getBankAdmin($id)
    {
        $bank = $this->adminBank->GetDetailBankAdmin($id);
        return response()->json($bank, 200);
    }

    public function topupHistory(Request $request)
    {
        if ($request->ajax()) {
            $data = $this->topup->UserTopupHistory(Auth::id());
            return response()->json($data, 200);
        }

        return view('pages.user.balance.history-topup');
    }

    public function historyBalance(Request $request) 
    {
        if ($request->ajax()) {
            $data = $this->topup->ListHistoryUsedBalance();
            return response()->json($data, 200);
        }

        return view('pages.user.balance.history-balance');
    }

    public function getDollarKurs()
    {
        try {

            $api = "https://v6.exchangerate-api.com/v6/f9df450e6a172f16c5ec3964/pair/USD/IDR";
            $kurs = file_get_contents("$api");
            $data = json_decode($kurs);
    
            return response()->json($data, 200);
        } catch (\Exception $err) {
            return response()->json($err->getMessage());
        }

    }


    public function topupProcess(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'bank_sleep'        => ['required'],
            'amount_topup'      => ['required'],
            'dollar_amount'     => ['required'],
            'admin_bank_id'     => ['required'],
        ] , [
            'bank_sleep.required'       => 'Harap upload bukti pembayaran Anda',
            'bank_sleep.mimes'          => 'Format upload hanya memperbolehkan JPEG, PNG dan JPG',
            'bank_sleep.max'            => 'Maximal upload gambar 2MB',
            'amount_topup.required'     => 'Mohon memasukan jumlah topup Anda',
            'admin_bank_id.required'    => 'Harap pilih Bank yang akan ditransfer',
        ]);

        if ($validator->fails()) {
            return response()->json(['data' => $validator->errors()] ,400);

        }
        $adminFee = settings('topup_fee_percent');
        $input = $request->all();
        DB::beginTransaction();
        try {
            $minimumTopup = allsetting('topup_minimum');
            if ($input['amount_topup'] < $minimumTopup) {
                return response()->json(['data' => 'Minimum Topup Rp .'.number_format($minimumTopup,0)] ,400);
            }
            $fee = $adminFee / 100;
            $feeTopup = $input['amount_topup'] * $fee;
            $totalTopup = $input['amount_topup'] + $feeTopup;
            $input['total_topup'] = $totalTopup;
            $input['transaction_id'] = 'TOPUP-'. Auth::user()->name .'-'. time();
            $input['user_id'] = Auth::id();

            $users = User::role('superadmin')->get();
            $notification = new CommonService();
            
            foreach ($users as $user) {
                $notification->sendNotifictionToUser($user->id, 'User Topup', 'User '. Auth::user()->email. ' telah melakukan topup');
            }
            TopupTransactionUser::create($input);
            DB::commit();
            return response()->json(['data' => 'Sukses, Silahkan menunggu konfirmasi Admin'] ,200);
        } catch (\Exception $err) {
            DB::rollBack();
            return response()->json(['data' => $err->getMessage()] ,500);
        }
    }
}
