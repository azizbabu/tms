<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTwoColumnsToEmployeeTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('employee_tasks', function (Blueprint $table) {
            $table->UnsignedInteger('employee_id')->default(0)->change();
            $table->float('earned_point')->after('employee_id')->default(0);
            $table->timestamp('deadline')->after('earned_point')->nullable();
            $table->string('status', 20)->after('deadline')->default('new');
            $table->timestamp('finished_at')->after('status')->nullable();
            $table->string('assigned_via')->after('finished_at')->default('cron');
            $table->renameColumn('created_by', 'assigned_by');
            $table->renameColumn('created_at', 'assigned_at');
            $table->dropColumn(['updated_by', 'updated_at']);
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
            $table->string('employee_id')->default(0)->change();
            $table->dropColumn(['earned_point', 'deadline', 'status', 'finished_at', 'assigned_via']);
            $table->renameColumn('assigned_by','created_by');
            $table->renameColumn('assigned_at', 'created_at');
            $table->UnsignedInteger('updated_by')->after('assigned_by');
            $table->timestamp('updated_at')->after('assigned_at');
        });
    }
}
