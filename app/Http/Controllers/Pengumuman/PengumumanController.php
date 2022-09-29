<?php
namespace App\Http\Controllers\Pengumuman;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\SlipGajiImport;
use App\Models\Pengumuman\PSlipGajiDetail;
use App\Models\Pengumuman\PSlipGaji;
use App\Models\Pegawai\Pegawai;
use Illuminate\Support\Facades\Auth;
//use App\Models\ManagemenKendaraan\AKendaraanDokumen;


class PengumumanController extends Controller
{

    public function print_gaji_hrd(Request $request){
        $this->is_admin(auth()->user()->id);
        if(Pegawai::where("nik", $request->nik)->count() == 0){ return abort(404);}
        //ID Slip Gaji
        dd($request->dan);
        
        $user_id = Pegawai::where("nik", $request->nik)->get();
        dd($user_id);
        
    }

    public function detail_gaji_pegawai(Request $request){
        $this->is_admin(auth()->user()->id);
        
        $rincian_data = DB::table("p_slip_gaji_detail")
                            ->join("pegawai", "pegawai.nik", "=", "p_slip_gaji_detail.nik")
                            ->select("pegawai.nama", "pegawai.nik", "p_slip_gaji_detail.id")
                            ->selectRaw('(   i_gaji_dasar
                                            +i_tunjangan
                                            +i_tunjangan_jabatan
                                            +i_tunjangan_komunikasi
                                            +i_tunjangan_pensiun
                                            +i_tunjangan_cuti
                                            +i_lembur
                                            +i_hari_raya
                                            +i_work_anniversary
                                            +i_jasa_kerja
                                            +i_rapel
                                            +i_lain_1
                                            +i_lain_2
                                            +i_lain_3) as pendapatan')
                            ->selectRaw("(   o_bpjs_tenaga_kerja
                                            +o_bpjs_kesehatan
                                            +o_bpjs_dana_pensiun
                                            +o_komunikasi
                                            +o_lain_1
                                            +o_lain_2
                                            +o_lain_3) as potongan")
                            ->where("p_slip_gaji_id", $request->id)
                            ->where("pegawai.nama", "like", "%".$request->cari."%")
                            ->orWhere("pegawai.nik", "like", "%".$request->cari."%")
                            ->paginate(10);

        return view("pengumuman.detail_slip_gaji", [
            "title" => "Managemen Pengumuman",
            "sub_title" => "Rincian Laporan Pendapatan - PT Sumber Segara Primadaya",
            "rincian_gaji" => $rincian_data,
            "hak_akses" => $this->cek_akses(auth()->user()->id),
        ]);
    }

    public function hapus_slip_gaji(Request $request){
        $this->is_admin(auth()->user()->id);
        $id = $request->id;

        if(PSlipGaji::where("id", $id)->delete() && PSlipGajiDetail::where("p_slip_gaji_id", $id)->delete()){
            return back()->with("success", "Publish Data berhasil");
        }
            return back()->with("error", "Publish Error");
    }


    public function takedown_slip_gaji(Request $request){
        $this->is_admin(auth()->user()->id);
        
        $data['status'] = "Belum Diumumkan";
        $data['updated_at'] = date("Y-m-d H:i:s");
        $id = $request->id;

        if(PSlipGaji::where("id", $id)->update($data)){
            return back()->with("success", "Takedown Data berhasil");
        }
            return back()->with("error", "Publish Error");

    }


    public function publish_slip_gaji(Request $request){
        $this->is_admin(auth()->user()->id);
        
        $data['updated_at'] = date("Y-m-d H:i:s");
        $data['status'] = "Diumumkan";
        $transfer['tanggal'] = $request->tanggal;
        $id = $request->id;

        if(PSlipGaji::where("id", $id)->update($data) && PSlipGajiDetail::where("p_slip_gaji_id", $id)->update($transfer)){
            return back()->with("success", "Publish Data berhasil");
        }
            return back()->with("error", "Publish Error");
    }




    public function simpan_upload_data(Request $request){
        $this->is_admin(auth()->user()->id);

        $data['periode'] = $request->periode;
        $data['status'] = "Belum Diumumkan";
        
        if(PSlipGaji::where("periode", $data['periode'])->count() > 0){
            return redirect("/pengumuman/manage_slip_gaji")->with("error", "Periode sudah dibuat");
        }
        PSlipGaji::create($data);
        Excel::import(new SlipGajiImport, $request->file("slip_gaji"));
        return redirect("/pengumuman/manage_slip_gaji")->with("success", "Import Data berhasil");
    }

    public function manage_slip_gaji(Request $request){
        $this->is_admin(auth()->user()->id);
        
        
        return view("pengumuman.manage_slip_gaji", [
            "title" => "Managemen Pengumuman",
            "sub_title" => "Managemen Laporan Pendapatan - PT Sumber Segara Primadaya",
            "slip_gaji" => PSlipGaji::where("periode", "like", "%".$request->cari."%")->
                                        orWhere("status", "like", "%".$request->cari."%")->
                                        orderBy("created_at", "desc")->paginate(10),
            "hak_akses" => $this->cek_akses(auth()->user()->id),
        ]);
    }



    public function simpan_penguman_baru(Request $request){
        $this->is_admin(auth()->user()->id);
        dd($request->all());
    }

    public function membuat_pengumuman_baru(){
        $this->is_admin(auth()->user()->id);


        return view("pengumuman.form_pengumuman", [
            "title" => "Managemen Pengumuman",
            "sub_title" => "Membuat Pengumuman - PT Sumber Segara Primadaya",
            "hak_akses" => $this->cek_akses(auth()->user()->id),
        ]);
    }



    public function manage_kebijakan(Request $request){
        $this->is_admin(auth()->user()->id);

        return view("pengumuman.manage_kebijakan", [
            "title" => "Managemen Pengumuman",
            "sub_title" => "Managemen Pengumuman - PT Sumber Segara Primadaya",
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
