<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGurusTable extends Migration // Nama class migration tetap seperti ini
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gurus', function (Blueprint $table) { // Nama tabel diubah menjadi 'guru'
            $table->id();
            $table->string('name');
            $table->string('position'); // Jabatan
            $table->string('image')->nullable(); // Path to the guru's image
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('gurus'); // Nama tabel diubah menjadi 'guru'
    }
}