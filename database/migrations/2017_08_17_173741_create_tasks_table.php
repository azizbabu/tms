<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('company_id')->default(0);
            $table->unsignedInteger('branch_id')->default(0);
            $table->unsignedInteger('department_id')->default(0);
            $table->unsignedInteger('parent_id')->default(0);
            $table->string('job_type', 20);
            $table->string('title');
            $table->text('description');
            $table->string('frequency', 20);
            $table->string('status', 20);
            $table->date('deadline');
            $table->string('priority', 20);
            $table->softDeletes();
            $table->integer('created_by')->unsigned()->default(0);
            $table->integer('updated_by')->unsigned()->default(0);
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
        Schema::dropIfExists('tasks');
    }
}
