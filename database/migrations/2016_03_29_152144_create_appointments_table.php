<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAppointmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->boolean('allDay')->default(0);
            $table->timestamp('start');
            $table->timestamp('end');
            $table->string('provider',3);
            $table->integer('patient_id'); // foreign key to patients table
            $table->string('chart_number',8);
            $table->string('name', 50);  // patient name
            $table->string('phone1',15);
            $table->string('color', 10);
            $table->boolean('is_break');
            $table->uuid('uuid');
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
        Schema::drop('appointments');
    }
}
