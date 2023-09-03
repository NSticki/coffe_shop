<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOptionCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('option_categories', function (Blueprint $table) {
            $table->id();
            $table->string('guid')->unique()->nullable()->default(null);
            $table->string('name')->default('Название');
            $table->string('parent_id')->nullable()->default(null);
            $table->integer('sort_order')->default(1000);
            $table->integer('min_amount')->nullable();
            $table->integer('max_amount')->nullable();
            $table->integer('required')->nullable()->default(null);
            $table->timestamps();
        });


        Schema::table('options', function (Blueprint $table){
            $table->foreign('parent_id')
                ->references('id')
                ->on('option_categories')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('options',function (Blueprint $table){
            $table->dropForeign('options_parent_id_foreign');
        });
        Schema::dropIfExists('option_categories');
    }
}
