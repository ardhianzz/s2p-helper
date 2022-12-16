<?php

namespace App\Models\Pegawai;

use App\Models\ManagemenKendaraan\AKendaraan;
use App\Models\PegawaiLampiran;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\DB;

class Pegawai extends Model
{
    use HasFactory;
    protected $table = 'pegawai';
    protected $guarded = ['id'];

    public function pegawai_lampiran(){
        return $this->belongsTo(PegawaiLampiran::class);
    }

    public function pegawai_divisi(){
        return $this->belongsTo(PegawaiDivisi::class);
    }

    public function pegawai_level(){
        return $this->belongsTo(PegawaiLevel::class);
    }

    public function pegawai_lokasi(){
        return $this->belongsTo(PegawaiLokasi::class);
    }
    
    public function pegawai_jabatan(){
        return $this->belongsTo(PegawaiJabatan::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    static function pegawai_validasi($data){
    $valid =  DB::table('pegawai')
                ->where("pegawai.nik","=", $data['nik'])
                ->count();

    if($valid >= 1){
        return false;
    }else{
        return $data;
    }
    }



    static function jabatan_validasi($data){
        $valid =  DB::table('pegawai_jabatan')
                    ->where("pegawai_jabatan.nama","=", $data['nama'])
                    ->count();

        if($valid >= 1){
            return false;
        }else{
            return $data;
        }
    }

    static function divisi_validasi($data){
        $valid =  DB::table('pegawai_divisi')
                    ->where("pegawai_divisi.nama","=", $data['nama'])
                    ->count();

        if($valid >= 1){
            return false;
        }else{
            return $data;
        }
    }

    static function get_modul(){
        return DB::table('modul')->get();
    }

    static function get_level(){
        return DB::table('pegawai_level_user')->get();
    }


    static function get_profile($id){
        return DB::table("pegawai")
                ->join("users", "users.id", "=", "pegawai.user_id")
                ->join("pegawai_divisi", "pegawai_divisi.id", "=", "pegawai.pegawai_divisi_id")
                ->join("pegawai_jabatan", "pegawai_jabatan.id", "=", "pegawai.pegawai_jabatan_id")
                ->join("pegawai_lokasi", "pegawai_lokasi.id", "=", "pegawai.pegawai_lokasi_id")
                ->select("pegawai.id", "pegawai.nik", "pegawai.user_id", "pegawai.nama", "users.email", "pegawai_jabatan.nama as jabatan", "pegawai_divisi.nama as divisi",  "pegawai_lokasi.nama as lokasi")
                ->where("pegawai.user_id","=", $id)
                ->get();
    }


    static function get_detail($nik){
        return DB::table("pegawai")
                ->join("users", "users.id", "=", "pegawai.user_id")
                ->join("pegawai_divisi", "pegawai_divisi.id", "=", "pegawai.pegawai_divisi_id")
                ->join("pegawai_jabatan", "pegawai_jabatan.id", "=", "pegawai.pegawai_jabatan_id")
                ->join("pegawai_lokasi", "pegawai_lokasi.id", "=", "pegawai.pegawai_lokasi_id")
                ->select("pegawai.id", "pegawai.nik", "pegawai.user_id", "pegawai.nama", "users.email", "pegawai_jabatan.nama as jabatan", "pegawai_divisi.nama as divisi", "pegawai_lokasi.nama as lokasi")
                ->where("pegawai.nik","=", $nik)
                ->where("pegawai_lokasi_id", "=", "1")
                ->get();
    }

    static function get_detail_cilacap($nik){
        return DB::table("pegawai")
                ->join("users", "users.id", "=", "pegawai.user_id")
                ->join("pegawai_divisi", "pegawai_divisi.id", "=", "pegawai.pegawai_divisi_id")
                ->join("pegawai_jabatan", "pegawai_jabatan.id", "=", "pegawai.pegawai_jabatan_id")
                ->join("pegawai_lokasi", "pegawai_lokasi.id", "=", "pegawai.pegawai_lokasi_id")
                ->select("pegawai.id", "pegawai.nik", "pegawai.user_id", "pegawai.nama", "users.email", "pegawai_jabatan.nama as jabatan", "pegawai_divisi.nama as divisi", "pegawai_lokasi.nama as lokasi")
                ->where("pegawai.nik","=", $nik)
                ->where("pegawai_lokasi_id", "=", "2")
                ->get();
    }

    
    static function hak_akses(){
        return DB::table("pegawai_hak_akses")
                 ->join("pegawai","pegawai.id","=","pegawai_hak_akses.user_id")
                 ->join("modul","modul.id","=","pegawai_hak_akses.modul_id")
                 ->join("pegawai_level_user","pegawai_level_user.id","=","pegawai_hak_akses.pegawai_level_user_id")
                 ->select("pegawai_hak_akses.id", "pegawai.nama", "modul.nama as modul", "pegawai_level_user.nama as level")
                 ->orderBy("pegawai.nama", "asc")
                ->paginate(10);
    }


    static function hak_akses_cari($data){
        return DB::table("pegawai_hak_akses")
                 ->join("pegawai","pegawai.id","=","pegawai_hak_akses.user_id")
                 ->join("modul","modul.id","=","pegawai_hak_akses.modul_id")
                 ->join("pegawai_level_user","pegawai_level_user.id","=","pegawai_hak_akses.pegawai_level_user_id")
                 ->select("pegawai_hak_akses.id", "pegawai.nama", "modul.nama as modul", "pegawai_level_user.nama as level")
                 ->where("pegawai.nama", "like" , "%".$data."%")
                 ->orderBy("pegawai.nama", "asc")
                ->paginate(10);
    }

    static function hak_akses_cari_administrator($data){
        return DB::table("pegawai_hak_akses")
                 ->join("pegawai","pegawai.id","=","pegawai_hak_akses.user_id")
                 ->join("modul","modul.id","=","pegawai_hak_akses.modul_id")
                 ->join("pegawai_level_user","pegawai_level_user.id","=","pegawai_hak_akses.pegawai_level_user_id")
                 ->select("pegawai_hak_akses.id", "pegawai.nama", "modul.nama as modul", "pegawai_level_user.nama as level")
                 ->where("pegawai.nama", "like" , "%".$data."%")
                 ->where("pegawai_level_user_id", "=", "1")
                 ->orderBy("pegawai.nama", "asc")
                ->paginate(10);
    }

    static function hak_akses_cari_hrd($data){
        return DB::table("pegawai_hak_akses")
                 ->join("pegawai","pegawai.id","=","pegawai_hak_akses.user_id")
                 ->join("modul","modul.id","=","pegawai_hak_akses.modul_id")
                 ->join("pegawai_level_user","pegawai_level_user.id","=","pegawai_hak_akses.pegawai_level_user_id")
                 ->select("pegawai_hak_akses.id", "pegawai.nama", "modul.nama as modul", "pegawai_level_user.nama as level")
                 ->where("pegawai.nama", "like" , "%".$data."%")
                 ->where("pegawai_level_user_id", "=", "2")
                 ->orderBy("pegawai.nama", "asc")
                ->paginate(10);
    }

    static function hak_akses_cari_approver($data){
        return DB::table("pegawai_hak_akses")
                 ->join("pegawai","pegawai.id","=","pegawai_hak_akses.user_id")
                 ->join("modul","modul.id","=","pegawai_hak_akses.modul_id")
                 ->join("pegawai_level_user","pegawai_level_user.id","=","pegawai_hak_akses.pegawai_level_user_id")
                 ->select("pegawai_hak_akses.id", "pegawai.nama", "modul.nama as modul", "pegawai_level_user.nama as level")
                 ->where("pegawai.nama", "like" , "%".$data."%")
                 ->where("pegawai_level_user_id", "=", "3")
                 ->orderBy("pegawai.nama", "asc")
                ->paginate(10);
    }

    static function hak_akses_cari_userJ($data){
        return DB::table("pegawai_hak_akses")
                 ->join("pegawai","pegawai.id","=","pegawai_hak_akses.user_id")
                 ->join("modul","modul.id","=","pegawai_hak_akses.modul_id")
                 ->join("pegawai_level_user","pegawai_level_user.id","=","pegawai_hak_akses.pegawai_level_user_id")
                 ->select("pegawai_hak_akses.id", "pegawai.nama", "modul.nama as modul", "pegawai_level_user.nama as level")
                 ->where("pegawai.nama", "like" , "%".$data."%")
                 ->where("pegawai_level_user_id", "=", "4")
                 ->orderBy("pegawai.nama", "asc")
                ->paginate(10);
    }

    static function hak_akses_cari_userC($data){
        return DB::table("pegawai_hak_akses")
                 ->join("pegawai","pegawai.id","=","pegawai_hak_akses.user_id")
                 ->join("modul","modul.id","=","pegawai_hak_akses.modul_id")
                 ->join("pegawai_level_user","pegawai_level_user.id","=","pegawai_hak_akses.pegawai_level_user_id")
                 ->select("pegawai_hak_akses.id", "pegawai.nama", "modul.nama as modul", "pegawai_level_user.nama as level")
                 ->where("pegawai.nama", "like" , "%".$data."%")
                 ->where("pegawai_level_user_id", "=", "5")
                 ->orderBy("pegawai.nama", "asc")
                ->paginate(10);
    }

    static function get_lokasi(){
        return DB::table("pegawai_lokasi")->get();
    }

    static function get_jabatan(){
        return DB::table("pegawai_jabatan")->get();
    }

    static function get_divisi(){
        return DB::table("pegawai_divisi")->get();
    }

    static function get_pegawai(){
        return DB::table("pegawai")
                ->join("users", "users.id", "=", "pegawai.user_id")
                ->join("pegawai_divisi", "pegawai_divisi.id", "=", "pegawai.pegawai_divisi_id")
                ->join("pegawai_jabatan", "pegawai_jabatan.id", "=", "pegawai.pegawai_jabatan_id")
                ->select("pegawai.id", "pegawai.nik","pegawai.user_id", "pegawai.nama", "users.email", "pegawai_jabatan.nama as jabatan", "pegawai_divisi.nama as divisi")
                ->paginate(10);
    }

    static function get_pegawai_cari($data){

        return DB::table("pegawai")
                ->join("users", "users.id", "=", "pegawai.user_id")
                ->join("pegawai_divisi", "pegawai_divisi.id", "=", "pegawai.pegawai_divisi_id")
                ->join("pegawai_jabatan", "pegawai_jabatan.id", "=", "pegawai.pegawai_jabatan_id")
                ->join("pegawai_lokasi", "pegawai_lokasi.id", "=", "pegawai.pegawai_lokasi_id")
                ->where("pegawai.nama", "like", "%".$data."%")
                ->where("pegawai_lokasi_id", "=", "1")
                ->select(   "pegawai.id", 
                            "pegawai.nik",
                            "pegawai.user_id", 
                            "pegawai.nama",
                            "pegawai.lembur_absen_id", 
                            "users.email", 
                            "pegawai_jabatan.nama as jabatan", 
                            "pegawai_divisi.nama as divisi",
                            "pegawai_lokasi.nama as lokasi")
                ->orderBy("pegawai.nama", "asc")
                ->paginate(10);
    }

    static function get_pegawai_cari_cilacap($data){

        return DB::table("pegawai")
                ->join("users", "users.id", "=", "pegawai.user_id")
                ->join("pegawai_divisi", "pegawai_divisi.id", "=", "pegawai.pegawai_divisi_id")
                ->join("pegawai_jabatan", "pegawai_jabatan.id", "=", "pegawai.pegawai_jabatan_id")
                ->join("pegawai_lokasi", "pegawai_lokasi.id", "=", "pegawai.pegawai_lokasi_id")
                ->where("pegawai.nama", "like", "%".$data."%")
                ->where("pegawai_lokasi_id", "=", "2")
                ->select(   "pegawai.id", 
                            "pegawai.nik",
                            "pegawai.user_id", 
                            "pegawai.nama",
                            "pegawai.lembur_absen_id", 
                            "users.email", 
                            "pegawai_jabatan.nama as jabatan", 
                            "pegawai_divisi.nama as divisi",
                            "pegawai_lokasi.nama as lokasi")
                ->orderBy("pegawai.nama", "asc")
                ->paginate(10);
    }

}
