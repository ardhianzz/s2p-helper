<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Pegawai;

class UserController extends Controller
{
    public function hak_akses(){
        // dd(Pegawai::hak_akses());
        return view("pegawai.hak_akses",[
            'title'   => "Manageman Hak Akses",
            'hak_akses' => Pegawai::hak_akses(),
        ]);
    }


    public function jabatan(){
        return view("pegawai.jabatan",[
            'title'   => "Manageman Jabatan",
            'jabatan' => Pegawai::get_jabatan(),
        ]);
    }

    public function divisi(){
        return view("pegawai.divisi",[
            'title'   => "Manageman Divisi",
            'divisi' => Pegawai::get_divisi(),
        ]);
    }


    public function index(){
        // dd(Pegawai::get_pegawai());
        return view('pegawai/index', 
            [   'title' => "Pegawai",
                'pegawai' => Pegawai::get_pegawai(),
        ]);
    }
}
