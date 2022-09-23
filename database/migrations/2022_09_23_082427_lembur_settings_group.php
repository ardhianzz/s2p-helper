<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class LemburSettingsGroup extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lembur_settings_group', function (Blueprint $table) {
            $table->id();
            $table->text("nama_pengaturan")->nullable();
            $table->foreignId("pegawai_jabatan_id")->nullable();
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
        Schema::dropIfExists('lembur_settings_group');
    }
}
