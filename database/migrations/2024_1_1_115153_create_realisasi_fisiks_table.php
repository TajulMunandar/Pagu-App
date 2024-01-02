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
        Schema::create('realisasi_fisiks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pagu_id')->constrained('pagus')->onUpdate('cascade')->onDelete('restrict');
            $table->index('pagu_id');
            $table->integer('nilai');
            $table->decimal('bobot', $precision = 5, $scale = 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('realisasi_fisiks');
    }
};
