<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePassageirosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('passageiros', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('documento')->unique();
            $table->date('data_nascimento');
            $table->enum('sexo', ['M', 'F']);
            $table->string('endereco');
            $table->string('telefone');
            $table->string('email')->unique();
            $table->string('nacionalidade');
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
        Schema::dropIfExists('passageiros');
    }
}
