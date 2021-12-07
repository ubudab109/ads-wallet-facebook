<?php

namespace App\Repositories\RefundUser;

interface RefundUserInterface
{
  public function ListPendingRefund();
  public function ListApprovedRefund();
  public function ListRejectedRefund();
  public function ProcessRefundUser(array $data);
  public function ApproveRefundUser($transactionId, $file);
  public function RejectRefundUser($transactionId);
  public function DetailRefundUser($transactionId);
  public function HistoryMyRefund();
  public function HistoryUserRefund();
}