<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RReminderData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('r_reminder_data', function (Blueprint $table) {
            $table->id();
            $table->foreignId("user_id")->nullable();
            $table->foreignId('pegawai_divisi_id')->nullable();
            $table->text("nama")->nullable();
            $table->date("from")->nullable();
            $table->date("to")->nullable();
            $table->date("tanggal_expired")->nullable();
            $table->date("tanggal_pengingat")->nullable();
            $table->text("email")->nullable();
            $table->text("keterangan")->nullable();
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
        Schema::dropIfExists('r_reminder_data');
    }
}
