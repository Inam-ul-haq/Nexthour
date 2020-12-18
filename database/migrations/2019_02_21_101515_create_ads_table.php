<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ads', function (Blueprint $table) {
            $table->increments('id');
            $table->string('ad_type');
            $table->string('ad_image');
            $table->string('ad_video');
            $table->string('ad_url')->nullable();
            $table->string('ad_location');
            $table->string('ad_target')->nullable();
            $table->string('ad_hold')->nullable();
            $table->string('time')->nullable();
            $table->string('endtime')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ads');
    }
}
