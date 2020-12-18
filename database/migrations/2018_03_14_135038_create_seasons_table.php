<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSeasonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('seasons', function (Blueprint $table) {
          $table->increments('id');
          $table->integer('tv_series_id')->unsigned();
          $table->string('tmdb_id')->nullable();
          $table->bigInteger('season_no');
          $table->char('tmdb')->nullable();
          $table->string('publish_year')->nullable();
          $table->string('thumbnail')->nullable();
          $table->string('poster')->nullable();
          $table->string('actor_id')->nullable();
          $table->string('a_language')->nullable();
          $table->boolean('subtitle')->nullable();
          $table->string('subtitle_list')->nullable();
          $table->text('detail')->nullable();
          $table->boolean('featured')->default(0);
          $table->char('type')->default('S');
          $table->foreign('tv_series_id')->references('id')->on('tv_series')->onDelete('cascade');
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
        Schema::dropIfExists('seasons');
    }
}
