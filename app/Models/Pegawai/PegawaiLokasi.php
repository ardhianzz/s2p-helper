<?php

namespace App\Models\Pegawai;

use App\Models\Lembur\LemburSettingsGroup;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PegawaiLokasi extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $table = 'pegawai_lokasi';

    public function pegawai(){
        return $this->hasMany(Pegawai::class);
    }
}
