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
        // Corresponds to the 'ulasan' table in the SQL dump
        Schema::create('ulasans', function (Blueprint $table) {
            $table->id();
            // Using foreignId for the product_id and constraining it to the 'produks' table (best practice)
            $table->foreignId('product_id')->constrained('produks')->onDelete('cascade'); 
            $table->string('nama_reviewer', 100);
            $table->tinyInteger('rating'); // tinyint(1) is translated to tinyInteger
            $table->text('komentar');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ulasans');
    }
};