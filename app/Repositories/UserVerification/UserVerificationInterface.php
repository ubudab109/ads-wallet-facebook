<?php

namespace App\Repositories\UserVerification;

interface UserVerificationInterface
{
  public function GenerateVerification($userId, $code);
  public function DeleteVerification($userId);
  public function GetVerificationEmailCode($code);
  public function GetVerificationForgotPasswordCode($code);
  public function GetVerificationForgotPasswordUser($userId);
  public function GenerateVerificationForgotPassword($userId, $code);
  public function DeleteVerificationForgotPassword($userId);
  public function UpdateStatusVerification($code, $type);
}