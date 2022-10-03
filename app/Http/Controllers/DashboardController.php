<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function menu_email(){
        if(!in_array(auth()->user()->id , explode(",",env("ADMIN_SYSTEM")))){
            return abort(403);
        }

        if(request()->id != null){
            return "Ada Request";
        }

        return view("dashboard.mailer",[
            'modul' => DB::table("modul")->get(),
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


        return view("dashboard.administrator",[
            'modul' => DB::table("modul")->get(),
        ]);
    }
    
    public function index(){
        return view('dashboard.mainpage');
    }

    public function index2(){
        //dd("aku");
        return view('dashboard/mainapp');
    }
}
