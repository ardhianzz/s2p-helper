<?php

namespace App\Models;

use App\Models\Pegawai\Pegawai;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PegawaiLampiran extends Model
{
    use HasFactory;
    protected $table = 'pegawai_lampiran';
    protected $guarded = ['id'];

    public function pegawai(){
        return $this->hasMany(Pegawai::class);
    }
}
