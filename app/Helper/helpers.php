<?php

use App\Models\Pegawai\Pegawai;
use Illuminate\Support\Facades\DB;
use App\Models\Pengumuman\PPengumuman;
use App\Models\Pengumuman\PPengumumanRiwayat;
use App\Models\User;


function isJakarta(){
    $lokasi_id= Pegawai::where("user_id", auth()->user()->id)->get()[0]->pegawai_lokasi_id;
    if($lokasi_id == 1){
        return true;
    }
    return false;
}

function isCilacap(){
    $lokasi_id = Pegawai::where("user_id", auth()->user()->id)->get()[0]->pegawai_lokasi_id;
    if($lokasi_id == 2){
        return abort(403); 
    }
}

function isAdminCilacap(){
    $lokasi_id = Pegawai::where("user_id", auth()->user()->id)->get()[0]->pegawai_lokasi_id;
    if($lokasi_id == 2){
        return true; 
    } return false;
}

function peruntukan_rekening($id, $rek_id=0){
    $nik = DB::table("pegawai")->where("user_id", $id)->get()[0]->nik;
    
    $data = DB::table("pegawai_nomor_rekening")
            ->select("pegawai_penggunaan_nomor_rekening.id", "pegawai_jenis_pembayaran.nama", "pegawai_nomor_rekening.id as rek_id")
            ->join("pegawai_penggunaan_nomor_rekening", "pegawai_penggunaan_nomor_rekening.pegawai_nomor_rekening_id", "=", "pegawai_nomor_rekening.id")
            ->join("pegawai_jenis_pembayaran", "pegawai_penggunaan_nomor_rekening.pegawai_jenis_pembayaran_id", "=", "pegawai_jenis_pembayaran.id")
            ->where("pegawai_nomor_rekening.id", "=", $rek_id)
            ->where("nik", $nik)->get();
    return $data;
    // return "<button class='btn btn-info'>".$id."</button>";
}

function peruntukan_rekening_cek($id){
    $nik = DB::table("pegawai")->where("user_id", $id)->get()[0]->nik;
    
    $data = DB::table("pegawai_nomor_rekening")
            ->select("pegawai_penggunaan_nomor_rekening.id", "pegawai_jenis_pembayaran.nama", "pegawai_nomor_rekening.id as rek_id")
            ->join("pegawai_penggunaan_nomor_rekening", "pegawai_penggunaan_nomor_rekening.pegawai_nomor_rekening_id", "=", "pegawai_nomor_rekening.id")
            ->join("pegawai_jenis_pembayaran", "pegawai_penggunaan_nomor_rekening.pegawai_jenis_pembayaran_id", "=", "pegawai_jenis_pembayaran.id")
            ->where("nik", $nik)->get();
    return $data;
    // return "<button class='btn btn-info'>".$id."</button>";
}













function enkipsi_decript($text, $opt){

    $method="AES-128-CTR";
    $key = env("PWD_TOO_COOL");

    if(env("PWD_TOO_COOL") == null ){
        $key ="TukulJ@l4njaL4n";
    }

    $option=0;
    $iv="1251632135716362";

    if($opt == "en"){
        return openssl_encrypt($text, $method, $key, $option, $iv);
        // return "enkripsi";
    }

    if($opt == "de"){
        // return "dekipsi";
        // //
        return openssl_decrypt($text, $method, $key, $option, $iv);
    }

}


function rupiah($angka){
    return  "Rp ".number_format($angka, 2, ',', '.');
}


function total_pengumuman($user_id){
    return pengumuman_belum_dibuka($user_id)+gaji_belum_dibuka($user_id);
}

function pengumuman_belum_dibuka($user_id){
    //Jumlah pengumuman yang publish di Jakarta
    $total_pengumuman = PPengumuman::where("status", "Diumumkan")->where("lokasi", "Jakarta")->count();

    //Jumlah pengumuman yang publish di Cilacap
    $total_pengumuman_clcp = PPengumuman::where("status", "Diumumkan")->where("lokasi", "Cilacap")->count();
    
    //Jumlah pengumuman yang publish di Semua Lokasi
    $total_pengumuman_semua = PPengumuman::where("status", "Diumumkan")->where("lokasi", "Semua")->count();

    //jumlah pengumuman yang sudah dibuka
    $total_dibuka = PPengumumanRiwayat::where("user_id", $user_id)->count();

    //Jika Ada Pengumuman untuk All Lokasi
    if (PPengumuman::where("lokasi", "Semua")->get()){
        if(DB::table("pegawai")->where("id", auth()->user()->id)->get()[0]->pegawai_lokasi_id == 1){
            return $total_pengumuman_semua+$total_pengumuman-$total_dibuka;
        }
        if(DB::table("pegawai")->where("id", auth()->user()->id)->get()[0]->pegawai_lokasi_id == 2){
            return $total_pengumuman_semua+$total_pengumuman_clcp-$total_dibuka;
        }
    }

    //Jika Ada Pengumuman untuk Lokasi Jakarta
    if (PPengumuman::where("lokasi", "Jakarta")->get()){
        if(DB::table("pegawai")->where("id", auth()->user()->id)->get()[0]->pegawai_lokasi_id == 1){
            return $total_pengumuman-$total_dibuka;
        }
    }

    //Jika Ada Pengumuman untuk Lokasi Cilacap
    if (PPengumuman::where("lokasi", "Cilacap")->get()){
        if(DB::table("pegawai")->where("id", auth()->user()->id)->get()[0]->pegawai_lokasi_id == 2){
            return $total_pengumuman_clcp-$total_dibuka;
        }
    }
}

function gaji_belum_dibuka($user_id){
    $nik = DB::table("pegawai")->where("user_id", $user_id)->get()[0]->nik;

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


    function tanggl_id($tanggal="2022-01-01"){
        
        $tahun = substr($tanggal, "0", "4");
        $b = substr($tanggal, "5", "2");
            switch ($b){
                case "01" : $bulan = "Januari"; break;
                case "02" : $bulan = "Februari"; break;
                case "03" : $bulan = "Maret"; break;
                case "04" : $bulan = "April"; break;
                case "05" : $bulan = "Mei"; break;
                case "06" : $bulan = "Juni"; break;
                case "07" : $bulan = "Juli"; break;
                case "08" : $bulan = "Agustus"; break;
                case "09" : $bulan = "September"; break;
                case "10" : $bulan = "Oktober"; break;
                case "11" : $bulan = "November"; break;
                case "12" : $bulan = "Desember"; break;
            }
        $hari = substr($tanggal, "8", "2");

        return $hari." ".$bulan." ".$tahun;

    }

    function menit_to_jam($menit){
        $jam = floor($menit/60);
                if($jam < 1){ $jam2 = "00"; }elseif($jam<10){ $jam2= "0".$jam; }else{ $jam2 = $jam; }
        $m  = $menit-($jam*60);
                if($m < 10){ $menit = "0".$m; }else{ $menit = $m; }
        return $jam2.":".$menit;
    }

    function jumlah_lembur_libur($jam_masuk, $jam_pulang){
        return menit_to_jam(to_menit($jam_pulang)-to_menit($jam_masuk));
    }

    function jumlah_lembur($jam_pulang, $jam_standar, $lembur_pagi=0, $jam_masuk, $jam_masuk_kantor){
        if(to_menit($jam_masuk) == 0 && to_menit($jam_pulang) == 0){
            return menit_to_jam(0);
        }
        //hitung Jumlah Lembur Pagi
        $pagi = 0;
        if($lembur_pagi == 1){
            //jam masuk standar - jam masuk // dalam bentuk menit
            $pagi = to_menit($jam_masuk_kantor) - to_menit($jam_masuk);
        }

        //Cek dulu apakah jam pulang standar lebih kecil dari pada jam pulang sebenarnya
        //Batas Lembur Malam Sampai Jam 7:59 Pagi Atau = 479;
        if(to_menit($jam_standar) > to_menit($jam_pulang) ){
            //Cek : Apakah pulang terlalu awal atau lembur melewati tengah malam;
            if(to_menit($jam_pulang) > 479){
               //Hasil jika pulangnya terlalu awal
               if($lembur_pagi == 1){ return menit_to_jam($pagi); }
               return "00:00";
            }else{
                //Hasil jika pulangnya melebihi tengah malam;
                //(24:00 - Jam Pulang Standar) + Jam Lembur Malam
                $jam1 = (1440 - to_menit($jam_standar))+to_menit($jam_pulang);
                if($lembur_pagi == 1){ return menit_to_jam($pagi+$jam1); }
                return menit_to_jam($jam1);
            }
        }


        //lembur Normal
        $total  = to_menit($jam_pulang) - to_menit($jam_standar);
        if($lembur_pagi == 1){ return menit_to_jam($pagi+$total); }
        return menit_to_jam($total);
    }

    function jam_pulang_standar($data, $jam_masuk, $jam_kerja){

        $jam_masuk_standar = to_menit($jam_masuk);
        //Normal
        if(to_menit($data) <= $jam_masuk_standar){
            $data = ($jam_masuk_standar+to_menit($jam_kerja)); 
            return menit_to_jam($data);
        }else
            //Telat
            $total = ($jam_masuk_standar+to_menit($jam_kerja))+(to_menit($data)-$jam_masuk_standar);
            return menit_to_jam($total);
        }
    
  
    
    function format_jam($data){
        return substr($data,"0", 5);
    }
    
    function to_menit($data){
        return (substr($data, "0", 2) * 60)+substr($data, "3", 2);
    }
?> 
