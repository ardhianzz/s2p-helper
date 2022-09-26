<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class PPengumumanDokumen extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('p_pengumuman_dokumen', function (Blueprint $table) {
            $table->id();
            $table->foreignId("p_pengumuman_id")->nullable();
            $table->text("path")->nullable();
            $table->text("nama")->nullable();
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
        Schema::dropIfExists('p_pengumuman_dokumen');
    }
}
