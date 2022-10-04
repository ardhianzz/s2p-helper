<?php

namespace App\Models\Pegawai;

use App\Models\Lembur\LemburSettingsGroup;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PegawaiPenggunaanNomorRekening extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $table = 'pegawai_penggunaan_nomor_rekening';

    public function pegawai_nomor_rekening(){
        return $this->belongsTo(PegawaiNomorRekening::class);
    }

    public function pegawai_jenis_pembayaran(){
        return $this->belongsTo(PegawaiJenisPembayaran::class);
    }
}
