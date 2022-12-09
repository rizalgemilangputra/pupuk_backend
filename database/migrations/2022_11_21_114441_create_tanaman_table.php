<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTanamanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tanaman', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('id_user')->unsigned();
            $table->integer('umur');
            $table->integer('id_pupuk')->unsigned();
            $table->string('gambar');
            $table->smallInteger('is_deleted')->default(0);
            $table->timestamps();

            // $table->foreign('id_user')->references('id')->on('users')->nullOnDelete();
            // $table->foreign('id_pupuk')->references('id')->on('pupuk')->restrictOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tanaman');
    }
}
