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
            $table->string('chart_number', 8);
            $table->string('last_name');
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('street1')->nullable();
            $table->string('street2')->nullable();
            $table->string('city')->nullable();
            $table->string('province')->nullable();
            $table->string('postcode', 10)->nullable();
            $table->string('country', 25)->nullable();
            $table->string('phone1')->nullable();
            $table->string('phone2')->nullable();
            $table->string('phone3')->nullable();
            //$table->string('phone4')->nullable();
            //$table->string('phone5')->nullable();
            $table->string('gender',10)->nullable();
            $table->date('dob')->nullable();
            $table->string('email')->nullable();
            //$table->integer('provider_id')->nullable();  // Can remove this probably?
            $table->date('date_of_last_pmt')->nullable();
            $table->decimal('last_pmt', 6, 2)->default(0.00);
            $table->decimal('remaining_balance', 6, 2)->default(0.00);
            $table->string('insurer1', 5)->nullable();  // fk to insurer->code
            $table->string('insurer2', 5)->nullable();  // fk to insurer->code
            $table->string('insurer3', 5)->nullable();  // fk to insurer->code
            //$table->integer('created_by'); // remove ?
            //$table->integer('modified_by'); // remove ?
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
