<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class PSlipGajiDetail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('p_slip_gaji_detail', function (Blueprint $table) {
            $table->id();
            $table->foreignId("p_slip_gaji_id")->nullable();
            $table->text("nik")->nullable();
            $table->date("tanggal")->nullable();
            $table->text("i_gaji_dasar")->nullable();
            $table->text("i_tunjangan")->nullable();
            $table->text("i_tunjangan_jabatan")->nullable();
            $table->text("i_tunjangan_komunikasi")->nullable();
            $table->text("i_tunjangan_pensiun")->nullable();
            $table->text("i_tunjangan_cuti")->nullable();
            $table->text("i_lembur")->nullable();
            $table->text("i_hari_raya")->nullable();
            $table->text("i_work_anniversary")->nullable();
            $table->text("i_jasa_kerja")->nullable();
            $table->text("i_rapel")->nullable();
            $table->text("i_lain_1")->nullable();
            $table->text("i_lain_2")->nullable();
            $table->text("i_lain_3")->nullable();
            $table->text("o_bpjs_tenaga_kerja")->nullable();
            $table->text("o_bpjs_kesehatan")->nullable();
            $table->text("o_dana_pensiun")->nullable();
            $table->text("o_komunikasi")->nullable();
            $table->text("o_lain_1")->nullable();
            $table->text("o_lain_2")->nullable();
            $table->text("o_lain_3")->nullable();
            $table->text("t_pendapatan")->nullable();
            $table->text("t_pendapatan_lain")->nullable();
            $table->text("t_potongan")->nullable();
            $table->text("t_takehome")->nullable();
            $table->timestamp("has_opened")->nullable();
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
        Schema::dropIfExists('p_slip_gaji_detail');
    }
}
