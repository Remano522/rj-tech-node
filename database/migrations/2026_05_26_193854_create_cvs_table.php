<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cvs', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique(); // Untuk penanda 'remano' atau 'jonathan'
            $table->string('name');
            $table->string('role');
            $table->text('bio');
            $table->string('education');
            $table->json('skills')->nullable();         // Array JSON untuk daftar keahlian
            $table->json('experience')->nullable();     // Array JSON untuk daftar pengalaman
            $table->json('certifications')->nullable(); // Array JSON untuk daftar sertifikat
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cvs');
    }
};