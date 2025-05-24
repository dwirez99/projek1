<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('pesertadidiks', function (Blueprint $table) {
            $table->uuid('nis')->primary();
            $table->unsignedBigInteger('idortu');
            $table->string('namapd');
            $table->date('tanggallahir');
            $table->string('jeniskelamin');
            $table->string('kelas');
            $table->string('fase')->default('Pondasi');
            $table->integer('tinggibadan');
            $table->integer('beratbadan');
            $table->string('foto')->nullable();
            $table->timestamps();

            $table->foreign('idortu')->references('id')->on('orangtuas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pesertadidiks');
    }
};