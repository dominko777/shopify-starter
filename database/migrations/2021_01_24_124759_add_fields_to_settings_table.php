<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('settings', function (Blueprint $table) {
           $table->boolean('rating')->default(1);
           $table->string('rating_color')->default(1);
           $table->boolean('images')->default(1);
           $table->boolean('review_reminder')->default(1);
           $table->string('reminder_email')->nullable();
           $table->string('reminder_email_subject')->nullable();
           $table->string('reminder_email_message')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('settings', function (Blueprint $table) {
            //
        });
    }
}
