<?php

namespace App\Repositories\AdminSetting;

interface AdminSettingInterface
{
    public function GetSetting($slug);
    public function UpdateSetting($slug, $value);
    public function SaveEmailSetting($request);
    public function SaveAppsSetting($request);
    public function SaveTopupSetting($request);
}