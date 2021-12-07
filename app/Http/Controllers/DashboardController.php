<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = User::find(Auth::id());

        return view('pages.dashboard',compact('user'));
    }

    public function countNotification() 
    {
        $totalNotif = Notification::where([
            'user_id' => Auth::id(),
            'status'  => NOTIF_NOT_READ,
        ])->count();
        return response()->json( [
            'data' => $totalNotif
        ], 200);
    }

    public function readAllNotif()
    {
        Notification::where('user_id', Auth::id())->where('status', NOTIF_NOT_READ)->update([
            'status' => NOTIF_READ
        ]);
        return response()->json( [
            'data' => true
        ], 200);
    }

    public function countNotReadChat()
    {
        $totalChat = Chat::where('to_user_id', Auth::id())->where('read_at', null)->count();
        return response()->json([
            'data' => $totalChat
        ],200);
    }
}
