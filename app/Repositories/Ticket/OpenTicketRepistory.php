<?php

namespace App\Repositories\Ticket;

use App\Models\OpenTicket;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\Auth;

class OpenTicketRepistory extends BaseRepository implements OpenTicketInterface
{
    /**
    * @var ModelName
    */
    protected $model;

    public function __construct(OpenTicket $model)
    {
      $this->model = $model;
    }

    public function MyTicketList()
    {
      return $this->model->where('user_id', Auth::id())->with('User')->get();
    }

    public function UserTicketList()
    {
      return $this->model->with('User')->get();
    }

    public function CreateTicket(array $data)
    {
      return $this->model->create($data);
    }

    public function DetailTicket($id)
    {
      return $this->model->with('User')->find($id);
    }

    public function DeleteTicket($id)
    {
      return $this->model->find($id)->delete();
    }

    public function UpdateStatusTicket($id, $status)
    {
      return $this->model->find($id)->update([
        'status'  => $status
      ]);
    }
    
}