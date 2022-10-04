<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class PegawaiPengunaanNomorRekening extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pegawai_penggunaan_nomor_rekening', function (Blueprint $table) {
            $table->id();
            $table->foreignId("pegawai_nomor_rekening_id")->nullable();
            $table->foreignId("pegawai_jenis_pembayaran_id")->nullable();
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
        Schema::dropIfExists('pegawai_penggunaan_nomor_rekening');
    }
}
