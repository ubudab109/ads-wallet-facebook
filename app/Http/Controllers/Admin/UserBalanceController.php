<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class UserBalanceController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = User::role('member')->get();
            return response()->json($data, 200);
        }

        return view('pages.admin.balance-user.index');
    }

    public function updateBalanceUser(Request $request, $id)
    {
        $validate = Validator::make($request->all(), [
            'balance'   => ['required'],
        ]);

        if ($validate->fails()) {
            return response()->json(['data' => $validate->errors()], 400);
        }

        DB::beginTransaction();
        try {
            User::find($id)->decrement('balance', $request->balance);
            DB::commit();
            return response()->json(['data' => true], 200);
        } catch (\Exception $err) {
            DB::rollBack();
            return response()->json(['data' => false], 500);
        }


    }
}
