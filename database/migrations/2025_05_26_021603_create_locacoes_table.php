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
        Schema::create('locacoes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('veiculo_id')->constrained('veiculos');
            $table->foreignId('cliente_id')->constrained('clientes');
            $table->datetime('data_locacao');
            $table->integer('dias_locacao')->nullable();
            $table->datetime('data_prevista_devolucao')->nullable();
            $table->datetime('data_devolucao')->nullable();
            $table->boolean('deletado')->default(0);
            $table->string('origin_user')->nullable();
            $table->string('last_user')->nullable();
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('locacoes');
    }
};
