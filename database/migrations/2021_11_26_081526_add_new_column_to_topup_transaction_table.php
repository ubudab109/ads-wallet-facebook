<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewColumnToTopupTransactionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('topup_transaction_user', function (Blueprint $table) {
            $table->string('transaction_id')->nullable()->after('uuid');
            $table->unsignedBigInteger('admin_bank_id')->nullable()->after('transaction_id');
            $table->string('bank_sleep')->nullable()->after('admin_bank_id');

            $table->foreign('admin_bank_id')->on('admin_bank')->references('id')->onDelete('restrict')->onUpdate('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('topup_transaction_user', function (Blueprint $table) {
            //
        });
    }
}
