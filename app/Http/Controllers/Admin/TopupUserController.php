<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Repositories\Admin\AdminBankInterface;
use App\Repositories\UserTopupBalance\UserTopupBalanceInterface;
use App\Services\CommonService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TopupUserController extends Controller
{
    public $topup, $adminBank;

    public function __construct(UserTopupBalanceInterface $topup, AdminBankInterface $adminBank)
    {
        $this->topup = $topup;
        $this->adminBank = $adminBank;
    }

    public function topupHistory(Request $request)
    {
        if ($request->ajax()) {
            $data = $this->topup->ListTopupHistory();
            return response()->json($data, 200);
        }

        return view('pages.admin.topup.history-topup');
    }

    public function updateTopup(Request $request, $uuid)
    {
        DB::beginTransaction();
        try {
            $status = $request->get('status');
            $topup = $this->topup->GetTopup($uuid);
            $this->topup->UpdateStatusTopup($status, $uuid);
            if ($status == 1) {
                User::find($topup->user_id)->increment('balance', $topup->dollar_amount);
            }
            $notification = new CommonService();
            $notification->sendNotifictionToUser($topup->user_id, 'Status Topup','Status topup Anda dengan transaksi id '. $topup->transaction_id.' telah di '.strtoupper(TopupStatus($status)));
            DB::commit();
            return response()->json(true, 200);
        } catch (\Exception $err) {
            DB::rollBack();
            return response()->json($err->getMessage().' '. $err->getLine(), 500);

        }
    }
}
