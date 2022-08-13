<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exercices', function (Blueprint $table) {
            $table->id();
            $table->float('distance')->nullable();
            $table->integer('niveau')->nullable();
            $table->integer('temps')->nullable();
            $table->integer('numero_serie')->nullable();
            $table->integer('repetitions')->nullable();
            $table->float('poids')->nullable();
            $table->foreignId('machine_id')->nullable();
            $table->foreignId('user_id');
            $table->foreignId('seance_id');
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
        Schema::dropIfExists('exercices');
    }
};
