<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOknasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('oknas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('barcode')->nullable();
            $table->string('order')->nullable();
            $table->string('user_id')->nullable();
            $table->string('stojak_id')->nullable();
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
        Schema::dropIfExists('oknas');
    }
}
