<?php

namespace App\Repositories\UserVerification;

use App\Models\UserVerification;
use App\Repositories\BaseRepository;
use Carbon\Carbon;

class UserVerificationRepository extends BaseRepository implements UserVerificationInterface
{
    /**
    * @var ModelName
    */
    protected $model;

    public function __construct(UserVerification $model)
    {
      $this->model = $model;
    }

    public function GenerateVerification($userId, $code)
    {
      $insertModel = $this->model->create([
        'user_id'           => $userId,
        'code'              => $code,
        'expired_at'        => date('Y-m-d', strtotime('+1 days')),
        'verification_type' => VERIFICATION_EMAIL_TYPE,
      ]);

      return $insertModel;
    }

    public function GenerateVerificationForgotPassword($userId, $code)
    {
      $insertModel = $this->model->create([
        'user_id'           => $userId,
        'code'              => $code,
        'expired_at'        => date('Y-m-d', strtotime('+2 days')),
        'verification_type' => VERIFICATION_FORGOT_PASSWORD_TYPE,
      ]);

      return $insertModel;
    }

    public function DeleteVerification($userId)
    {
      return $this->model->where('user_id', $userId)->where('verification_type', VERIFICATION_EMAIL_TYPE)->first()->delete();
    }

    public function DeleteVerificationForgotPassword($userId)
    {
      return $this->model->where('user_id', $userId)->where('verification_type', VERIFICATION_FORGOT_PASSWORD_TYPE)->first()->delete();
    }

    public function GetVerificationEmailCode($code)
    {
      $data = $this->model->where('code', $code)->where('status', EMAIL_VERIFICATION_PENDING)->where('verification_type', VERIFICATION_EMAIL_TYPE)->whereDate('expired_at', '>', Carbon::now())->first();
      return $data;
    }

    public function GetVerificationForgotPasswordCode($code)
    {
      $data = $this->model->where('code', $code)->where('status', EMAIL_VERIFICATION_PENDING)->where('verification_type', VERIFICATION_FORGOT_PASSWORD_TYPE)->whereDate('expired_at', '>', Carbon::now())->first();
      return $data;
    }

    public function GetVerificationForgotPasswordUser($userId)
    {
      $data = $this->model->where('user_id', $userId)->where('status', EMAIL_VERIFICATION_PENDING)->where('verification_type', VERIFICATION_FORGOT_PASSWORD_TYPE)->whereDate('expired_at', '>', Carbon::now())->first();
      return $data;
    }

    public function UpdateStatusVerification($code, $type) 
    {
      $data = $this->model->where('code', $code)->where('status', EMAIL_VERIFICATION_PENDING)->where('verification_type', $type);
      $data->update([
        'status' => EMAIL_VERIFICATION_SUCCESS,
      ]);
      return $data;
    }
}