<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Executa a criação da tabela `usuarios`.
     */
    public function up(): void
    {
        Schema::create('usuarios', function (Blueprint $table) {
            $table->id(); 
            $table->string('nome', 60);
            $table->string('email', 150)->unique(); 
            $table->string('senha'); // Senha criptografada
            $table->timestamps(); // Campos de controle (created_at e updated_at)
            $table->softDeletes(); // Campo para exclusão lógica (deleted_at)
        });
    }

    /**
     * Reverte a criação da tabela `usuarios`.
     */
    public function down(): void
    {
        Schema::dropIfExists('usuarios');
    }
};
