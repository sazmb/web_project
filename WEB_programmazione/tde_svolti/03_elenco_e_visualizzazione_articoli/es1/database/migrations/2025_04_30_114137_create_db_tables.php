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
        Schema::create('author', function (Blueprint $table) {
            $table->id();
            $table->string('firstname');
            $table->string('lastname');
            $table->string('email');
            $table->timestamps();
        });

        Schema::create('book', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->timestamps();
        });

      // ✅ Crea prima la tabella pivot
    Schema::create('author_book', function (Blueprint $table) {
        $table->unsignedBigInteger('author_id');
        $table->unsignedBigInteger('book_id');

        // Chiave primaria composta (opzionale, ma consigliato)
        $table->primary(['author_id', 'book_id']);

        // Foreign keys
        $table->foreign('author_id')->references('id')->on('author')->onDelete('cascade');
        $table->foreign('book_id')->references('id')->on('book')->onDelete('cascade');
    });
     
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('book_category');
        Schema::dropIfExists('book');
        Schema::dropIfExists('category');
        Schema::dropIfExists(table: 'address');
        Schema::dropIfExists('author');
    }
};
