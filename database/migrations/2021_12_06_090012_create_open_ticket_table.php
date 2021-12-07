<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOpenTicketTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('open_ticket', function (Blueprint $table) {
            $table->id();
            $table->string('ticket_id')->unique();
            $table->unsignedBigInteger('user_id');
            $table->string('title');
            $table->longText('content');
            $table->integer('status')->default(0);
            $table->integer('priority');
            $table->timestamps();

            $table->foreign('user_id')->on('users')->references('id')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('open_ticket');
    }
}
