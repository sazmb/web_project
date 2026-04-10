<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Book;
use App\Models\Author;
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
    
        Schema::create('book', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->UnsignedBigInteger('author_id');
            $table->timestamps();
            
        });

        Schema::create('author', function (Blueprint $table) {
            $table->id(); //auto increment
            $table->string('first_name');
            $table->string('last_name');
            $table->timestamps();
        });

        Schema::table ('book', function (Blueprint $table) {
            $table->foreign('author_id')->references('id')->on('author');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('book');
        Schema::dropIfExists('author');
    }
};
