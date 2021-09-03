<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->integer('user_role_id')->constrained('user_roles')->onUpdate('cascade')->onDelete('restrict');
            $table->string('email', 100)->unique();
            $table->boolean('email_confirmed')->default(false);
            $table->string('password');
            $table->string('first_name', 50);
            $table->string('last_name', 50);
            $table->boolean('is_admin')->default(false);
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
        Schema::dropIfExists('users');
    }
}
