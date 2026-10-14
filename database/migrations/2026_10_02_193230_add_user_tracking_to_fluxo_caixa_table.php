<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('fluxo_caixa', function (Blueprint $table) {
            $table->string('origin_user')->nullable()->after('descricao');
            $table->string('last_user')->nullable()->after('origin_user');
        });
    }

    public function down(): void
    {
        Schema::table('fluxo_caixa', function (Blueprint $table) {
            $table->dropColumn(['origin_user', 'last_user']);
        });
    }
};