<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClarifaiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clarifai', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('id_tanaman')->unsigned();
            $table->string('hex', 50);
            $table->string('warna', 50);
            $table->float('nilai');
            $table->timestamps();

            // $table->foreign('id_tanaman')->references('id')->on('tanaman')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('clarifai');
    }
}
