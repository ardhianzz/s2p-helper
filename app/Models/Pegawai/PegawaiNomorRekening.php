<?php

namespace App\Models\Pegawai;

use App\Models\Lembur\LemburSettingsGroup;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PegawaiNomorRekening extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $table = 'pegawai_nomor_rekening';

    public function pegawai(){
        return $this->hasMany(Pegawai::class);
    }
}
