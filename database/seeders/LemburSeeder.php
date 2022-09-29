<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\HakAkses;
use App\Models\Modul;
use App\Models\PegawaiLevelUser;
use App\Models\Pegawai\Pegawai;
use App\Models\Jabatan;
use App\Models\Divisi;
use App\Models\Lembur\LemburSettingsGroup;
use Illuminate\Support\Facades\DB;

class LemburSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //  User::factory(1)->create();
         DB::table("lembur_settings")->insert(["jam_masuk"=>"08:00:00", "jam_kerja" => "09:00:00"]);

         


         //Lembur Setting Group :
         LemburSettingsGroup::create(['nama_pengaturan'=> 'Lembur Pagi', 'pegawai_jabatan_id'=> '7']);
         LemburSettingsGroup::create(['nama_pengaturan'=> 'Lembur Pagi', 'pegawai_jabatan_id'=> '8']);
         LemburSettingsGroup::create(['nama_pengaturan'=> 'Jam Masuk 08:00', 'pegawai_jabatan_id'=> '1']);
         LemburSettingsGroup::create(['nama_pengaturan'=> 'Jam Masuk 08:00', 'pegawai_jabatan_id'=> '2']);
         LemburSettingsGroup::create(['nama_pengaturan'=> 'Jam Masuk 08:00', 'pegawai_jabatan_id'=> '3']);
         LemburSettingsGroup::create(['nama_pengaturan'=> 'Jam Masuk 08:00', 'pegawai_jabatan_id'=> '4']);
         LemburSettingsGroup::create(['nama_pengaturan'=> 'Jam Masuk 08:00', 'pegawai_jabatan_id'=> '5']);
         LemburSettingsGroup::create(['nama_pengaturan'=> 'Jam Masuk 08:00', 'pegawai_jabatan_id'=> '6']);
         LemburSettingsGroup::create(['nama_pengaturan'=> 'Jam Masuk 07:30', 'pegawai_jabatan_id'=> '7']);
         LemburSettingsGroup::create(['nama_pengaturan'=> 'Jam Masuk 07:30', 'pegawai_jabatan_id'=> '8']);

         
         DB::table("lembur_settings_group")->insert([ "nama_pengaturan" => "Jam Masuk 07.30", "pegawai_jabatan_id" => "7"]);
         DB::table("lembur_settings_group")->insert([ "nama_pengaturan" => "Jam Masuk 07.30", "pegawai_jabatan_id" => "8"]);
         DB::table("lembur_settings_group")->insert([ "nama_pengaturan" => "Lembur Pagi", "pegawai_jabatan_id" => "7"]);
         DB::table("lembur_settings_group")->insert([ "nama_pengaturan" => "Lembur Pagi", "pegawai_jabatan_id" => "8"]);
         
         
    
    }
}
