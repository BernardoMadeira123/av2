<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('tokens_invalidados', function (Blueprint $table) {
            $table->id();
            $table->string('token')->unique();
            $table->timestamp('data_expiracao')->nullable(); 
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tokens_invalidados');
    }
};
