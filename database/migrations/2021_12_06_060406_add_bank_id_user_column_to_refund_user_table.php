<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBankIdUserColumnToRefundUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('refund_user', function (Blueprint $table) {
            $table->unsignedBigInteger('bank_user_id')->after('user_id');
            $table->foreign('bank_user_id')->on('bank_user')->references('id')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('refund_user', function (Blueprint $table) {
            $table->dropColumn('bank_user_id');
        });
    }
}
