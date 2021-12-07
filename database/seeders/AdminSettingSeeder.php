<?php

namespace Database\Seeders;

use App\Models\AdminSetting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Date;

class AdminSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        AdminSetting::insert([
            [
                'slug'          => 'topup_minimum',
                'value'         => '0',
                'created_at'    => Date::now(),
                'updated_at'    => Date::now(),
            ],
            [
                'slug'      => 'topup_fee_percent',
                'value'     => '10',
                'created_at'    => Date::now(),
                'updated_at'    => Date::now(),
            ],
            [
                'slug'      => 'refund_minimum',
                'value'     => '10',
                'created_at'    => Date::now(),
                'updated_at'    => Date::now(),
            ],
            [
                'slug'      => 'mail_driver',
                'value'     => 'SMTP',
                'created_at'    => Date::now(),
                'updated_at'    => Date::now(),
            ],
            [
                'slug'      => 'mail_host',
                'value'     => 'smtp.mailtrap.io',
                'created_at'    => Date::now(),
                'updated_at'    => Date::now(),
            ],
            [
                'slug'      => 'mail_port',
                'value'     => '2525',
                'created_at'    => Date::now(),
                'updated_at'    => Date::now(),
            ],
            [
                'slug'      => 'mail_username',
                'value'     => 'web@mail.host',
                'created_at'    => Date::now(),
                'updated_at'    => Date::now(),
            ],
            [
                'slug'      => 'mail_password',
                'value'     => '123123213',
                'created_at'    => Date::now(),
                'updated_at'    => Date::now(),
            ],
            [
                'slug'      => 'mail_encryption',
                'value'     => 'ssl',
                'created_at'    => Date::now(),
                'updated_at'    => Date::now(),
            ],
            [
                'slug'      => 'mail_from_address',
                'value'     => 'web@mail.host',
                'created_at'    => Date::now(),
                'updated_at'    => Date::now(),
            ],
            [
                'slug'      => 'app_title',
                'value'     => 'Ads Facebook',
                'created_at'    => Date::now(),
                'updated_at'    => Date::now(),
            ],
            [
                'slug'      => 'logo',
                'value'     => null,
                'created_at'    => Date::now(),
                'updated_at'    => Date::now(),
            ],
            [
                'slug'      => 'company_name',
                'value'     => 'Ads Facebook',
                'created_at'    => Date::now(),
                'updated_at'    => Date::now(),
            ],
            
        ]);
    }
}
