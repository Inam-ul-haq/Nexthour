<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMoviesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movies', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('tmdb_id')->nullable();
            $table->string('title');
            $table->string('duration')->nullable();
            $table->string('thumbnail')->nullable();
            $table->string('poster')->nullable();
            $table->char('tmdb')->nullable();
            $table->string('director_id')->nullable();
            $table->string('actor_id')->nullable();
            $table->string('genre_id')->nullable();
            $table->string('trailer_url')->nullable();
            $table->text('detail')->nullable();
            $table->integer('rating')->nullable();
            $table->string('maturity_rating')->nullable();
            $table->boolean('subtitle')->nullable();
            $table->string('subtitle_list')->nullable();
            $table->string('subtitle_files')->nullable();
            $table->integer('publish_year')->nullable();
            $table->string('released')->nullable();
            $table->boolean('featured')->nullable();
            $table->boolean('series')->nullable();
            $table->string('a_language')->nullable();
            $table->string('audio_files')->nullable();
            $table->char('type')->default('M');
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
        Schema::dropIfExists('movies');
    }
}
