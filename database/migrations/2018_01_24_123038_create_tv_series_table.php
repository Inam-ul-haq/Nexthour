<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTvSeriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tv_series', function (Blueprint $table) {
          $table->increments('id');
          $table->string('title');
          $table->string('tmdb_id')->nullable();
          $table->char('tmdb')->nullable();
          $table->string('thumbnail')->nullable();
          $table->string('poster')->nullable();
          $table->string('genre_id')->nullable();
          $table->text('detail')->nullable();
          $table->float('rating')->nullable();
          $table->float('episode_runtime')->nullable();
          $table->string('maturity_rating')->nullable();
          $table->boolean('featured')->default(0);
          $table->char('type')->default('T');
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
        Schema::dropIfExists('tv_series');
    }
}
