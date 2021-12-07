<?php

namespace App\Repositories\RefundUser;

use App\Models\RefundUsers;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\Auth;

class RefundUserRepository extends BaseRepository implements RefundUserInterface
{
    /**
    * @var ModelName
    */
    protected $model;

    public function __construct(RefundUsers $model)
    {
      $this->model = $model;
    }

    public function ListApprovedRefund()
    {
      return $this->model->where('status', REFUND_USER_APPROVED)->with('User')->with('BankUser')->get();
    }

    public function ListPendingRefund()
    {
      return $this->model->where('status', REFUND_USER_PENDING)->with('User')->with('BankUser')->get();
    }

    public function ListRejectedRefund()
    {
      return $this->model->where('status', REFUND_USER_REJECTED)->with('User')->with('BankUser')->get();
    }

    public function ProcessRefundUser(array $data)
    {
      return $this->model->create($data);
    }

    public function ApproveRefundUser($transactionId, $file)
    {
      return $this->model->where('transaction_id', $transactionId)->first()->update([
        'status'  => REFUND_USER_APPROVED,
        'bank_sleep_admin' => $file,
      ]);
    }

    public function RejectRefundUser($transactionId)
    {
      return $this->model->where('transaction_id', $transactionId)->first()->update([
        'status' => REFUND_USER_REJECTED
      ]);
    }

    public function DetailRefundUser($transactionId)
    {
      return $this->model->where('transaction_id', $transactionId)->first();
    }

    public function HistoryMyRefund()
    {
      return $this->model->where('user_id', Auth::id())->with('User')->with('BankUser')->get();
    }

    public function HistoryUserRefund()
    {
      return $this->model->with('User')->with('BankUser')->get();
    }
}