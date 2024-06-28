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
        if (!Schema::hasTable('orgaos')) {
            Schema::create('orgaos', function (Blueprint $table) {
                $table->id('id_orgao');
                $table->string('sigla_orgao', 10);
                $table->string('orgao', 255);
                $table->string('cnpj', 20)->nullable()->default(null);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orgaos');
    }
};
