<?php

namespace App\Repositories\AdminSetting;

use App\Models\AdminSetting;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\DB;

class AdminSettingRepository extends BaseRepository implements AdminSettingInterface
{
    /**
    * @var ModelName
    */
    protected $model;

    public function __construct(AdminSetting $model)
    {
      $this->model = $model;
    }

    public function GetSetting($slug)
    {
        return $this->model->where('slug',$slug)->first()->value; 
    }

    public function saveEmailSetting($request)
    {
        // $response = ['success' => false, 'message' => __('Invalid request')];
        DB::beginTransaction();
        try {
            if (isset($request->mail_host)) {
                $this->model->updateOrCreate(['slug' => 'mail_driver'], ['value' => $request->mail_driver]);
            } 
            if (isset($request->mail_host)) {
                $this->model->updateOrCreate(['slug' => 'mail_host'], ['value' => $request->mail_host]);
            }
            if (isset($request->mail_port)) {
                $this->model->updateOrCreate(['slug' => 'mail_port'], ['value' => $request->mail_port]);
            }
            if (isset($request->mail_username)) {
                $this->model->updateOrCreate(['slug' => 'mail_username'], ['value' => $request->mail_username]);
            }
            if (isset($request->mail_password)) {
                $this->model->updateOrCreate(['slug' => 'mail_password'], ['value' => $request->mail_password]);
            }
            if (isset($request->mail_encryption)) {
                $this->model->updateOrCreate(['slug' => 'mail_encryption'], ['value' => $request->mail_encryption]);
            }
            if (isset($request->mail_from_address)) {
                $this->model->updateOrCreate(['slug' => 'mail_from_address'], ['value' => $request->mail_from_address]);
            }
            $response = [
                'success' => true,
                'message' => __('Email setting berhasil diperbarui')
            ];
            DB::commit();
            return $response;
        } catch (\Exception $e) {
            DB::rollBack();
            $response = [
                'success' => false,
                'message' => $e->getMessage()
            ];
            return $response;
        }
        
    }

    public function UpdateSetting($slug, $value)
    {
      return $this->model->updateOrCreate(
        ['slug' => $slug],
        ['value' => $value],
      );
    }

    public function SaveAppsSetting($request)
    {
      $response = ['success' => true, 'messages' => 'Invalid Request'];
      DB::beginTransaction();
      try {
        if (isset($request->logo)) {
          $this->model->updateOrCreate(
            ['slug' => 'logo'],
            ['value' => $request->logo],
          );
        }

        if (isset($request->company_name)) {
          $this->model->updateOrCreate(
            ['slug' => 'company_name'],
            ['value' => $request->company_name],
          );
        }

        $response = [
          'success' => true,
          'message' => __('Setting Apps Berhasil Diperbarui'),
        ];
        DB::commit();
        return $response;
      } catch (\Exception $err) {
        DB::rollBack();
        $response = [
            'success' => false,
            'message' => __('Terjadi Kesalahan. Mohon Diulangi'),
        ];
        return $response;
      }
    }

    public function SaveTopupSetting($request)
    {
      $response = ['success' => false, 'message' => __('Invalid request')];
      DB::beginTransaction();
      try {
        if (isset($request->topup_minimum)) {
          $this->model->updateOrCreate(
            ['slug'  => 'topup_minimum'],
            ['value' => $request->topup_minimum]
          );
        }

        if (isset($request->topup_fee_percent)) {
          $this->model->updateOrCreate(
            ['slug'  => 'topup_fee_percent'],
            ['value' => $request->topup_fee_percent]
          );
        }

        DB::commit();
        $response = [
          'success' => true,
          'message' => __('Setting Topup Berhasil Diperbarui'),
        ];
        return $response;
      } catch (\Exception $err) {
        DB::rollBack();
        $response = [
            'success' => false,
            'message' => __('Terjadi Kesalahan. Mohon Diulangi'),
        ];
        return $response;
      }
    }
}