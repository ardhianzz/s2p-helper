<?php

namespace App\Http\Controllers\Reminder;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
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
            "reminder_data" => Reminder::get_reminder_data(),
            'title' => 'Manage Reminder'
        ]);
    }


    public function index()
    {
        return view("reminder.index", [
            "reminder_data" => Reminder::get_reminder_data(),
            "title" => "Schedule"
        ]);
    }
}
