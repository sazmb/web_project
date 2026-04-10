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
        Schema::create('squadras', function (Blueprint $table) {
          $table->id();
            $table->string('name');
            $table->integer('partite_giocate');
            $table->integer('vittorie');
            $table->integer('pareggi');
            $table->integer('sconfitte');
            $table->integer('punteggio');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('squadras');
    }
};
