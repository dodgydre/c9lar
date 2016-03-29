<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('payment_ref')->unsigned();  // fk from Transactions id
            $table->integer('charge_ref')->unsigned();   // fk from Transactions id
            $table->decimal('amount',5,2);   // -ve for payments
            $table->char('who_paid',1);      // G/1/2/3
            $table->integer('deposit_id')->unsigned();   // fk from Deposits
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
        Schema::drop('payments');
    }
}
