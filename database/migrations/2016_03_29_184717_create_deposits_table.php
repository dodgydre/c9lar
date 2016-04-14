<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDepositsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deposits', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('patient_id'); // fk to Patient table
            $table->string('chart_number', 8);
            $table->string('payor_type', 15); // Patient / Insurance  (change to P/I?)
            $table->string('payment_method', 15); // Cash / Credit Card / Check
            $table->boolean('copay'); // Yes or No
            $table->integer('insurer_id')->nullable(); // fk to Insurer table
            $table->string('insurer_code')->nullable(); // from Insurer table
            $table->decimal('payment_amount', 5, 2)->default(0.00);
            $table->decimal('unapplied_amount', 5, 2)->default(0.00);
            $table->date('deposit_date');
            $table->string('payor_name', 50); // Either from Patient or from Insurer depending on payor_type
            $table->integer('procedure_id')->unsigned(); // fk to Procedures
            $table->string('payment_code', 8); // from Procedures
            $table->text('comments')->nullable();
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
        Schema::drop('deposits');
    }
}
