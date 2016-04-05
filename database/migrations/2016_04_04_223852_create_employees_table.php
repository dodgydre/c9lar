<?php

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
            $table->string('first_name');
            $table->string('last_name');
            $table->boolean('status')->default(1); // false for prior, true for current
            $table->date('birth_date')->nullable();
            $table->date('hire_date')->nullable();
            $table->string('street1')->nullable();
            $table->string('street2')->nullable();
            $table->string('city')->default('St. Johns');
            $table->string('prov')->default('Newfoundland');
            $table->string('post_code')->nullable();
            $table->string('country')->default('Canada');
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('sin')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('employees');
    }
}
