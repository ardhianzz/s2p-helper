<?php

namespace App\Http\Controllers\Reminder;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Imports\ReminderImport;
use App\Models\Pegawai\Pegawai;
use App\Models\Pegawai\PegawaiDivisi;
use App\Models\Reminder\Reminder;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class ReminderController extends Controller
{
    public function import_reminder(Request $request){
        Excel::import(new ReminderImport, $request->file("import"));
        return redirect("/reminder/manage_reminder")->with("success", "Import Data berhasil");
    }

    public function reminder_detail(Request $request){
        $id = $request->id;

        return view("reminder.reminder_detail",[
            "title" => "Reminder Data",
            "detail" => Reminder::get_reminder_id($id),
        ]);
    }
    public function reminder_detail_divisi(Request $request){
        $id = $request->id;

        return view("reminder.reminder_detail_divisi",[
            "title" => "Reminder Data",
            "detail" => Reminder::get_reminder_id($id),
        ]);
    }

    public function edit_data_reminder(Request $request){
        $id['id'] = $request->r_reminder_data;
        $data['nama'] = $request->nama;
        $data['jenis'] = $request->jenis;
        $data['from'] = $request->from;
        $data['to'] = $request->to;
        $data['tanggal_expired'] = $request->tanggal_expired;
        $data['pengingat'] = $request->pengingat;
        if($request->pengingat == "Month"){
            $data['tanggal_pengingat'] = Carbon::createFromFormat('Y-m-d', $request->tanggal_pengingat )->format("d");
        }
        if($request->pengingat == "Year"){
            $data['tanggal_pengingat'] = Carbon::createFromFormat('Y-m-d', $request->tanggal_pengingat )->format("m-d");
        }
        if($request->pengingat == "One"){
            $data['tanggal_pengingat'] = Carbon::createFromFormat('Y-m-d', $request->tanggal_pengingat )->format("Y-m-d");
        }
        $data['email'] = $request->email;
        $data['email_2'] = $request->email_2;
        $data['email_3'] = $request->email_3;
        $data['keterangan'] = $request->keterangan;
        $data['updated_at'] = now("asia/jakarta");

        if(DB::table("r_reminder_data")->where($id)->update($data)){
            return back()->with("success", "Perubahan Data Berhasil");
        }
        return back()->with("error", "Perubahan Data Tidak Berhasil");
    }

    public function hapus_catatan(Request $request){
        $id['id'] = $request->r_reminder_data;

        if(DB::table("r_reminder_data")->delete($id));
        return back()->with("success", "Penghapusan Data Berhasil");


    }

    public function tambah_catatan(Request $request){   
        $data['pegawai_divisi_id'] = Pegawai::where('user_id', auth()->user()->id)->get()[0]->pegawai_divisi_id;
        $data['user_id'] = Auth::user()->id;  
        $data['nama'] = $request->nama;
        $data['jenis'] = $request->jenis;
        $data['from'] = $request->from;
        $data['to'] = $request->to;
        $data['tanggal_expired'] = $request->tanggal_expired;
        $data['pengingat'] = $request->pengingat;
        if($request->pengingat == "Month"){
            $data['tanggal_pengingat'] = Carbon::createFromFormat('Y-m-d', $request->tanggal_pengingat )->format("d");
        }
        if($request->pengingat == "Year"){
            $data['tanggal_pengingat'] = Carbon::createFromFormat('Y-m-d', $request->tanggal_pengingat )->format("m-d");
        }
        if($request->pengingat == "One"){
            $data['tanggal_pengingat'] = Carbon::createFromFormat('Y-m-d', $request->tanggal_pengingat )->format("Y-m-d");
        }
        $data['email'] = $request->email;
        $data['email_2'] = $request->email_2;
        $data['email_3'] = $request->email_3;
        $data['keterangan'] = $request->keterangan;
        $data['created_at'] = now("asia/jakarta");
        $data['updated_at'] = now("asia/jakarta");

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
        $divisi_id = Pegawai::where("user_id", auth()->user()->id)->get()[0]->pegawai_divisi_id;
        $jabatan_id = Pegawai::where("user_id", auth()->user()->id)->get()[0]->pegawai_jabatan_id;
        $jabatan = DB::table("pegawai_jabatan")->where("id", $jabatan_id)->get()[0]->nama;
        
        // dd($jabatan);
        if($jabatan == "Direktur"){
            $data = Reminder::get();
        }else{
            $data = Reminder::where("pegawai_divisi_id", $divisi_id)->get();
        }
        
        return view("reminder.index", [
                "reminder_data" => $data,
                "title" => "Time Schedule"
            ]);
    }
}
