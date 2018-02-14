<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSomeColumnsToEmpoloyeeTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('employee_tasks', function (Blueprint $table) {
            $table->unsignedInteger('frequency_id')->after('task_id')->default(0);
            $table->unsignedInteger('task_role_id')->after('frequency_id')->default(0);
            $table->unsignedInteger('report_to')->after('task_role_id')->default(0);
            $table->date('deadline')->after('report_to');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('employee_tasks', function (Blueprint $table) {
            $table->dropColumn(['frequency_id', 'task_role_id', 'report_to', 'deadline']);
        });
    }
}
