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
        Schema::create('gedung', function (Blueprint $table) {
            $table->id();
            $table->text('NAMA');
            $table->string('KATEGORI');
            $table->foreign('KATEGORI')->references('Kategori')->on('KategoriGedung');
            $table->text('ALAMAT')->nullable();
            $table->text('KOORDINAT')->nullable();
            $table->string('TEL_CUST')->nullable();
            $table->string('PIC_CUST')->nullable();
            $table->string('AM')->nullable();
            $table->string('TEL_AM')->nullable();
            $table->text('STO')->nullable();
            $table->string('HERO')->nullable();
            $table->string('TEL_HERO')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Will Delete Table If Exists
        Schema::dropIfExists('gedung');
    }
};
