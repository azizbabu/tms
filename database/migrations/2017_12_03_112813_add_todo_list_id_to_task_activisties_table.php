<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTodoListIdToTaskActivistiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('task_activities', function (Blueprint $table) {
            $table->unsignedInteger('todo_list_id')->after('task_id')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('task_activities', function (Blueprint $table) {
            $table->dropColumn('todo_list_id');
        });
    }
}
