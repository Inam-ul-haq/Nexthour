<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('configs')->insert([
            'logo' => 'logo.png',
            'w_name' => 'Next Hour',
            'w_email' => 'contact@nexthour.com',
            'title' => 'Next Hour',
            'favicon' => 'favicon.ico',
            'stripe_pub_key' => '',
            'stripe_secret_key' => '',
            'paypal_mar_email' => '',
            'currency_code' => 'usd',
            'currency_symbol' => 'fa fa-dollar',
            'prime_main_slider' => 1,
            'prime_genre_slider' => 1,
            'prime_footer' => 1,
            'prime_movie_single' => 1,
            'copyright' => '© 1996-2018, Amazon.com, Inc. or its affiliates'
        ]);

        DB::table('users')->insert([
            'name' => 'Admin',
            'email' => 'admin@mediacity.co.in',
            'password' => bcrypt('123456'),
            'is_admin' => 1
        ]);
//         $this->call(UsersTableSeeder::class);
    }
}
