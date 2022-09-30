<?php

namespace App\Models\Pegawai;

use App\Models\Lembur\LemburSettingsGroup;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PegawaiLevel extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $table = 'pegawai_level';

    public function pegawai(){
        return $this->hasMany(Pegawai::class);
    }
}
