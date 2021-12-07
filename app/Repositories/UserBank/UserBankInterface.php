<?php

namespace App\Repositories\UserBank;

interface UserBankInterface
{
  public function ListBankUser();
  public function DetailBank($id);
  public function CreateBank(array $data);
  public function UpdateBank($id, array $data);
  public function DeleteBank($id);
}