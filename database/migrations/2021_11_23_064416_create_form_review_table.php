<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFormReviewTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('form_review', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->integer('account_type');
            $table->string('account_information');
            $table->string('address');
            $table->string('company_email');
            $table->string('time_zone');
            $table->string('ads_type');
            $table->integer('cost_spending');
            $table->string('company_website')->nullable();
            $table->string('account_ads_name');
            $table->string('facebook_home_url');
            $table->string('facebook_app_id')->nullable();
            $table->string('url_ads');
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
        Schema::dropIfExists('form_review');
    }
}
