<?php

namespace Database\Seeders;

use App\Models\AdminBank;
use Illuminate\Database\Seeder;

class AdminBankSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        AdminBank::insert([
            'bank_name'             => 'BCA',
            'bank_number'           => '545843243',
            'account_holder_bank'   => 'PT. XYZ',
        ]);
    }
}
