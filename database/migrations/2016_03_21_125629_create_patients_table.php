<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePatientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patients', function (Blueprint $table) {
            $table->increments('id');
            $table->string('chart_number');
            $table->string('last_name');
            $table->string('first_name');
            $table->string('middle_name');
            $table->string('street1');
            $table->string('street2');
            $table->string('province');
            $table->string('postcode', 10);
            $table->string('country', 25);
            $table->string('phone1');
            $table->string('phone2');
            $table->string('phone3');
            $table->string('phone4');
            $table->string('phone5');
            $table->string('gender',1);
            $table->date('dob');
            $table->string('email');
            $table->integer('provider_id');
            $table->date('date_of_last_pmt');
            $table->decimal('last_pmt', 6, 2);
            $table->decimal('remaining_balance', 6, 2);
            $table->integer('created_by');
            $table->integer('modified_by');
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
        Schema::drop('patients');
    }
}
