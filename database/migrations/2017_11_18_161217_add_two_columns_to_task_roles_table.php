<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTwoColumnsToTaskRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('task_roles', function (Blueprint $table) {
            $table->unsignedInteger('branch_id')->after('company_id')->default(0);
            $table->unsignedInteger('department_id')->after('branch_id')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('task_roles', function (Blueprint $table) {
            $table->dropColumn(['branch_id', 'department_id']);
        });
    }
}
