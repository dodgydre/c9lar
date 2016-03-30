<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('patient_id'); // fk to Patient
            $table->string('chart_number', 8);
            $table->date('date_from');
            $table->text('description')->nullable();
            $table->string('attending_provider', 3);
            $table->string('procedure_code', 8);  // fk to Procedure
            $table->string('procedure_description'); // from Procedure
            $table->string('transaction_type'); // from Procedure
            $table->integer('units')->unsigned();
            $table->decimal('amount', 5, 2)->default(0.00);  // from Procedure  (+ve for charge, -ve for payment)
            $table->decimal('total', 5, 2)->default(0.00);  // units * amount
            $table->decimal('g_amount_paid', 5, 2)->default(0.00);
            $table->decimal('i1_amount_paid', 5, 2)->default(0.00);
            $table->decimal('i2_amount_paid', 5, 2)->default(0.00);
            $table->decimal('i3_amount_paid', 5, 2)->default(0.00);
            $table->char('who_paid',1)->nullable();  // G/1/2/3
            $table->decimal('unapplied_amount', 5, 2)->default(0.00);
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
        Schema::drop('transactions');
    }
}
