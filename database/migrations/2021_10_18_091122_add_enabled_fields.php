<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEnabledFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->boolean('is_disabled')->default(false);
        });

        Schema::table('categories', function (Blueprint $table) {
            $table->boolean('is_disabled')->default(false);
        });

        Schema::table('options', function (Blueprint $table) {
            $table->boolean('is_disabled')->default(false);
        });

        Schema::table('option_categories', function (Blueprint $table) {
            $table->boolean('is_disabled')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('is_disabled');
        });

        Schema::table('categories', function (Blueprint $table) {
            $table->dropColumn('is_disabled');
        });

        Schema::table('options', function (Blueprint $table) {
            $table->dropColumn('is_disabled');
        });

        Schema::table('option_categories', function (Blueprint $table) {
            $table->dropColumn('is_disabled');
        });
    }
}
