<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConfigsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('configs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('logo')->nullable();
            $table->string('favicon')->nullable();
            $table->string('title')->nullable();
            $table->string('w_name')->nullable();
            $table->string('w_email')->nullable();
            $table->string('stripe_pub_key')->nullable();
            $table->string('stripe_secret_key')->nullable();
            $table->string('paypal_mar_email')->nullable();
            $table->string('currency_code')->nullable();
            $table->string('currency_symbol')->nullabe();
            $table->string('invoice_add')->nullable();
            $table->boolean('prime_main_slider')->default(true);
            $table->boolean('prime_genre_slider')->default(true);
            $table->boolean('prime_footer')->default(true);
            $table->boolean('prime_movie_single')->default(true);
            $table->text('terms_condition')->nullable();
            $table->text('privacy_pol')->nullable();
            $table->text('refund_pol')->nullable();
            $table->text('copyright')->nullable();
            $table->boolean('stripe_payment')->default(true);
            $table->boolean('paypal_payment')->default(true);
            $table->boolean('payu_payment')->default(true);
            $table->boolean('preloader')->default(true);
            $table->boolean('rightclick')->default(true);
            $table->boolean('inspect')->default(ture);
            $table->boolean('goto')->default(true);
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
        Schema::dropIfExists('configs');
    }
}
