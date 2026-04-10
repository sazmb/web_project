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
        Schema::create('exams', function (Blueprint $table) {
          $table->id();
            $table->integer('student_id');
            $table->integer('voto');
            $table->boolean('lode')->default(false);
            $table->date('data');
            $table->string('commento');
            $table->timestamps();
        });

         Schema::create('students', function (Blueprint $table) {
          $table->id();
            $table->integer('student_id');
            $table->string('nome');
            $table->string('cognome');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exams');
          Schema::dropIfExists('stuents');
    }

};
