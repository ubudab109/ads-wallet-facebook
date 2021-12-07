<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = User::create([
            'name'                  => 'superadmin',
            'uuid'                  => Str::uuid()->toString(),
            'email'                 => 'superadmin@admin.com',
            'email_verified_at'     => Date::now(),
            'password'              => Hash::make('123123123'),
            'status'                => USER_STATUS_ACTIVE,
            'form_status'           => FORM_REVIEW_ACCEPTED,
        ]);


        $member = User::create([
            'name'                  => 'member',
            'uuid'                  => Str::uuid()->toString(),
            'email'                 => 'member@mail.com',
            'email_verified_at'     => Date::now(),
            'password'              => Hash::make('123123123'),
            'status'                => USER_STATUS_ACTIVE,
        ]);

        $admin->assignRole('superadmin');
        $member->assignRole('member');
    }
}
