<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFuncionariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('funcionarios', function (Blueprint $table) {
            $table->id();
            $table->string('nome'); 
            $table->string('documento')->unique(); 
            $table->enum('sexo', ['M', 'F', 'Outro']);
            $table->date('data_nascimento');
            $table->string('telefone');
            $table->string('email')->unique();
            $table->string('endereco');
            $table->string('cargo');
            $table->decimal('salario', 10, 2);
            $table->enum('status', ['ativo', 'inativo'])->default('ativo');
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
        Schema::dropIfExists('funcionarios');
    }
}
