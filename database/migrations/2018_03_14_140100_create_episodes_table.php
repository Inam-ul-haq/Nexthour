<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEpisodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('episodes', function (Blueprint $table) {
          $table->increments('id');
          $table->integer('seasons_id')->unsigned();
          $table->string('tmdb_id')->nullable();
          $table->integer('episode_no')->nullable();
          $table->string('title');
          $table->char('tmdb')->nullable();
          $table->string('duration')->nullable();
          $table->text('detail')->nullable();
          $table->string('a_language')->nullable();
          $table->boolean('subtitle')->nullable();
          $table->string('subtitle_list')->nullable();
          $table->string('subtitle_files')->nullable();
          $table->string('released')->nullable();
          $table->char('type')->default('E');
          $table->foreign('seasons_id')->references('id')->on('seasons')->onDelete('cascade');
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
        Schema::dropIfExists('episodes');
    }
}
