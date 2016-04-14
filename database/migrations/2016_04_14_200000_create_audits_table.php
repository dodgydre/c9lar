<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAuditsTable extends Migration {

  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('audits', function(Blueprint $table) {
      $table->increments('id');
      $table->integer('user_id')->nullable();
      $table->string('display_name')->nullable();  // this is user displayname?  Add to Users class as a function first_name . last_name
      $table->bigInteger('pid')->nullable();  // what is the pid?
      $table->string('action')->nullable();  // this is edit, update, create, delete, etc.
      $table->longtext('query')->nullable(); // the sql query generated
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
      Schema::drop('audits');
  }
}
