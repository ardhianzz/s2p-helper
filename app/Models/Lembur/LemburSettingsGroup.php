<?php

namespace App\Models\Lembur;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Pegawai\PegawaiJabatan;

class LemburSettingsGroup extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $table = 'lembur_settings_group';

    public function pegawai_jabatan(){
        return $this->belongsTo(PegawaiJabatan::class);
    }
}
 