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
use App\Models\Pengumuman\PPengumuman;
use App\Models\Pengumuman\PPengumumanDokumen;
use App\Models\Pegawai\Pegawai;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

//use App\Models\ManagemenKendaraan\AKendaraanDokumen;


class PengumumanController extends Controller
{

    public function pengumuman_slip_gaji_detail(Request $request){
        $this->its_me($request->nik);

        $data = DB::table("p_slip_gaji_detail")
                        ->where("id", $request->id)
                        ->where("p_slip_gaji_detail.nik", $request->nik)
                        ->get();

        $pegawai = Pegawai::where("nik", $request->nik)->get()[0];

        if(count($data) == 0){ return abort(404); }

        return view("pengumuman.print_or_preview", [
            "subtitle" => "Pengumuman : Preview Slip Gaji",
            "data" => $data,
            "pegawai" => $pegawai,
        ]);

    }

    public function pengumuman_slip_gaji(Request $request){
        $this->its_me($request->nik);

        $rincian_data = DB::table("p_slip_gaji")->where("pegawai.nik", $request->nik)
                        ->select(  "p_slip_gaji_detail.id", 
                                    "pegawai.nama", 
                                    "p_slip_gaji.periode", 
                                    "p_slip_gaji_detail.t_pendapatan", 
                                    "p_slip_gaji_detail.nik", 
                                    "p_slip_gaji_detail.t_potongan", 
                                    "p_slip_gaji_detail.has_opened", 
                                    "p_slip_gaji_detail.t_takehome")
                        ->join("p_slip_gaji_detail", "p_slip_gaji.id", "=", "p_slip_gaji_detail.p_slip_gaji_id")
                        ->join("pegawai", "pegawai.nik", "=", "p_slip_gaji_detail.nik")
                        ->where("p_slip_gaji.status", "Diumumkan")
                        // ->where("p_slip_gaji_detail.nik", $request->nik)
                        ->paginate(10);

        return view("pengumuman.detail_slip_gaji_pegawai", [
            "title" => "Pengumuman Slip Gaji",
            "sub_title" => "Slip Gaji - PT Sumber Segara Primadaya",
            "rincian_gaji" => $rincian_data,
            "hak_akses" => $this->cek_akses(auth()->user()->id),
        ]);
    }

    public function print_gaji_hrd(Request $request){
        $this->is_admin(auth()->user()->id);
        if(Pegawai::where("nik", $request->nik)->count() == 0){ return abort(404);}

        $data = DB::table("p_slip_gaji_detail")
                        ->where("p_slip_gaji_id", $request->dan)
                        ->where("p_slip_gaji_detail.nik", $request->nik)
                        ->get();

        $pegawai = Pegawai::where("nik", $request->nik)->first();

        if(count($data) == 0){ return abort(404); }

        return view("pengumuman.print_or_preview", [
            "subtitle" => "Pengumuman : Preview Slip Gaji",
            "data" => $data,
            "pegawai" => $pegawai,
        ]);
        
    }

    public function detail_gaji_pegawai(Request $request){
        $this->is_admin(auth()->user()->id);
        
        // $rincian_data = DB::table("p_slip_gaji_detail")
        //                     ->join("pegawai", "pegawai.nik", "=", "p_slip_gaji_detail.nik")
        //                     ->select("pegawai.nama", "pegawai.nik", "p_slip_gaji_detail.id")
        //                     ->selectRaw('(   i_gaji_dasar
        //                                     +i_tunjangan
        //                                     +i_tunjangan_jabatan
        //                                     +i_tunjangan_komunikasi
        //                                     +i_tunjangan_pensiun
        //                                     +i_tunjangan_cuti
        //                                     +i_lembur
        //                                     +i_hari_raya
        //                                     +i_work_anniversary
        //                                     +i_jasa_kerja
        //                                     +i_rapel
        //                                     +i_lain_1
        //                                     +i_lain_2
        //                                     +i_lain_3) as pendapatan')
        //                     ->selectRaw("(   o_bpjs_tenaga_kerja
        //                                     +o_bpjs_kesehatan
        //                                     +o_bpjs_dana_pensiun
        //                                     +o_komunikasi
        //                                     +o_lain_1
        //                                     +o_lain_2
        //                                     +o_lain_3) as potongan")
        //                     ->where("p_slip_gaji_id", $request->id)
        //                     ->where("pegawai.nama", "like", "%".$request->cari."%")
        //                     ->orWhere("pegawai.nik", "like", "%".$request->cari."%")
        //                     ->paginate(10);

        $rincian_data = DB::table("p_slip_gaji_detail")
                        ->join("pegawai", "pegawai.nik", "=", "p_slip_gaji_detail.nik")
                        ->select(   "pegawai.nama", 
                                    "pegawai.nik", 
                                    "p_slip_gaji_id as id", 
                                    "t_pendapatan as pendapatan",
                                    "t_potongan as potongan",
                                    "t_takehome as total")
                        ->where("p_slip_gaji_id", $request->id)
                        ->where("pegawai.nama", "like", "%".$request->cari."%")
                        // ->orWhere("pegawai.nik", "like", "%".$request->cari."%")
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
        $data['nama'] = $request->nama;
        $data['keterangan'] = $request->keterangan;
        $data['status'] = "Belum Diumumkan";
        $data['created_at'] = date("Y-m-d H:i:s");
        $data['updated_at'] = date("Y-m-d H:i:s");

        $pengumuman_id = PPengumuman::create($data)->id;

        if($request->file != null){
            
            if($this->simpan_dokumen($request->file, $pengumuman_id, "pengumuman")){
                return back()->with("success", "Pengumuman Baru berhasil di upload");
            }else{
                return back()->with("error", "Proses Gagal");

            }
        }else{
            return back()->with("success", "Draft Pengumuman Berhasil di Upload");
        }
    }


    public function simpan_dokumen($file, $id="", $sub_folder){      
        //move file
        $name1 = $file->getClientOriginalName();
        $tgl = date("YmdHis");
        $str = str_replace(" ", "_", $tgl."_".$name1);
        $filename = $id."_".$str;

        $file-> move(public_path("/dokumen/".$sub_folder."/".$id.'/'), $filename);

        $data['p_pengumuman_id'] = $id;
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['nama'] = $name1;
        $data['path'] = "/dokumen/".$sub_folder."/".$id."/".$filename;

        return PPengumumanDokumen::create($data); 
        
    }


    public function membuat_pengumuman_baru(){
        $this->is_admin(auth()->user()->id);


        return view("pengumuman.form_pengumuman", [
            "title" => "Managemen Pengumuman",
            "sub_title" => "Membuat Pengumuman - PT Sumber Segara Primadaya",
            "hak_akses" => $this->cek_akses(auth()->user()->id),
        ]);
    }

    public function pengumuman_kebijakan(Request $request){
        $this->its_me($request->nik);

        $semua_pengumuan = PPengumuman::  where("status", "=","Diumumkan")
                                        ->where("nama", "like", "%".$request->cari."%")
                                        ->orderBy("id", "desc")->paginate(10);

        $dokumen = false;
        if($request->previewID != null){
            $dokumen = PPengumumanDokumen::where("p_pengumuman_id", $request->previewID)->get();
        }

        return view("pengumuman.pengumuman_kebijakan", [
            "title" => "Pengumuman Kebijakan Perushaan",
            "sub_title" => "Pengumuman - PT Sumber Segara Primadaya",
            "pengumuman" => $semua_pengumuan,
            "hak_akses" => $this->cek_akses(auth()->user()->id),
            "dokumen" => $dokumen,
        ]);

    }


    public function aksi_publish_pengumuman(Request $request){
        $data["updated_at"] = date("Y-m-d H:i:s");
        
        if($request->type == "publish"){
            $data['status'] = "Diumumkan";
            if(PPengumuman::where("id", $request->publish_pengumuman)->update($data)){
                return back()->with('success', 'Publish Pengumuman Berhasil');
            }else{
                return back()->with('error', 'proses gagal');
            }
        }

        if($request->type == "takedown"){
            $data['status'] = "Belum Diumumkan";
            if(PPengumuman::where("id", $request->publish_pengumuman)->update($data)){
                return back()->with('success', 'Publish Pengumuman Berhasil');
            }else{
                return back()->with('error', 'proses gagal');
            }
        }
        return back()->with('error', 'proses gagal');
    }



    public function manage_kebijakan(Request $request){
        $this->is_admin(auth()->user()->id);


        $semua_pengumuan = PPengumuman::where("nama", "like", "%".$request->cari."%")
                                        ->orWhere("keterangan", "like", "%".$request->cari."%")
                                        ->orderBy("id", "desc")->paginate(10);

        $dokumen = false;
        if($request->previewID != null){
            $dokumen = PPengumumanDokumen::where("p_pengumuman_id", $request->previewID)->get();
        }

        return view("pengumuman.manage_kebijakan", [
            "title" => "Managemen Pengumuman",
            "sub_title" => "Managemen Pengumuman - PT Sumber Segara Primadaya",
            "pengumuman" => $semua_pengumuan,
            "hak_akses" => $this->cek_akses(auth()->user()->id),
            "dokumen" => $dokumen,
        ]);
        
        
    }

    public function index(){
        $akses = $this->cek_akses(auth()->user()->id);

        $nik = Pegawai::where("user_id", auth()->user()->id)->get()[0]->nik;

        //Pengumuman Gaji yang belum dibuka
        $infoGaji = $this->gaji_belum_dibuka($nik);
        
        //Pengumuman Kebijakan yang belum dibuka
        $pengumuman = $this->pengumuman_belum_dibuka(auth()->user()->id);
        

        return view("pengumuman.index",[
            "title" => "Pengumuman",
            "nik" => Pegawai::where("user_id", auth()->user()->id)->get(),
            "hak_akses" => $akses,
            "infoGaji" => $infoGaji,
            "infoPengumuman" => $pengumuman,
        ]);
    }

    public function pengumuman_belum_dibuka($user_id){
        //Jumlah pengumuma yang publish
        $total_pengumuman = PPengumuman::where("status", "Diumumkan")->count();

        return $total_pengumuman;
    }

    public function gaji_belum_dibuka($nik){

        $total = DB::table("p_slip_gaji_detail")
                        ->join("p_slip_gaji", "p_slip_gaji.id", "=", "p_slip_gaji_detail.p_slip_gaji_id")
                        ->where("nik", $nik)
                        ->where("status", "Diumumkan")
                        ->count();

        $sudahDibuka = DB::table("p_slip_gaji_detail")
                        ->join("p_slip_gaji", "p_slip_gaji.id", "=", "p_slip_gaji_detail.p_slip_gaji_id")
                        ->where("nik", $nik)
                        ->where("status", "Diumumkan")
                        ->where("has_opened", "!=", null)
                        ->count();

        return $total-$sudahDibuka;
    }






    //Manual Police

    public function its_me($nik){
        $user_id = auth()->user()->id;
        if(Pegawai::where("nik", $nik)->count() == 0){
            return abort(404);
        }
        $id_req = Pegawai::where("nik", $nik)->get()[0]->user_id;

        if($user_id == $id_req){
            return true;
        }
        return abort(403);
    }

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
