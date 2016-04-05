<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaystubsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('paystubs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('employee_id')->unsigned();
            $table->date('ppe');
            $table->decimal('gross',7,2);
            $table->decimal('cpp', 7, 2);
            $table->decimal('emp_cpp', 7, 2);
            $table->decimal('ei', 7, 2);
            $table->decimal('emp_ei', 7, 2);
            $table->decimal('fed_tax', 7, 2);
            $table->decimal('prov_tax', 7, 2);
            $table->decimal('net', 7, 2);
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('employee_id')->references('id')->on('employees');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('paystubs');
    }
}
