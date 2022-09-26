<?php
namespace App\Http\Controllers\Pengumuman;
use App\Models\Pegawai;


use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
//use App\Models\ManagemenKendaraan\AKendaraanDokumen;


class PengumumanController extends Controller
{

    public function manage_kebijakan(){
        $this->is_admin(auth()->user()->id);

        return view("pengumuman.manage_kebijakan", [
            "title" => "Managemen Pengumuman",
            "hak_akses" => $this->cek_akses(auth()->user()->id),
        ]);
        
        
    }

    public function index(){
        $akses = $this->cek_akses(auth()->user()->id); 
        return view("pengumuman.index",[
            "title" => "Pengumuman",
            "hak_akses" => $akses,
        ]);
    }










    //Manual Police

    public function is_admin($id){
        $akses = $this->cek_akses($id);
        if($akses == "User" || $akses == "Approver"){
            return abort(403);
        }
            return true;
    }

    public function cek_akses($user_id){
        $tmp = DB::table("pegawai_hak_akses")->where("modul_id", 5)->where("user_id", $user_id)->get();
        $akses = 0;
        if(count($tmp) > 0 ){
            $akses = $tmp[0]->pegawai_level_user_id;
        }
        switch ($akses) {
            case '1': return "Administrator"; break;
            case '2': return "Administrator HRD"; break;
            case '3': return "Approver"; break;
            case '4': return "User"; break;
            default: return abort(403); break;
        }
    }

}
