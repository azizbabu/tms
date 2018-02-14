<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('company_id')->default(0);
            $table->integer('branch_id')->default(0);
            $table->integer('department_id')->default(0);
            $table->integer('designation_id')->default(0);
            $table->integer('reporting_boss')->default(0);
            $table->string('code', 20)->unique();
            $table->date('joining_date');
            $table->string('full_name');
            $table->string('fathers_name');
            $table->string('mothers_name');
            $table->date('dob');
            $table->string('religion', 20);
            $table->string('nationality', 100);
            $table->string('gender', 20);
            $table->string('nid');
            $table->string('phone', 50);
            $table->string('blood_group', 20)->nullable();
            $table->string('passport_no', 100)->nullable();
            $table->string('tin', 100);
            $table->text('present_address')->nullable();
            $table->text('permanent_address')->nullable();
            $table->text('photo')->nullable();
            $table->softDeletes();
            $table->integer('created_by')->unsigned();
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
        Schema::dropIfExists('employees');
    }
}
