<?php

namespace App\Repositories\UserTopupBalance;

use App\Models\HistoryBalance;
use App\Models\TopupTransactionUser;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;

class UserTopupBalanceRepository extends BaseRepository implements UserTopupBalanceInterface
{
    /**
    * @var ModelName
    */
    protected $model, $history;

    public function __construct(TopupTransactionUser $model, HistoryBalance $history)
    {
      $this->model = $model;
      $this->history = $history;
    }

    public function ListTopupHistory()
    {
      return $this->model->with('AdminBank')->with('User')->get()->toArray();
    }

    public function ListHistoryUsedBalance()
    {
      return $this->history->where('user_id', Auth::id())->get();
    }


    public function UserListPendingTopup($userId)
    {
      return $this->model->where('user_id', $userId)->where('status', TOPUP_PENDING)->get();
    }

    public function GetTopup($uuid) 
    {
      return $this->model->where('uuid', $uuid)->first();
    }

    public function UserTopupHistory($userId)
    {
      return $this->model->where('user_id', $userId)->with('AdminBank')->get()->toArray();
    }

    public function ListPendingTopup()
    {
      return $this->model->where('status', TOPUP_PENDING)->get();
    }

    public function ProcessTopup(array $data)
    {
      return $this->model->create($data);
    }

    public function UpdateStatusTopup($status, $uuid)
    {
      return $this->model->where('uuid', $uuid)->first()->update(['status' => $status, 'approved_date' => Date::now()]);
    }

    public function CountPendingTopup()
    {
      return $this->model->where('status', TOPUP_PENDING)->count();
    }

}