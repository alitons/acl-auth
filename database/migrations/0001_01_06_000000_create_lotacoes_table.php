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
        if (!Schema::hasTable('lotacoes')) {
            Schema::create('lotacoes', function (Blueprint $table) {
                $table->id('id_lotacao');
                $table->foreignId('id_orgao')->nullable()->default(null)->constrained('orgaos', 'id_orgao');
                $table->string('nome_lotacao');
                $table->string('sigla_lotacao', 20)->nullable()->default(null);
                $table->integer('tipo_lotacao')->default(1);
                $table->foreignId('id_lotacao_pai')->nullable()->default(null)->constrained('lotacoes', 'id_lotacao');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lotacoes');
    }
};
