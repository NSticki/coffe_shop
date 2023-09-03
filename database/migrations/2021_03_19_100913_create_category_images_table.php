<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoryImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('category_images', function (Blueprint $table) {
            $table->id();
            $table->string('original_url');
            $table->string('image_url');
            $table->unsignedBigInteger('category_id')->unique();
        });

        Schema::table('category_images',function (Blueprint $table){
            $table->foreign('category_id')
                ->references('id')
                ->on('categories')
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
        Schema::table('category_images',function (Blueprint $table){
            $table->dropForeign('category_images_category_id_foreign');
        });
        Schema::dropIfExists('category_images');
    }
}
