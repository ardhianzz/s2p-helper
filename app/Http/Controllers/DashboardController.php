<?php

namespace App\Http\Controllers;

use App\Models\Pegawai\Pegawai;
use App\Models\Sessions\Sessions;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{

    public function navbar(){
        return view("layout.navbar");
    }

    public function aktifitas(){
        if(!in_array(auth()->user()->id , explode(",",env("ADMIN_SYSTEM")))){
            return abort(403);
        }

        $data = Sessions::get_sessions();

        return view("dashboard.aktifitas", [
            'title' => "History Login",
            'data' => $data,
        ]);
    }

    public function menu_tema(){
        if(!in_array(auth()->user()->id , explode(",",env("ADMIN_SYSTEM")))){
            return abort(403);
        }

        if(request()->id != null){
            for($i=0; $i<count(request()->id); $i++){
                DB::table("modul_tema")->where("id", request()->id[$i])->update(["keterangan" => request()->keterangan[$i]]);
            }
        }

        return view("dashboard.tema",[
            'modul' => DB::table("modul_tema")->get(),
        ]);

    }

    public function menu_email(){
        if(!in_array(auth()->user()->id , explode(",",env("ADMIN_SYSTEM")))){
            return abort(403);
        }

        if(request()->id != null){
            for($i=0; $i<count(request()->id); $i++){
                DB::table("modul_email")->where("id", request()->id[$i])->update(["keterangan" => request()->keterangan[$i]]);
            }
        }

        return view("dashboard.mailer",[
            'modul' => DB::table("modul_email")->get(),
        ]);

    }


    public function menu_administrator(){
        if(!in_array(auth()->user()->id , explode(",",env("ADMIN_SYSTEM")))){
            return abort(403);
        }
        
        if(request()->id != null){
            for($i=0; $i<count(request()->id); $i++){
                DB::table("modul")->where("id", request()->id[$i])->update(["keterangan" => request()->keterangan[$i]]);
            }
        }

        // if(DB::table("modul_tema")->where("id", 1)->get()[0]->keterangan == "Aktif"){
        //     return view("dashboard.administrator_tooltip",[
        //         'modul' => DB::table("modul")->get(),
        //     ]);
        // } else {
        //     return view("dashboard.administrator",[
        //         'modul' => DB::table("modul")->get(),
        //     ]);
        // }
        return view("dashboard.administrator",[
            'modul' => DB::table("modul")->get(),
        ]);
    }
    
    public function index(){
        return view('dashboard.mainpage');
    }

    public function index2(){
        //dd("aku");

        $a = DB::table("pegawai")->join("pegawai_lampiran", "pegawai.user_id", "=", "pegawai_lampiran.pegawai_id")
                                ->select("pegawai.user_id","pegawai_lampiran.path")
                                ->where("pegawai_id", auth()->user()->id)
                                ->count();

        if($a == true){
            return view("dashboard.mainapp", [
                'dokumen_foto' => DB::table("pegawai_lampiran")->where("pegawai_id", auth()->user()->id)->get()[0]->path,
            ]);
        } else {
            return view("dashboard.mainapp",[
                'dokumen_foto' => "/img/user_image.png",
            ]);
        }
    }
}
