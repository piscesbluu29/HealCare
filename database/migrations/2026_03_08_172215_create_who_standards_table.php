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
    Schema::create('who_standards', function (Blueprint $table) {
        $table->id();
        $table->enum('jenis_kelamin', ['L', 'P']);
        $table->integer('umur_bulan');
        $table->float('min_3sd'); // Sangat Pendek
        $table->float('min_2sd'); // Pendek
        $table->float('median');  // Normal
        $table->float('plus_3sd'); // Tinggi
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('who_standards');
    }
};
