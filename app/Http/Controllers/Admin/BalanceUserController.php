<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HistoryBalance;
use App\Models\User;
use App\Services\CommonService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class BalanceUserController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = User::role('member')->with('FormReview')->get();
            return response()->json($data, 200);
        }

        return view('pages.admin.user-balance.index');
    }

    public function detail($uuid)
    {
        $user = User::select('balance')->where('uuid', $uuid)->first();
        return response()->json($user, 200);
    }


    public function controlBalance(Request $request) 
    {
        $validate = Validator::make($request->all(),[
            'balance' => ['required'],
        ]);

        if ($validate->fails()) {
            return response()->json(['data' => $validate->errors()], 422);
        }
        $uuid = $request->get('users_id');
        $user = User::where('uuid', $uuid)->first();
        if ($request->balance > $user->balance) {
            return response()->json(false, 400);
        }
        DB::beginTransaction();
        try {   
            
            
            HistoryBalance::create([
                'user_id'           => $user->id,
                'balance_used'      => $request->balance,
                'desc'              => 'Spending iklan'
            ]);
            $service = new CommonService();
            $service->sendNotifictionToUser($user->id, 'Notifikasi Balance','Balance Anda Telah Digunakan Sebesar $'.number_format($request->balance, 2));
            $user->decrement('balance',$request->balance);
            DB::commit();
            return response()->json(['data' => true], 200);
        } catch (\Exception $err) {
            DB::rollBack();
            return response()->json(['data' => $err->getMessage()], 500);
        }
    }

    public function updateStatusUser(Request $request, $uuid)
    {
        $status = $request->get('status');
        DB::beginTransaction();
        try {
            User::where('uuid', $uuid)->first()->update([
                'status' => $status
            ]);
            DB::commit();
            return response()->json(true, 200);
        } catch (\Exception $err) {
            DB::rollBack();
            return response()->json(false, 500);
        }
    }
}
