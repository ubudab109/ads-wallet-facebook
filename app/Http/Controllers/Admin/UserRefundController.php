<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Repositories\RefundUser\RefundUserInterface;
use App\Services\CommonService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class UserRefundController extends Controller
{
    public $refund;

    public function __construct(RefundUserInterface $refund)
    {
        $this->refund = $refund;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = $this->refund->HistoryUserRefund();
            return response()->json($data, 200);
        }

        return view('pages.admin.refund.history-refund');
    }

    public function rejectRefund($transactionId)
    {
        $refund = $this->refund->DetailRefundUser($transactionId);
        DB::beginTransaction();
        try {
            $this->refund->RejectRefundUser($transactionId);
            User::find($refund->user_id)->increment('balance', $refund->dollar_refund);
    
            $notification = new CommonService();
            $notification->sendNotifictionToUser($refund->user_id, 'Status Refund','Status refund Anda dengan transaksi id '. $refund->transaction_id.' telah di '.strtoupper(RefundUserStatus(REFUND_USER_REJECTED)).' saldo Anda telah dikembalikan');
            DB::commit();
            return response()->json(true, 200);
        } catch (\Exception $err) {
            DB::rollBack();
            return response()->json($err->getMessage(), 500);
        }
    }

    public function uploadBankSleep(Request $request)
    {
        try {
            uploadimage($request->file('file'),'user-refund/');
            $data['success'] = 1;
            $data['message'] = 'File uploaded.'; 
            return response()->json($data,200);
        } catch (\Exception $err) {
            $data['success'] = 0;
            $data['message'] = $err->getMessage(); 
            return response()->json($data, 500);
        }
    }

    public function deleteInvoice(Request $request) 
    {   
        try {
            deleteimage('user-refund/', $request->file);
            $data['success'] = 1;
            $data['message'] = 'File Deleted.'; 
            return response()->json($data,200);
        } catch (\Exception $err) {
            $data['success'] = 0;
            $data['message'] = $err->getMessage(); 
            return response()->json($data, 500);
        }
    }

    public function approveRefund(Request $request, $transactionId)
    {
        $validate = Validator::make($request->all(),[
            'bank_sleep_admin' => ['required'],
        ]);

        if ($validate->fails()) {
            return response()->json(false, 400);
        }
        $refund = $this->refund->DetailRefundUser($transactionId);
        DB::beginTransaction();
        try {
            $this->refund->ApproveRefundUser($transactionId, $request->bank_sleep_admin);
            $notification = new CommonService();
            $notification->sendNotifictionToUser($refund->user_id, 'Status Refund','Status refund Anda dengan transaksi id '. $refund->transaction_id.' telah di '.strtoupper(RefundUserStatus(REFUND_USER_APPROVED)));
            DB::commit();
            return response()->json(true, 200);
        } catch (\Exception $err) {
            DB::rollBack();
            return response()->json($err->getMessage(), 500);
        }
    }
}
