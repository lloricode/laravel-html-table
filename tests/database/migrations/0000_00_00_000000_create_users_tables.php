<?php

use Carbon\Carbon;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_tests', function ($table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email');
            $table->string('slug');
            $table->string('password');

            $table->timestamps();
        });

        $now = Carbon::now();

        \DB::table('user_tests')->insert([
            'name' => 'Orchestra',
            'email' => 'hello@orchestraplatform.com',
            'slug' => str_slug('Orchestra orchestraplatform'),
            'password' => \Hash::make('456'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        \DB::table('user_tests')->insert([            
            'name' => 'Lloric',
            'email' => 'lloricode@gmail.com',
            'slug' => str_slug('Lloric Garcia'),
            'password' => \Hash::make('1234'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('user_tests');
    }
}
