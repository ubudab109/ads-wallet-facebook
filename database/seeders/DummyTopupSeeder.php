<?php

namespace Database\Seeders;

use App\Models\TopupTransactionUser;
use Illuminate\Database\Seeder;

class DummyTopupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i = 1; $i < 50; $i++) {
            TopupTransactionUser::insert([
                'admin_bank_id' => 1,
                'user_id'   => 5,
                'uuid'  => $i.''.time(),
                'transaction_id' => $i.''.time(),
                'amount_topup' => 1234,
                'total_topup' => 1234,
                'dollar_amount' => 123,
                'bank_sleep' => 'test.jpg'
            ]);
        } 
    }
}
