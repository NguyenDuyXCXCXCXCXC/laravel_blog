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
            $table->string('email')->unique();
            $table->string('password');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('first_name', 50);
            $table->string('last_name', 50);
            $table->string('avatar', 200)->nullable();
            $table->date('birthday')->nullable();
            $table->tinyInteger('sex')->default(2);
            $table->text('address');
            $table->tinyInteger('role')->default(2);
            $table->tinyInteger('status')->default(1);
            $table->string('token', 200)->nullable();
            $table->dateTime('token_expired')->nullable();
            $table->rememberToken()->nullable();
            $table->timestamps();
            $table->dateTime('deleted_at')->nullable();
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
