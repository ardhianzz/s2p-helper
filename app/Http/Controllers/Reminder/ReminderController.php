<?php

namespace App\Http\Controllers\Reminder;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Pegawai\Pegawai;
use App\Models\Pegawai\PegawaiDivisi;
use App\Models\Reminder\Reminder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReminderController extends Controller
{

    public function reminder_detail(Request $request){
        return view("reminder.reminder_detail",[
            "title" => "Data Reminder",
            "detail" => Reminder::get_reminder_id(),
        ]);
    }

    public function hapus_catatan(Request $request){
        $pengingat_id = $request->pengingat_id;

    }

    public function tambah_catatan(Request $request){   
        $data['pegawai_divisi_id'] = Pegawai::where('user_id', auth()->user()->id)->get()[0]->pegawai_divisi_id;
        $data['user_id'] = Auth::user()->id;    
        $data['nama'] = $request->nama;
        $data['from'] = $request->from;
        $data['to'] = $request->to;
        $data['tanggal_expired'] = $request->tanggal_expired;
        $data['tanggal_pengingat'] = $request->tanggal_pengingat;
        $data['email'] = $request->email;
        $data['status'] = $request->keterangan;

                DB::table("r_reminder_data")->insert($data);     
                return back()->with("success", "Penambahan Data Berhasil");
    
    }

    public function manage_reminder()
    {
        return view("reminder.manage_reminder", [
            "reminder_data" => Reminder::where("user_id", auth()->user()->id)->get(),
            'title' => 'Manage Reminder'
        ]);
    }


    public function index()
    {
        // $divisi_id = Pegawai::where("user_id", auth()->user()->id)->get(['pegawai_divisi_id']);
           $divisi_id = Pegawai::where("user_id", auth()->user()->id)->get()[0]->pegawai_divisi_id;
        // dd($divisi_id);
        return view("reminder.index", [
            // "reminder_data" => Reminder::where("pegawai_divisi_id", $divisi_id[0]->pegawai_divisi_id)->get(),
               "reminder_data" => Reminder::where("pegawai_divisi_id", $divisi_id)->get(),
            "title" => "Schedule"
        ]);
    }
}
