<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDescColumnToHistoryBalanceControl extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('history_balance_control', function (Blueprint $table) {
            $table->text('desc')->nullable()->after('balance_used');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('history_balance_control', function (Blueprint $table) {
            $table->dropColumn('desc');
        });
    }
}
