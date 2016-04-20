<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class GoogleCalendarSettings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        /*Schema::create('google_calendar_settings', function(Blueprint $table) {
          //$table->increments('id');
          $table->string('name')->unique(); // calendar1_provider, calendar1_id, calendar1_syncToken
          $table->string('value');
          $table->timestamps();
        });*/
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        //Schema::drop('google_calendar_settings');

    }
}
