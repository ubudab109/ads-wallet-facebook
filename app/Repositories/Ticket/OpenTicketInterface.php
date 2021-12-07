<?php

namespace App\Repositories\Ticket;

interface OpenTicketInterface
{
  public function MyTicketList();
  public function UserTicketList();
  public function CreateTicket(array $data);
  public function DetailTicket($id);
  public function DeleteTicket($id);
  public function UpdateStatusTicket($id, $status);
}