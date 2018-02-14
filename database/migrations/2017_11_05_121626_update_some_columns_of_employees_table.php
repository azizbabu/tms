<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateSomeColumnsOfEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->string('code', 20)->nullable()->change();
            $table->date('joining_date')->nullable()->change();
            $table->string('fathers_name')->nullable()->change();
            $table->string('mothers_name')->nullable()->change();
            $table->date('dob')->nullable()->change();
            $table->string('religion', 20)->nullable()->change();
            $table->string('nationality', 100)->nullable()->change();
            $table->string('nid')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->string('code', 20)->change();
            $table->date('joining_date')->change();
            $table->string('fathers_name')->change();
            $table->string('mothers_name')->change();
            $table->date('dob')->change();
            $table->string('religion', 20)->change();
            $table->string('nationality', 100)->change();
            $table->string('nid')->change();
        });
    }
}
