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
    public function index(){
        $akses = $this->cek_akses(auth()->user()->id); 
        if($akses == "Undefined"){
            abort(403);
        }

        return view("pengumuman.index",[
            "title" => "Pengumuman",
            "hak_akses" => $akses,
        ]);
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
            default: return "Undefined"; break;
        }
    }

}
