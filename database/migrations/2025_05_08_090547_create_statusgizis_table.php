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
        Schema::create('status_gizis', function (Blueprint $table) {
            $table->id('idstatus');
            $table->uuid('nis');
            $table->float('z_score');
            $table->string('status');
            $table->date('tanggalpembuatan');
            $table->timestamps();

            $table->foreign('nis')->references('nis')->on('pesertadidiks')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('status_gizis');
    }
};
