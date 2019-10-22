<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTableForEmailNotificationsScheduled extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('scheduled_emails');
        Schema::create('scheduled_emails', function (Blueprint $table) {
            $table->increments('id');
            $table->string('from_name')->nullable()->default(null);
            $table->string('from_email')->nullable()->default(null);
            $table->string('to_name')->nullable()->default(null);
            $table->string('to_email')->nullable()->default(null);
            $table->string('message')->nullable()->default(null);
            $table->timestamp('sched_date');
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
        Schema::dropIfExists('scheduled_emails');
    }
}
