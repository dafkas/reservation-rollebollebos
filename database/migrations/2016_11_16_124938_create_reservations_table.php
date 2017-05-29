<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReservationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('reservations', function(Blueprint $table) {
        $table->increments('id');
        $table->string('customer_name')->nullable();
        $table->string('customer_email')->nullable();
        $table->integer('customer_phone')->nullable();
        $table->string('description')->nullable();
        $table->integer('amount')->nullable();
        $table->integer('option')->nullable();
        $table->integer('date');
        $table->boolean('available')->nullable();
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reservations');
    }
}
