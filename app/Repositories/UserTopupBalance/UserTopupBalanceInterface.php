<?php

namespace App\Repositories\UserTopupBalance;

interface UserTopupBalanceInterface
{
    public function ListTopupHistory();
    public function ListHistoryUsedBalance();
    public function ProcessTopup(array $data);
    public function GetTopup($uuid);
    public function CountPendingTopup();
    public function ListPendingTopup();
    public function UserListPendingTopup($userId);
    public function UserTopupHistory($userId);
    public function UpdateStatusTopup($status, $uuid);
}