<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('fotos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('veiculo_id'); // Relacionamento com veículos
            $table->string('caminho'); // Caminho da imagem
            $table->timestamps();
            $table->string('origin_user')->nullable();
            $table->string('last_user')->nullable();

            $table->foreign('veiculo_id')->references('id')->on('veiculos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fotos');
    }
};
