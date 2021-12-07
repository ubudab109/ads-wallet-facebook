<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Repositories\RefundUser\RefundUserInterface;
use App\Repositories\UserBank\UserBankInterface;
use App\Services\CommonService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class RefundController extends Controller
{
    public $refund, $bank;

    public function __construct(RefundUserInterface $refund, UserBankInterface $bank)
    {
        $this->refund = $refund;
        $this->bank = $bank;
    }

    public function index()
    {
        $data['userBanks'] = $this->bank->ListBankUser();
        return view('pages.user.refund.index', $data);
    }

    public function refund(Request $request)
    {
        $validate = Validator::make($request->all(),[
            'dollar_refund' => ['required'],
            'bank_user_id'       => ['required'],
        ]);

        if ($validate->fails()) {
            return response()->json(false, 400);
        }
        $input = $request->all();
        $input['user_id'] = Auth::id();
        $input['total_refund'] = $request->total_refund;
        $input['transaction_id'] = 'REFUND-'.Auth()->user()->name.time();
        if ($request->dollar_refund > Auth::user()->balance) {
            return response()->json(false, 422);
        }
        DB::beginTransaction();
        try {
            
            $this->refund->ProcessRefundUser($input);
            User::find(Auth::id())->decrement('balance', $request->dollar_refund);
            $users = User::role('superadmin')->get();
            $notification = new CommonService();
            
            foreach ($users as $user) {
                $notification->sendNotifictionToUser($user->id, 'User Refund', 'User '. Auth::user()->email. ' telah melakukan refund');
            }
            DB::commit();
            return response()->json(true, 200);
        } catch (\Exception $err) {
            DB::rollBack();
            return response()->json($err->getMessage(), 500);
        }

    }

    public function historyRefund(Request $request) 
    {
        if ($request->ajax()) {
            $data = $this->refund->HistoryMyRefund();
            return response()->json($data, 200);
        }

        return view('pages.user.refund.history');
    }
}
