<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSomeColumnsToTodoListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('todo_lists', function (Blueprint $table) {
            $table->integer('achievement')->after('approved_on')->default(0);
            $table->timestamp('extended_dateline_1')->after('achievement')->nullable();
            $table->timestamp('extended_dateline_2')->after('extended_dateline_1')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('todo_lists', function (Blueprint $table) {
            $table->dropColumn(['achievement', 'extended_dateline_1', 'extended_dateline_2']);
        });
    }
}
