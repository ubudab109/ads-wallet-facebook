<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserTwoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = User::create([
            'name'                  => 'admin2',
            'uuid'                  => Str::uuid()->toString(),
            'email'                 => 'admin@admin.com',
            'email_verified_at'     => Date::now(),
            'password'              => Hash::make('123123123'),
            'status'                => USER_STATUS_ACTIVE,
            'form_status'           => FORM_REVIEW_ACCEPTED,
        ]);


        $member = User::create([
            'name'                  => 'member2',
            'uuid'                  => Str::uuid()->toString(),
            'email'                 => 'member2@mail.com',
            'email_verified_at'     => Date::now(),
            'password'              => Hash::make('123123123'),
            'status'                => USER_STATUS_ACTIVE,
        ]);

        $admin->assignRole('superadmin');
        $member->assignRole('member');
    }
}
