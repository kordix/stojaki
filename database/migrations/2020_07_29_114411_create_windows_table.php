<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWindowsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('windows', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('barcode')->nullable()->unique();
            $table->string('order')->nullable();
            $table->string('order_pos')->nullable();
            $table->string('order_item')->nullable();
            $table->string('user_id')->nullable();
            $table->string('stand')->nullable();
            $table->string('client')->nullable();
            $table->string('client_code')->nullable();
            $table->string('remarks')->nullable();
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
        Schema::dropIfExists('windows');
    }
}
