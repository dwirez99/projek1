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
        Schema::create('assessments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('nis')->constrained('pesertadidiks', 'nis'); // Sesuai primary key di pesertadidiks
            $table->foreignId('teacher_id')->constrained('users');
            $table->date('assessment_date');
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        Schema::create('assessment_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('assessment_id')->constrained('assessments');
            $table->string('aspect'); // Contoh: 'motorik_kasar'
            $table->string('indicator'); // Contoh: 'Dapat melompat dengan dua kaki'

            // Gunakan enum teks deskriptif
            $table->enum('score', [
                'Belum Berkembang',
                'Mulai Berkembang',
                'Berkembang Sesuai Harapan',
                'Sangat Berkembang'
            ]);

            $table->text('comment')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
