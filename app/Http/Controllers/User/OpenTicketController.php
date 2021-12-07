<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Repositories\Ticket\OpenTicketInterface;
use App\Services\CommonService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OpenTicketController extends Controller
{
    public $ticket;

    public function __construct(OpenTicketInterface $ticket)
    {
        $this->ticket = $ticket;
    }

    public function myTicket(Request $request)
    {
        if ($request->ajax()) {
            $data = $this->ticket->MyTicketList();
            return response()->json($data, 200);
        }

        return view('pages.user.ticket.index');
    }

    public function detailTicket($id)
    {
        $data['ticket'] = $this->ticket->DetailTicket($id);
        return view('pages.user.ticket.detail-ticket', $data);
    }

    public function createTicket()
    {
        return view('pages.user.ticket.form-ticket');
    }

    public function storeTicket(Request $request)
    {
        $request->validate([
            'title'     => ['required'],
            'content'   => ['required'],
            'priority'  => ['required'],
        ], [
            'title.required'    => 'Harap Mengisi Judul',
            'content.required'  => 'Harap Mengisi Content',
            'priority.required' => 'Harap mengisi priority',
        ]);

        DB::beginTransaction();
        try {
            $input = $request->all();
            $input['user_id']   = Auth::id();
            $input['ticket_id'] = '#'.time();
            $this->ticket->CreateTicket($input);
            $users = User::role('superadmin')->get();
            $notification = new CommonService();
            foreach ($users as $user) {
                $notification->sendNotifictionToUser($user->id, 'User Ticket', 'User '. Auth::user()->email. ' telah membuat ticket baru');
            }
            DB::commit();
            return redirect()->back()->with('success','Tiket terlah berhasil dibuat. Mohon menunggu proses selanjutnya');
        } catch (\Exception $err) {
            DB::rollBack();
            dd($err->getMessage());
            return redirect()->back()->with('errors','Terjadi kesalahan. Mohon ulangi');
        }
    }
}
