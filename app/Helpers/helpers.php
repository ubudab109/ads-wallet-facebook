<?php

use App\Models\AdminSetting;
use Intervention\Image\Facades\Image;

function BadgeUserStatus($input) {
  if ($input == USER_STATUS_ACTIVE) {
    $html = '<span class="badge badge-success">'.UserStatus($input).'</span>';
  } else if ($input == USER_STATUS_NON_ACTIVE) {
    $html = '<span class="badge badge-danger">'.UserStatus($input).'</span>';
  } else if ($input == USER_STATUS_RESTRICTED) {
    $html = '<span class="badge badge-warning">'.UserStatus($input).'</span>';
  }

  return $html;
}


function BadgeFormStatus($input) {
  if ($input == FORM_REVIEW_PENDING) {
    $html = '<span class="badge badge-warning">'.FormReviewStatus($input).'</span>';
  } else if ($input == FORM_REVIEW_ACCEPTED) {
    $html = '<span class="badge badge-success">'.FormReviewStatus($input).'</span>';
  } else if ($input == FORM_REVIEW_REJECTED) {
    $html = '<span class="badge badge-danger">'.FormReviewStatus($input).'</span>';
  } else if ($input == FORM_REVIEW_NOT_APPLICANT) {
    $html = '<span class="badge badge-info">'.FormReviewStatus($input).'</span>';

  }

  return $html;
}

function BadgeTopupStatus($input) {
  if ($input == TOPUP_PENDING) {
    $html = '<span class="badge badge-info">'.TopupStatus($input).'</span>';
  } else if ($input == TOPUP_APPROVED) {
    $html = '<span class="badge badge-success">'.TopupStatus($input).'</span>';
  } else if ($input == TOPUP_REJECTED) {
    $html = '<span class="badge badge-danger">'.TopupStatus($input).'</span>';
  }

  return $html;
}

function FontTopupStatus($input) {
  if ($input == TOPUP_PENDING) {
    $html = '<span class="text-theme-12">'.TopupStatus($input).'</span>';
  } else if ($input == TOPUP_APPROVED) {
    $html = '<span class="badge text-theme-9">'.TopupStatus($input).'</span>';
  } else if ($input == TOPUP_REJECTED) {
    $html = '<span class="badge text-theme-6">'.TopupStatus($input).'</span>';
  }

  return $html;
}

/**
 * @param null $array
 * @return array|bool
 */
function allsetting($array = null)
{
    if (!isset($array[0])) {
        $allsettings = AdminSetting::get();
        if ($allsettings) {
            $output = [];
            foreach ($allsettings as $setting) {
                $output[$setting->slug] = $setting->value;
            }
            return $output;
        }
        return false;
    } elseif (is_array($array)) {
        $allsettings = AdminSetting::whereIn('slug', $array)->get();
        if ($allsettings) {
            $output = [];
            foreach ($allsettings as $setting) {
                $output[$setting->slug] = $setting->value;
            }
            return $output;
        }
        return false;
    } else {
        $allsettings = AdminSetting::where(['slug' => $array])->first();
        if ($allsettings) {
            $output = $allsettings->value;
            return $output;
        }
        return false;
    }
}

if (!function_exists('settings')) {

  function settings($keys = null)
  {
      if ($keys && is_array($keys)) {
          return AdminSetting::whereIn('slug', $keys)->pluck('value', 'slug')->toArray();
      } elseif ($keys && is_string($keys)) {
          $setting = AdminSetting::where('slug', $keys)->first();
          return empty($setting) ? false : $setting->value;
      }
      return AdminSetting::pluck('value', 'slug')->toArray();
  }
}
function generate_email_verification_key()
{
  $pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

  return substr(str_shuffle(str_repeat($pool, 5)), 0, 30);
}

function uploadimage($img, $path, $user_file_name = null, $width = null, $height = null)
{

    if (!file_exists($path)) {
        mkdir($path, 0777, true);
    }
    if (isset($user_file_name) && $user_file_name != "" && file_exists($path . $user_file_name)) {
        unlink($path . $user_file_name);
    }
    // saving image in target path
    $imgName = $img->getClientOriginalName();
    $imgPath = public_path($path . $imgName);
    // making image
    $makeImg = Image::make($img)->orientate();
    if ($width != null && $height != null && is_int($width) && is_int($height)) {
        // $makeImg->resize($width, $height);
        $makeImg->fit($width, $height);
    }

    if ($makeImg->save($imgPath)) {
        return $imgName;
    }
    return false;
}


function deleteimage($path, $user_file_name)
{

  if (!file_exists($path)) {
      mkdir($path, 0777, true);
  }
  if (file_exists($path . $user_file_name)) {
      unlink($path . $user_file_name);
  }
  return false;
}

