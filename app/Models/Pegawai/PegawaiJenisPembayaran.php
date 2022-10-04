<?php

namespace App\Models\Pegawai;

use App\Models\Lembur\LemburSettingsGroup;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PegawaiJenisPembayaran extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $table = 'pegawai_jenis_pembayaran';

    public function pegawai_jenis_pembayaran(){
        return $this->hasMany(PegawaiJenisPembayaran::class);
    }
}
