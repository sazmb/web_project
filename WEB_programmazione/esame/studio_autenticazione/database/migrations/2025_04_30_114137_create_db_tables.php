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
        // Tabella hotels
        Schema::create('hotels', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->text('descrizione')->nullable();
            $table->string('localita');
            $table->string('immagine')->nullable();
            $table->timestamps();
        });

        // Tabella reviews
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->Integer('punteggio'); // es: 1–5
            $table->text('commento')->nullable();
            $table->date('data');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('hotel_id');
            $table->timestamps();
        });

        

        Schema::table('reviews', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('hotel_id')->references('id')->on('hotels');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
        Schema::dropIfExists('hotels');
    }
};
