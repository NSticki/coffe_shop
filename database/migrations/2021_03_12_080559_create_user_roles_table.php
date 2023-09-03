<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_roles', function (Blueprint $table) {
            $table->id();
            $table->string('role');
        });

        DB::table('user_roles')->insert(
            array(
                ['role' => 'admin'],
                ['role' => 'customer'],
            ),
        );
        Schema::table('users',function (Blueprint $table){
            $table->foreign('role_id')
                ->references('id')
                ->on('user_roles')
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
        Schema::table('users',function (Blueprint $table){
            $table->dropForeign('users_role_id_foreign');
        });
        Schema::dropIfExists('user_roles');
    }
}
