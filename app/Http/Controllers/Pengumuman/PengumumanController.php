<?php
namespace App\Http\Controllers\Pengumuman;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\SlipGajiImport;
use App\Imports\NomorRekeningImport;
use App\Mail\send_pengumuman;
use App\Models\Pengumuman\PSlipGajiDetail;
use App\Models\Pengumuman\PSlipGaji;
use App\Models\Pengumuman\PPengumuman;
use App\Models\Pengumuman\PPengumumanDokumen;
use App\Models\Pengumuman\PPengumumanRiwayat;
use App\Models\Pegawai\Pegawai;
use App\Models\Pegawai\PegawaiJenisPembayaran;
use App\Models\Pegawai\PegawaiNomorRekening;
use App\Models\Pegawai\PegawaiPenggunaanNomorRekening;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use PegawaiPengunaanNomorRekening;

//use App\Models\ManagemenKendaraan\AKendaraanDokumen;


class PengumumanController extends Controller
{

    public function export_pdf( Request $request){
        $this->its_me($request->nik);

        $data = DB::table("p_slip_gaji_detail")
                        ->where("id", $request->id)
                        ->where("p_slip_gaji_detail.nik", $request->nik)
                        ->get();

        $pegawai = Pegawai::where("nik", $request->nik)->first();

        if(count($data) == 0){ return abort(404); }

        $dataupdate['has_opened'] = date("Y-m-d H:i:s");
        $dataupdate['updated_at'] = date("Y-m-d H:i:s");

        PSlipGajiDetail::where("id", $request->id)->where("nik", $request->nik)->update($dataupdate);

        $no_rekening = PegawaiNomorRekening::join("pegawai_penggunaan_nomor_rekening", "pegawai_nomor_rekening.id", "=", "pegawai_penggunaan_nomor_rekening.pegawai_nomor_rekening_id")
                            ->where("nik", $request->nik)
                            ->where("pegawai_jenis_pembayaran_id", 1)
                            ->get();
        
        if(count($no_rekening) == 0){
            $no_rekening = null;
        }
        
        $data = [
            "subtitle" => "Pengumuman : Preview Slip Gaji",
            "data" => $data,
            "pegawai" => $pegawai,
            "no_rekening" => $no_rekening,
        ];

        $pdf = Pdf::loadView("pengumuman.pdf", $data)->output();
        return response()->streamDownload(
            fn () => print($pdf),
            "Laporan_Slip_Gaji.pdf"
        );
    }

    public function tambah_manual_penggunaan_rekening(Request $request){
        $data['nik'] = $request->nik;
        $data['nama_bank'] = $request->nama_bank;
        $data['nama_akun'] = $request->nama_akun;
        $data['nomor_rekening'] = $request->nomor_rekening;
        $data['updated_at'] = date('Y-m-d H:i:s');
        $data['created_at'] = date('Y-m-d H:i:s');

        if(PegawaiNomorRekening::create($data)){
            return back()->with('success', "proses berhasil");
        }
        return back()->with('error', "proses gagal");
    }

    public function edit_penggunaan_rekening(Request $request){
        
        $data['nama_bank'] = $request->nama_bank;
        $data['nama_akun'] = $request->nama_akun;
        $data['nomor_rekening'] = $request->nomor_rekening;
        $data['updated_at'] = date('Y-m-d H:i:s');

        if(PegawaiNomorRekening::where("id", $request->id)->update($data)){
            return back()->with('success', "proses berhasil");
        }
        return back()->with('error', "proses gagal");
        
    }

    public function tambah_penggunaan_rekening(Request $request){
        $data["user_id"] = $request->user_id; // "1"
        $data["pegawai_nomor_rekening_id"] = $request->pegawai_nomor_rekening_id; // "1"
        $data["pegawai_jenis_pembayaran_id"] = $request->pegawai_jenis_pembayaran_id; // "3-Pembayaran Pengobatan"

        //Parameter yang akan dibandingan dan di input
        $param = explode("-", $data["pegawai_jenis_pembayaran_id"]);

        // dd(count(peruntukan_rekening($data["user_id"])));
        //ambil dulu datanya kalo ga ada langsung proses
        $penggunaan = peruntukan_rekening_cek($data["user_id"]);
        $jum = count($penggunaan);

        $create['pegawai_nomor_rekening_id']   = $request->pegawai_nomor_rekening_id;;
        $create['pegawai_jenis_pembayaran_id'] = $param[0];

        if($jum == 0){
            if(PegawaiPenggunaanNomorRekening::create($create)){
                return back()->with("success", "Penambahan data Berhasil");
            }
            return back()->with("error", "Data sudah tersedia");
        }else{
            $hasil = 0;
            for($i=0; $i<$jum; $i++){
                if($penggunaan[$i]->nama == $param[1]){
                    $hasil += 1;
                }else{
                    $hasil += 0;
                }
            }

            if($hasil == 0){
                if(PegawaiPenggunaanNomorRekening::create($create)){
                    return back()->with("success", "Penambahan data Berhasil");
                }
                return back()->with("error", "Data sudah tersedia");
            }else{
                return back()->with("error", "Data sudah tersedia");
            }
        }

    }

    public function upload_data_rekening(Request $request){
        $this->is_admin(auth()->user()->id);

        if(Excel::import(new NomorRekeningImport, $request->file("no_rekening"))){
            return back()->with("success", "Upload Data Berhasil");
        }
        return back()->with("error", "Upload Data Gagal");
        
        
    }

    public function manage_nomor_rekening(Request $request){
        $this->is_admin(auth()->user()->id);


        if($request->pegawai_jenis_pembayaran_id){
            $jenis_pembayaran = $request->pegawai_jenis_pembayaran_id;
            $nomor_rekening = $request->pegawai_nomor_rekening_id;

            $validate = PegawaiPenggunaanNomorRekening::where("pegawai_jenis_pembayaran_id", $jenis_pembayaran)->where("pegawai_nomor_rekening_id", $nomor_rekening)->count();
            // $validate = PegawaiPenggunaanNomorRekening::where("pegawai_nomor_rekening_id", $nomor_rekening)->count();

            if($validate == 0){
                PegawaiPenggunaanNomorRekening::create(['pegawai_jenis_pembayaran_id'=>$jenis_pembayaran, 'pegawai_nomor_rekening_id'=> $nomor_rekening]);
                return back();
            }else{
                PegawaiPenggunaanNomorRekening::where('pegawai_nomor_rekening_id', $nomor_rekening)->update(['pegawai_jenis_pembayaran_id'=>$jenis_pembayaran]);
                return back();
            }
        }

        if($request->hapus_rekening_id){
            $id = $request->hapus_rekening_id;
            if(PegawaiNomorRekening::where("id", $id)->delete()){
                if(PegawaiPenggunaanNomorRekening::where("pegawai_nomor_rekening_id", $id)->count() != 0){
                    PegawaiPenggunaanNomorRekening::where("pegawai_nomor_rekening_id", $id)->delete();
                }
                return back()->with("success", "Proses Berhasil");
            }
            return back()->with("errror", "Proses Gagal");
        }

        if($request->hapusPenggunaanNomorIni){
            PegawaiPenggunaanNomorRekening::where("id", $request->hapusPenggunaanNomorIni)->delete();
            return back()->with("success", "Data Berhasil Di Hapus");
        }




        $pegawai2 = Pegawai::join("pegawai_nomor_rekening", "pegawai.nik", "=", "pegawai_nomor_rekening.nik")
                                ->select("pegawai.user_id",
                                        "pegawai.nama",
                                        "pegawai.nik",
                                        "pegawai_nomor_rekening.id",
                                        "pegawai_nomor_rekening.nama_bank",
                                        "pegawai_nomor_rekening.nama_akun",
                                        "pegawai_nomor_rekening.nomor_rekening",
                                        )
                                ->where("nama_akun", "like", "%".$request->cari."%")
                                ->paginate(10);


        $lokasi = Pegawai::where("user_id", auth()->user()->id)->get()[0]->pegawai_lokasi_id;
        $hak = $this->cek_akses(auth()->user()->id);
        
        if($lokasi == 2 || $hak != "Administrator HRD"){
            return abort(403);
        } else {
            return view("pengumuman.manage_nomor_rekening", [
                "title" => "Nomor Rekening Pegawai",
                "sub_title" => "Nomor Rekening - PT Sumber Segara Primadaya",
                "pegawai" => Pegawai::get(["nik", "nama"]),
                "pegawai2" => $pegawai2,
                "rekening" => PegawaiNomorRekening::where("nama_akun", "like", "%".$request->cari."%")->orderBy("nama_akun", "asc")->paginate(10),
                "penggunaan" => PegawaiPenggunaanNomorRekening::get(),
                "pembayaran" => PegawaiJenisPembayaran::get(),
                "hak_akses" => $this->cek_akses(auth()->user()->id),
            ]);
        }

    }

    public function pengumuman_slip_gaji_detail(Request $request){
        $this->its_me($request->nik);

        $data = DB::table("p_slip_gaji_detail")
                        ->where("id", $request->id)
                        ->where("p_slip_gaji_detail.nik", $request->nik)
                        ->get();

        $pegawai = Pegawai::where("nik", $request->nik)->first();

        if(count($data) == 0){ return abort(404); }

        $dataupdate['has_opened'] = date("Y-m-d H:i:s");
        $dataupdate['updated_at'] = date("Y-m-d H:i:s");

        PSlipGajiDetail::where("id", $request->id)->where("nik", $request->nik)->update($dataupdate);

        $no_rekening = PegawaiNomorRekening::join("pegawai_penggunaan_nomor_rekening", "pegawai_nomor_rekening.id", "=", "pegawai_penggunaan_nomor_rekening.pegawai_nomor_rekening_id")
                            ->where("nik", $request->nik)
                            ->where("pegawai_jenis_pembayaran_id", 1)
                            ->get();
        
        if(count($no_rekening) == 0){
            $no_rekening = null;
        }


        return view("pengumuman.print_or_preview_2", [
            "subtitle" => "Pengumuman : Preview Slip Gaji",
            "data" => $data,
            "pegawai" => $pegawai,
            "no_rekening" => $no_rekening,
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
        
        $dataupdate['has_opened'] = date("Y-m-d H:i:s");
        $dataupdate['updated_at'] = date("Y-m-d H:i:s");
        PSlipGajiDetail::where("id", $request->previewID)->update($dataupdate);

        $detailGaji = false;

        if($request->previewID != null){
            $detailGaji = PSlipGajiDetail::where("id", $request->previewID)->first();
        }

        return view("pengumuman.detail_slip_gaji_pegawai", [
            "title" => "Pengumuman Slip Gaji",
            "sub_title" => "Slip Gaji - PT Sumber Segara Primadaya",
            "rincian_gaji" => $rincian_data,
            "hak_akses" => $this->cek_akses(auth()->user()->id),
            'detailGaji' => $detailGaji,
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


        
        $no_rekening = PegawaiNomorRekening::join("pegawai_penggunaan_nomor_rekening", "pegawai_nomor_rekening.id", "=", "pegawai_penggunaan_nomor_rekening.pegawai_nomor_rekening_id")
                                            ->where("nik", $request->nik)
                                            ->where("pegawai_jenis_pembayaran_id", 1)
                                            ->get();

        if(count($no_rekening) == 0){
            $no_rekening = null;
        }
        
        

        return view("pengumuman.print_or_preview_2", [
            "subtitle" => "Pengumuman : Preview Slip Gaji",
            "data" => $data,
            "pegawai" => $pegawai,
            "no_rekening" => $no_rekening,
        ]);
        
    }

    public function detail_gaji_pegawai(Request $request){
        $this->is_admin(auth()->user()->id);
        $rincian_data = DB::table("p_slip_gaji_detail")
                        ->join("pegawai", "pegawai.nik", "=", "p_slip_gaji_detail.nik")
                        ->select(   "pegawai.nama", 
                                    "pegawai.nik", 
                                    "p_slip_gaji_id as id", 
                                    "t_pendapatan as pendapatan",
                                    "t_pendapatan_lain as pendapatan_lain",
                                    "t_potongan as potongan",
                                    "t_takehome as total")
                        ->where("p_slip_gaji_id", $request->id)
                        ->where("pegawai.nama", "like", "%".$request->cari."%")
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
        $lokasi = Pegawai::where("user_id", auth()->user()->id)->get()[0]->pegawai_lokasi_id;
        $hak = $this->cek_akses(auth()->user()->id);

        if($lokasi == 2 || $hak != "Administrator HRD"){
            return abort(403);
        } else {
            return view("pengumuman.manage_slip_gaji", [
                "title" => "Managemen Slip Gaji",
                "sub_title" => "Managemen Laporan Pendapatan - PT Sumber Segara Primadaya",
                "slip_gaji" => PSlipGaji::where("periode", "like", "%".$request->cari."%")->
                                            orWhere("status", "like", "%".$request->cari."%")->
                                            orderBy("created_at", "desc")->paginate(5),
                "hak_akses" => $this->cek_akses(auth()->user()->id),
            ]);
        }
        
    }



    public function simpan_penguman_baru(Request $request){
        $this->is_admin(auth()->user()->id);

        $data['nama'] = $request->nama;
        $data['keterangan'] = $request->keterangan;
        $data['lokasi'] = $request->lokasi;
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
            "lokasi" => Pegawai::get_lokasi(),
        ]);
    }

    public function pengumuman_kebijakan(Request $request){
        $this->its_me($request->nik);

        $jakarta = PPengumuman::get_pengumuman_jakarta($request);

        $cilacap = PPengumuman::get_pengumuman_cilacap($request);

        $lokasi = DB::table("pegawai")->where("id", auth()->user()->id)->get()[0]->pegawai_lokasi_id;
        
        if($request->readID){
            $data['p_pengumuman_id'] = $request->readID;
            $data['user_id'] = auth()->user()->id;
            $data['lokasi'] = $lokasi;
            $data['created_at'] = date("Y-m-d H:i:s");
            $data['updated_at'] = date("Y-m-d H:i:s");
            if(PPengumumanRiwayat::where("user_id", $data['user_id'])
                                    ->where("p_pengumuman_id", $data['p_pengumuman_id'])
                                    ->where("lokasi", $data['lokasi'])
                                    ->count() == 0){
                PPengumumanRiwayat::create($data);
            }else{
                PPengumumanRiwayat::where("user_id", $data['user_id'])
                                    ->where("p_pengumuman_id", $data['p_pengumuman_id'])
                                    ->where("lokasi", $data['lokasi'])
                                    ->update(["updated_at" => $data['updated_at']]);
            }
            return back()->with('success', 'Tidak Ada Berkas yang harus dibuka');
        }


        $dokumen = false;
        if($request->previewID != null){
            $dokumen = PPengumumanDokumen::where("p_pengumuman_id", $request->previewID)->get();
            $data['p_pengumuman_id'] = $request->previewID;
            $data['user_id'] = auth()->user()->id;
            $data['lokasi'] = $lokasi;
            $data['created_at'] = date("Y-m-d H:i:s");
            $data['updated_at'] = date("Y-m-d H:i:s");
            if(PPengumumanRiwayat::where("user_id", $data['user_id'])
                                    ->where("p_pengumuman_id", $data['p_pengumuman_id'])
                                    ->where("lokasi", $data['lokasi'])
                                    ->count() == 0){
                PPengumumanRiwayat::create($data);
            }else{
                PPengumumanRiwayat::where("user_id", $data['user_id'])
                                    ->where("p_pengumuman_id", $data['p_pengumuman_id'])
                                    ->where("lokasi", $data['lokasi'])
                                    ->update(["updated_at" => $data['updated_at']]);
            }
        }

        return view("pengumuman.pengumuman_kebijakan", [
            "title" => "Pengumuman Kebijakan Perusahaan",
            "sub_title" => "Pengumuman - PT Sumber Segara Primadaya",
            // "pengumuman" => $semua_pengumuan,
            "pengumuman_jkt" => $jakarta,
            "pengumuman_clcp" => $cilacap,
            "hak_akses" => $this->cek_akses(auth()->user()->id),
            "dokumen" => $dokumen,
        ]);

    }


    public function aksi_publish_pengumuman(Request $request){
        $data["updated_at"]     = date("Y-m-d H:i:s");
        $title                  = DB::table("p_pengumuman")->where("id", $request->publish_pengumuman)->get()[0]->nama;
        $keterangan             = DB::table("p_pengumuman")->where("id", $request->publish_pengumuman)->get()[0]->keterangan;
        $email_all              = DB::table("users")->join("pegawai", "users.id", "=", "pegawai.user_id")
                                                    ->select("users.username", "users.email", "pegawai.nama", "pegawai.pegawai_lokasi_id")
                                                    // ->where("pegawai.user_id", "=", "6")
                                                    ->get(); 
        $email_jkt              = DB::table("users")->join("pegawai", "users.id", "=", "pegawai.user_id")
                                                    ->select("users.username", "users.email", "pegawai.nama", "pegawai.pegawai_lokasi_id")
                                                    ->where("pegawai.pegawai_lokasi_id", "=", "1")
                                                    // ->where("pegawai.user_id", "=", "8")
                                                    ->get();
        $email_clcp             = DB::table("users")->join("pegawai", "users.id", "=", "pegawai.user_id")
                                                    ->select("users.username", "users.email", "pegawai.nama", "pegawai.pegawai_lokasi_id")
                                                    ->where("pegawai.pegawai_lokasi_id", "=", "2")
                                                    // ->where("pegawai.user_id", "=", "7")
                                                    ->get();
        $pengumuman             = [ 'title'      => $title,
                                    'keterangan' => $keterangan,
                                ];
        $lokasi                 = DB::table("p_pengumuman")->where("id", $request->publish_pengumuman)->get()[0]->lokasi;

        if($request->type == "publish"){
            $data['status'] = "Diumumkan";
            if(PPengumuman::where("id", $request->publish_pengumuman)->update($data)){
                if(DB::table("modul_email")->where("id", 1)->get()[0]->keterangan == "Aktif"){
                    if($lokasi == "Jakarta"){
                        Mail::to($email_jkt)->send(new send_pengumuman($pengumuman));
                        return back()->with('success', 'Publish Pengumuman Berhasil');
                    } 
                    if($lokasi == "Cilacap") {
                        Mail::to($email_clcp)->send(new send_pengumuman($pengumuman));
                        return back()->with('success', 'Publish Pengumuman Berhasil');
                    }
                    if($lokasi == "Semua") {
                        Mail::to($email_all)->send(new send_pengumuman($pengumuman));
                        return back()->with('success', 'Publish Pengumuman Berhasil');
                    }
                } elseif(DB::table("modul_email")->where("id", 1)->get()[0]->keterangan == "Tidak Aktif"){
                    return back()->with('success', 'Publish Pengumuman Berhasil Tanpa Dengan Pengiriman Email');
                }
            }else{
                return back()->with('error', 'proses gagal');
            }
        }

        if($request->type == "takedown"){
            $data['status'] = "Belum Diumumkan";
            if(PPengumuman::where("id", $request->publish_pengumuman)->update($data)){
                return back()->with('success', 'Takedown Pengumuman Berhasil');
            }else{
                return back()->with('error', 'proses gagal');
            }
        }
        return back()->with('error', 'proses gagal');
    }



    public function manage_kebijakan(Request $request){
        $this->is_admin(auth()->user()->id);
        $hak = $this->cek_akses(auth()->user()->id);

        $cilacap = DB::table('p_pengumuman')->leftJoin("p_pengumuman_dokumen", "p_pengumuman.id", "=", "p_pengumuman_dokumen.p_pengumuman_id")
                                            ->select("p_pengumuman.id", "p_pengumuman.nama", "p_pengumuman.keterangan","p_pengumuman.lokasi","p_pengumuman.status", "p_pengumuman_dokumen.path")
                                            ->where("p_pengumuman.nama", "like", "%".$request->cari."%")
                                            ->where("status", "=","Diumumkan")
                                            ->where("lokasi", "=", "Cilacap")
                                            ->orWhere("lokasi", "=", "Semua")
                                            ->orderBy("p_pengumuman.id", "desc")->paginate(10);

        $jakarta = DB::table('p_pengumuman')->leftJoin("p_pengumuman_dokumen", "p_pengumuman.id", "=", "p_pengumuman_dokumen.p_pengumuman_id")
                                            ->select("p_pengumuman.id", "p_pengumuman.nama", "p_pengumuman.keterangan","p_pengumuman.lokasi","p_pengumuman.status", "p_pengumuman_dokumen.path")
                                            ->where("p_pengumuman.nama", "like", "%".$request->cari."%")
                                            ->orderBy("p_pengumuman.id", "desc")
                                            ->paginate(10);

        if($request->readID){
            return back()->with('success', 'Tidak Ada Berkas yang harus dibuka');
        }

        $dokumen = false;
        if($request->previewID != null){
            $dokumen = PPengumumanDokumen::where("p_pengumuman_id", $request->previewID)->get();
        }

        if ($hak != "Administrator HRD" ){
            return abort(403);
        } else {
            return view("pengumuman.manage_kebijakan", [
                "title" => "Managemen Pengumuman",
                "sub_title" => "Managemen Pengumuman - PT Sumber Segara Primadaya",
                "pengumuman" => $cilacap,
                "pengumuman_jkt" => $jakarta,
                // "pengumuman_clcp" => $pengumuman_clcp,
                "hak_akses" => $this->cek_akses(auth()->user()->id),
                "dokumen" => $dokumen,
            ]);    
        }

        
        
    }

    public function index(){
        $akses = $this->cek_akses(auth()->user()->id);

        $nik = Pegawai::where("user_id", auth()->user()->id)->get()[0]->nik;

        //Pengumuman Gaji yang belum dibuka
        $infoGaji = $this->gaji_belum_dibuka($nik);
        
        //Pengumuman Kebijakan yang belum dibuka
        $pengumuman = pengumuman_belum_dibuka(auth()->user()->id);
        

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

        //jumlah pengumuman yang sudah dibuka
        $total_dibuka = PPengumumanRiwayat::where("user_id", $user_id)->count();

        return $total_pengumuman-$total_dibuka;
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
