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
        Schema::create('contatos_enderecos', function (Blueprint $table) {
            $table->id('codigo');
            $table->foreignId('codigo_contato')->constrained('contatos','codigo')->onDelete('cascade');
            $table->string('cep');
            $table->string('endereco');
            $table->bigInteger('numero');
            $table->string('bairro');
            $table->string('cidade');
            $table->string('estado');
            $table->string('complemento')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contatos_enderecos');
    }
};
