<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductToStoreTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_to_stores', function (Blueprint $table){
            $table->id();
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('store_id');
        });

        Schema::table('product_to_stores',function (Blueprint $table){
            $table->foreign('product_id')
                ->references('id')
                ->on('products')
                ->onDelete('cascade');
            $table->foreign('store_id')
                ->references('id')
                ->on('stores')
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
        Schema::table('product_to_stores', function (Blueprint $table){
           $table->dropForeign('product_to_stores_product_id_foreign');
           $table->dropForeign('product_to_stores_store_id_foreign');
        });
        Schema::dropIfExists('product_to_stores');
    }
}
