<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->increments('id');
            $table->integer('company_id')->default(0);
            $table->integer('branch_id')->default(0);
            $table->integer('employee_id')->default(0);
            $table->string('username', 20)->unique();
            $table->string('email', 50)->unique();
            $table->string('role', 20);
            $table->boolean('active')->default(true);
            $table->timestamp('last_login')->nullable();
            $table->string('last_ip', 20)->nullable();
            $table->string('password');
            $table->rememberToken();
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
