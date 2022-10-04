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
            $table->double("i_gaji_dasar")->nullable();
            $table->double("i_tunjangan")->nullable();
            $table->double("i_tunjangan_jabatan")->nullable();
            $table->double("i_tunjangan_komunikasi")->nullable();
            $table->double("i_tunjangan_pensiun")->nullable();
            $table->double("i_tunjangan_cuti")->nullable();
            $table->double("i_lembur")->nullable();
            $table->double("i_hari_raya")->nullable();
            $table->double("i_work_anniversary")->nullable();
            $table->double("i_jasa_kerja")->nullable();
            $table->double("i_rapel")->nullable();
            $table->double("i_lain_1")->nullable();
            $table->double("i_lain_2")->nullable();
            $table->double("i_lain_3")->nullable();
            $table->double("o_bpjs_tenaga_kerja")->nullable();
            $table->double("o_bpjs_kesehatan")->nullable();
            $table->double("o_dana_pensiun")->nullable();
            $table->double("o_komunikasi")->nullable();
            $table->double("o_lain_1")->nullable();
            $table->double("o_lain_2")->nullable();
            $table->double("o_lain_3")->nullable();
            $table->double("t_pendapatan")->nullable();
            $table->double("t_pendapatan_lain")->nullable();
            $table->double("t_potongan")->nullable();
            $table->double("t_takehome")->nullable();
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
