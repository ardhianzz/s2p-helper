<?php

namespace App\Models\Pengumuman;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PPengumuman extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $table = 'p_pengumuman';


    static function get_pengumuman_jakarta(Request $request){
        //cek reques ada isinya ga
        return DB::table('p_pengumuman')->leftJoin("p_pengumuman_dokumen", "p_pengumuman.id", "=", "p_pengumuman_dokumen.p_pengumuman_id")
                                        ->select("p_pengumuman.id", "p_pengumuman.nama", "p_pengumuman.keterangan", "p_pengumuman_dokumen.path")
                                        ->where("p_pengumuman.nama", "like", "%".$request->cari."%")
                                        ->where("status", "=","Diumumkan")
                                        ->where("lokasi", "=", "Jakarta")
                                        ->orWhere("lokasi", "=", "Semua")
                                        ->orderBy("p_pengumuman.id", "desc")
                                        ->paginate(10);
    }

    static function get_pengumuman_cilacap(Request $request){
        //cek reques ada isinya ga
        return DB::table('p_pengumuman')->leftJoin("p_pengumuman_dokumen", "p_pengumuman.id", "=", "p_pengumuman_dokumen.p_pengumuman_id")
                                        ->select("p_pengumuman.id", "p_pengumuman.nama", "p_pengumuman.keterangan", "p_pengumuman_dokumen.path")
                                        ->where("p_pengumuman.nama", "like", "%".$request->cari."%")
                                        ->where("status", "=","Diumumkan")
                                        ->where("lokasi", "=", "Cilacap")
                                        ->orWhere("lokasi", "=", "Semua")
                                        ->orderBy("p_pengumuman.id", "desc")->paginate(10);
    }

    // static function get_pengumuman_cari(Request $request){

    //     return DB::table('p_pengumuman')->leftJoin("p_pengumuman_dokumen", "p_pengumuman.id", "=", "p_pengumuman_dokumen.p_pengumuman_id")
    //                                     ->select("p_pengumuman.id", "p_pengumuman.nama", "p_pengumuman.keterangan", "p_pengumuman_dokumen.path")
    //                                     ->where("status", "=","Diumumkan")
    //                                     ->where("lokasi", "=", "Cilacap")
    //                                     ->where("lokasi", "=", "Jakarta")
    //                                     ->orWhere("lokasi", "=", "Semua")
    //                                     ->where("keterangan", "like", "%".$request->cari."%")
    //                                     ->orderBy("p_pengumuman.id", "desc")->paginate(10);
    // }

    public function p_pengumuman_dokumen(){
        return $this->hasOne(PPengumumanDokumen::class);
    }

    public function p_pengumuman_riwayat(){
        return $this->hasMany(PPengumumanRiwayat::class);
    }
}
