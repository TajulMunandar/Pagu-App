<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('sp2d', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kontrak_id')
                ->index()
                ->constrained('kontrak')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->string('nomor');
            $table->date('tanggal');
            $table->integer('jumlah');
            $table->string('dokumen');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sp2d');
    }
};
