<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->string('key')->unique();
            $table->string('value')->nullable();
            $table->timestamps();
        });


        DB::table('settings')->insert(
            array(
                [
                    'code' => 'config',
                    'key' => 'iiko_key',
                    'value' => '0d1b79c0'
                ],
                [
                    'code' => 'config',
                    'key' => 'iiko_login',
                    'value' => 'webstripe'
                ]
            )
        );
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('settings');
    }
}
