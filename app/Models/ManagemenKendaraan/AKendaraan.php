<?php

namespace App\Models\ManagemenKendaraan;

use App\Models\Pegawai\Pegawai;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AKendaraan extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $table = 'a_kendaraan';
    
    public function a_status_perbaikan(){
        return $this->hasMany(AStatusPerbaikan::class);
    }
    public function a_kendaraan_dokumen(){
        return $this->hasMany(AKendaraanDokumen::class);
    }

    public function pegawai(){
        return $this->belongsTo(Pegawai::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }

    public function a_asuransi(){
        return $this->hasMany(AAsuransi::class);
    }


    public function a_service_perbaikan(){
        return $this->hasMany(AServicePerbaikan::class);
    }
    public function a_jenis_kendaraan(){ 
        return $this->belongsTo(AJenisKendaraan::class);
    }




    //menggunakan nama model
    public function ajeniskendaraan(){
        return $this->belongsTo(AJenisKendaraan::class);
    }

    
}
