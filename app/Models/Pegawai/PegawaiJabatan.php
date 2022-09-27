<?php

namespace App\Models\Pegawai;

use App\Models\Lembur\LemburSettingsGroup;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PegawaiJabatan extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $table = 'pegawai_jabatan';

    public function pegawai(){
        return $this->hasMany(Pegawai::class);
    }
    public function lembur_settings_group(){
        return $this->hasOne(LemburSettingsGroup::class);
    }
}
