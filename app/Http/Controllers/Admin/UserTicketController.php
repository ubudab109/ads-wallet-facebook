<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\Ticket\OpenTicketInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserTicketController extends Controller
{
    public $ticket;

    public function __construct(OpenTicketInterface $ticket)
    {
        $this->ticket = $ticket;
    }

    public function userTicket(Request $request)
    {
        if ($request->ajax()) {
            $data = $this->ticket->UserTicketList();
            return response()->json($data, 200);
        }

        return view('pages.admin.ticket.index');
    }

    public function detailTicketUser($id)
    {
        $data['ticket'] = $this->ticket->DetailTicket($id);
        return view('pages.admin.ticket.detail-ticket', $data);
    }

    public function updateTicket(Request $request, $id)
    {
        $status = $request->get('status');

        DB::beginTransaction();
        try {
            if ($status == STATUS_TICKET_IN_PROGRESS) {
                $this->ticket->UpdateStatusTicket($id, STATUS_TICKET_IN_PROGRESS);
            } else if ($status == STATUS_TICKET_FINISHED) {
                $this->ticket->UpdateStatusTicket($id, STATUS_TICKET_FINISHED);
            } else {
                $this->ticket->UpdateStatusTicket($id, STATUS_TICKET_PENDING);
            }
            DB::commit();
            return response()->json(true,200);
        } catch (\Exception $err) {
            dd($err->getMessage());
            DB::rollBack();
            return response()->json($err->getMessage(),500);

        }
    }
}
