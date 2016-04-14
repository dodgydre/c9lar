<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProvidersTable extends Migration {

  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('providers', function(Blueprint $table) {
      $table->increments('id');
      $table->string('type'); // chiropractor, massage therapist
      $table->string('first_name');
      $table->string('last_name');
      $table->string('code'); // first name initial + last name initial calculated
      $table->string('license'); // store the RMT or Chiro licence number for invoices
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
      Schema::drop('providers');
  }
}
