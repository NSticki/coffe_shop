<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('guid')->nullable()->default(null)->unique();
            $table->string('product_name');
            $table->text('product_description')->nullable();
            $table->unsignedBigInteger('category_id')->default(0);
            $table->integer('price')->nullable()->default(0);
            $table->integer('sort_order');
            $table->string('weight')->nullable()->default(0);
            $table->string('fatAmount')->nullable()->default("0.00");
            $table->string('proteinsAmount')->nullable()->default("0.00");
            $table->string('carbohydratesAmount')->nullable()->default("0.00");
            $table->string('energyAmount')->nullable()->default("0.00");
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
        Schema::dropIfExists('products');
    }
}
