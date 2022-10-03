<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class PegawaiNomorRekening extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pegawai_nomor_rekening', function (Blueprint $table) {
            $table->id();
            $table->foreignId("user_id");
            $table->text("nama_bank")->nullable();
            $table->text("nama_akun")->nullable();
            $table->text("nomor_rekening")->nullable();
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
        Schema::dropIfExists('pegawai_nomor_rekening');
    }
}
