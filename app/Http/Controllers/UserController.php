<?php

namespace App\Http\Controllers;

use App\Mail\notif_reset_password;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Pegawai\Pegawai;
use App\Models\Pegawai\PegawaiDokumen;
use App\Models\PegawaiLampiran;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    public function profile_pegawai($id, Request $request){
        
        $id_login = auth()->user()->id;
        
        if($id_login != $id){
            return abort(403);
        }
        $a = DB::table("pegawai")->join("pegawai_lampiran", "pegawai.user_id", "=", "pegawai_lampiran.pegawai_id")
                                ->select("pegawai.user_id","pegawai_lampiran.path")
                                ->where("pegawai_id", auth()->user()->id)
                                ->count();
        if($a == true ){
            return view("pegawai.profile",[
                "title" => "Profile",
                'divisi' => Pegawai::get_divisi(),
                'pegawai' => Pegawai::get_profile($id),
                'jabatan' => Pegawai::get_jabatan(),
                'lokasi' => Pegawai::get_lokasi(),
                'dokumen_foto' => DB::table("pegawai_lampiran")->where("pegawai_id", auth()->user()->id)->get()[0]->path,
            ]);
        } else {
            return view("pegawai.profile",[
                "title" => "Profile",
                'divisi' => Pegawai::get_divisi(),
                'pegawai' => Pegawai::get_profile($id),
                'jabatan' => Pegawai::get_jabatan(),
                'lokasi' => Pegawai::get_lokasi(),
                'dokumen_foto' => "/img/user_image.png",
            ]);
        }
    }

    public function reset_password(Request $request){
        $id["id"] = $request->id;
        $data["password"] = bcrypt($request->password1);

        //dd(bcrypt($request->password1));
        if($request->password1 != $request->password2){
            return back()->with('error', "Password yang anda masukan tidak sama");
        } 
        DB::table('users')->where($id)->update($data);

        $data_ip = DB::table("users")->where("id", auth()->user()->id)->get()[0]->last_login_ip;
        $data_waktu = DB::table("users")->where("id", auth()->user()->id)->get()[0]->last_login_at;
        $check = geoip()->getLocation(trim(shell_exec("curl https://ifconfig.co")));
        // $ip = trim(shell_exec("curl https://ifconfig.co"));
        $agent = request()->header('user-agent');
        $email = DB::table("users")->where("id", auth()->user()->id)->get()[0]->email;

        $reset = [
            'title' => 'Notifikasi Keamanan',
            'ip_local' => $data_ip,
            'waktu' => $data_waktu,
            'ip_public' => $check,
            'user_agent' => $agent,
            ];

            Mail::to($email)->send(new notif_reset_password($reset));
        return back()->with('success', "Data berhasil dirubah");
    }

    public function pegawai_put_detail(Request $request){

        $lokasi = Pegawai::where("user_id", auth()->user()->id)->get()[0]->pegawai_lokasi_id;
        $pegawai['id'] = $request->id;
        $data['nik'] = $request->nik;
        $data['nama'] = $request->nama;
        $data['pegawai_jabatan_id'] = $request->pegawai_jabatan_id;
        $data['pegawai_divisi_id'] = $request->pegawai_divisi_id;

        if ($lokasi == 1){
            $data_lokasi['pegawai_lokasi_id'] = $request->pegawai_lokasi_id;
        }
        if ($lokasi == 2){
            $data_lokasi['pegawai_lokasi_id'] = 2;
        }
        //$data['email'] = $request->email;

        $user['email'] = $request->email;
        $id['id'] = $request->user_id;

        $validate0 = DB::table('pegawai')->where($pegawai)->update($data_lokasi);
        $validate1 = DB::table('pegawai')->where($pegawai)->update($data);
        $validate2 = DB::table('users')->where($id)->update($user);

        if($request->file != null){
            if($this->simpan_dokumen($request->file, $id['id'],"profile")){ 
                if($validate0){
                    if($request->pegawai_lokasi_id == 1){
                        return redirect('/pegawai/jakarta')->with('success', "Identitas, Lokasi dan Foto Profile berhasil diubah");
                    } elseif($request->pegawai_lokasi_id == 2){
                        return redirect('/pegawai/cilacap')->with('success', "Identitas, Lokasi dan Foto Profile berhasil diubah");
                    }
                } else {
                    return back()->with('success', "Identitas dan Foto Profile Berhasil diubah");
                } 
            } else {
                return back()->with('error', "Foto Profile Gagal diubah");
            }
        } elseif($validate1 || $validate2){
            if($validate0){
                if($request->pegawai_lokasi_id == 1){
                    return redirect('/pegawai/jakarta')->with('success', "Identitas dan Lokasi berhasil diubah");
                } elseif($request->pegawai_lokasi_id == 2){
                    return redirect('/pegawai/cilacap')->with('success', "Identitas dan Lokasi berhasil diubah");
                }
            } else {
                return back()->with('success', "Identitas Berhasil diubah");
            }
        }
        if($validate0){
            if($request->pegawai_lokasi_id == 1){
                return redirect('/pegawai/jakarta')->with('success', "Lokasi berhasil diubah");
            }
            elseif($request->pegawai_lokasi_id == 2){
                return redirect('/pegawai/cilacap')->with('success', "Lokasi berhasil diubah");
            }
        }
    }

    public function pegawai_put(Request $request){

        $pegawai['id'] = $request->id;
        $data['nik'] = $request->nik;
        $data['nama'] = $request->nama;

        $user['email'] = $request->email;
        $id['id'] = $request->user_id;

        $validate1 = DB::table('pegawai')->where($pegawai)->update($data);
        $validate2 = DB::table('users')->where($id)->update($user);


        if($request->file != null){
            if($this->simpan_dokumen($request->file, $id['id'],"profile")){ 
                return back()->with('success', "Success");
            }else {
                return back()->with('error', "Error");
            }
        }elseif($validate1 || $validate2){
            return back()->with('success', "Success");
        } else {
            return back()->with('error', "Error");
        }
            
    }

    public function simpan_dokumen($file, $id="", $sub_folder){      
        //move file
        $name1 = $file->getClientOriginalName();
        $tgl = date("YmdHis");
        $str = str_replace(" ", "_", $tgl."_".$name1);
        $filename = $id."_".$str;

        $file-> move(public_path("/dokumen/".$sub_folder."/".$id.'/'), $filename);

        $data['pegawai_id'] = $id;
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['nama'] = $name1;
        $data['path'] = "/dokumen/".$sub_folder."/".$id."/".$filename;


        $data_edit['pegawai_id'] = $id;
        $data_edit['updated_at'] = date('Y-m-d H:i:s');
        $data_edit['nama'] = $name1;
        $data_edit['path'] = "/dokumen/".$sub_folder."/".$id."/".$filename;

        $ambil = DB::table("pegawai_lampiran")->where("pegawai_id", auth()->user()->id)->count();

        if($ambil >= 1){
            return DB::table("pegawai_lampiran")->where("pegawai_id", auth()->user()->id)->update($data_edit); 
        }
        if ($ambil == 0){
            return PegawaiLampiran::create($data); 
        }
        
    }

    public function pegawai_store(Request $request){

        $data['nik'] = $request->nik;
        $data['nama'] = $request->nama;
        $data['pegawai_jabatan_id'] = $request->jabatan;
        $data['pegawai_divisi_id'] = $request->divisi;
        
        $data['created_at'] = now();
        $data['updated_at'] = now();

        // $data['pegawai_lokasi_id'] = 1;
        if(isJakarta() == true){
            $data['pegawai_lokasi_id'] = $request->lokasi;
        }
        if(isJakarta() == false){
            $data['pegawai_lokasi_id'] = 2;
        }

        $user['password'] = bcrypt($request->password);
        $user['email'] = $request->email;
        $user['username'] = strtolower(str_replace(" ","_", $request->nama));


        if(Pegawai::pegawai_validasi($data)){
            $data['user_id'] = DB::table('users')->insertGetId($user);
            
            if(DB::table('pegawai')->insert($data)){
                    for($i=1; $i <= count(DB::table("modul")->get()); $i++){
                        if ($data['pegawai_lokasi_id'] == "1"){
                            DB::table("pegawai_hak_akses")->insert(["user_id" => $data['user_id'] , "modul_id"=> $i, "pegawai_level_user_id" => "4"]); 
                        }
                        if($data['pegawai_lokasi_id'] == "2"){
                            DB::table("pegawai_hak_akses")->insert(["user_id" => $data['user_id'] , "modul_id"=> $i, "pegawai_level_user_id" => "5"]); 
                        }
                        }
                
                // if (Pegawai::where("user_id", auth()->user()->id)->get()[0]->pegawai_lokasi_id == "2") {
                //     DB::table("pegawai_hak_akses")->insert(["user_id" => $data['user_id'] , "modul_id"=> $i, "pegawai_level_user_id" => 4]);  
                // }
                
                return back()->with('success', "Data berhasil di input");
            }else{
                DB::table('users')->where("id", "=", $data['user_id'])->delete();
                return back()->with('error', "Data ".$data['nik']." Sudah tersedia");
            }
        }else{
            return back()->with('error', "Data ".$data['nik']." Sudah tersedia");
        }
    }






    public function jabatan_put(Request $request){
        $id['id'] = $request->id;
        $data['nama'] = $request->nama;
        $data['keterangan'] = $request->keterangan;
        $data['updated_at'] = now();
        
       
        if(DB::table('pegawai_jabatan')->where("id", $request->id)->update($data)){
            return redirect('/jabatan')->with('success', "Data berhasil dirubah");
        }else{
            return redirect('/jabatan')->with('error', "Data gagal dirubah");
        }
    }

    public function jabatan_store(Request $request){

        $save['nama'] = $request->nama;
        $save['keterangan'] = $request->keterangan;
        $save['created_at'] = now();
        $save['updated_at'] = now();

        if(Pegawai::jabatan_validasi($save)){
            DB::table('pegawai_jabatan')->insert($save);
            return redirect('/jabatan')->with('success', "Data berhasil di input");
        }else{
            return redirect('/jabatan')->with('error', "Data ".$save['nama']." Sudah tersedia");
        }
    }







    public function divisi_put(Request $request){
        $id['id'] = $request->id;
        $data['nama'] = $request->nama;
        $data['keterangan'] = $request->keterangan;
        $data['updated_at'] = now();

        
        
        if(DB::table('pegawai_divisi')->where("id", $request->id)->update($data)){
            return redirect('/divisi')->with('success', "Data berhasil dirubah");
        }else{
            return redirect('/divisi')->with('error', "Data gagal dirubah");
        }
    }

    public function divisi_store(Request $request){

        $save['nama'] = $request->nama;
        $save['keterangan'] = $request->keterangan;
        $save['created_at'] = now();
        $save['updated_at'] = now();

        
        if(Pegawai::divisi_validasi($save)){
            DB::table('pegawai_divisi')->insert($save);
            return redirect('/divisi')->with('success', "Data berhasil di input");
        }else{
            return redirect('/divisi')->with('error', "Data ".$save['nama']." Sudah tersedia");
        }
    }

    public function detail(Request $request){
        
        $lokasi = $request->lokasi;

        if($lokasi == "jakarta"){
            $data_detail = Pegawai::get_detail($request->nik);
        }

        if($lokasi == "cilacap"){
            $data_detail = Pegawai::get_detail_cilacap($request->nik);
        }

        $a = DB::table("pegawai")->join("pegawai_lampiran", "pegawai.user_id", "=", "pegawai_lampiran.pegawai_id")
                                ->select("pegawai.user_id","pegawai_lampiran.path")
                                ->where("pegawai_id", auth()->user()->id)
                                ->count();
        
        if($a == true){
            return view("pegawai.detail",[
                "title" => "Detail",
                'divisi' => Pegawai::get_divisi(),
                'pegawai' => $data_detail,
                'jabatan' => Pegawai::get_jabatan(),
                'lokasi' => Pegawai::get_lokasi(),
                'dokumen_foto' => DB::table("pegawai_lampiran")->where("pegawai_id", auth()->user()->id)->get()[0]->path,
            ]);
        } else{
            return view("pegawai.detail",[
                "title" => "Detail",
                'divisi' => Pegawai::get_divisi(),
                'pegawai' => $data_detail,
                'jabatan' => Pegawai::get_jabatan(),
                'lokasi' => Pegawai::get_lokasi(),
                'dokumen_foto' => "/img/user_image.png",
            ]);
        }
    }

    public function hak_akses_put2(Request $request){
        $id['id'] = $request->id;
        $data['pegawai_level_user_id'] = $request->pegawai_level_user_id;

        DB::table("pegawai_hak_akses")->where($id)->update($data);
        return back()->with('success', "Data berhasil di input");
    }


    public function hak_akses_put(Request $request){
        $data['user_id'] = $request->user_id;
        $data['modul_id'] = $request->modul_id;
        $data['pegawai_level_user_id'] = $request->level_id;
        $data['created_at'] = now();
        $data['updated_at'] = now();

        $validate = DB::table('pegawai_hak_akses')
                ->where("user_id", $request->user_id)
                ->where("modul_id", $request->modul_id)->get()->count();

        if($validate == 0 ){
            DB::table('pegawai_hak_akses')
            ->where("user_id", $request->user_id)
            ->where("modul_id", $request->modul_id)->insertOrIgnore($data);
            return back()->with('success', "Data berhasil di input");
        }else{
            return back()->with('error', "Hak Akses Sudah Tersedia, silahkan rubah data yang sudah ada");
        }
    }

    public function hak_akses(Request $request){
        $parameter = $request->param;

        if($parameter == "administrator"){
            $data_hak_akses = Pegawai::hak_akses_cari_administrator($request->cari);
        }

        if($parameter == "hrd"){
            $data_hak_akses = Pegawai::hak_akses_cari_hrd($request->cari);
        }

        if($parameter == "approver"){
            $data_hak_akses = Pegawai::hak_akses_cari_approver($request->cari);
        }

        if($parameter == "user_jakarta"){
            $data_hak_akses = Pegawai::hak_akses_cari_userJ($request->cari);
        }

        if($parameter == "user_cilacap"){
            $data_hak_akses = Pegawai::hak_akses_cari_userC($request->cari);
        }

        // dd($data_hak_akses);
        isCilacap();
        $this->cek_akses(auth()->user()->id);

        if($request->cari){
            $data_level = Pegawai::hak_akses_cari($request->cari);
        }
        $data_level = Pegawai::hak_akses_cari("");
            // $data_level = Pegawai::hak_akses();

        return view("pegawai.hak_akses",[
            'title'   => "Manageman Hak Akses",
            'hak_akses' => $data_hak_akses,
            'pegawai' => Pegawai::get(),
            'modul' => Pegawai::get_modul(),
            'level' => Pegawai::get_level(),
        ]);
    }


    public function jabatan(Request $request){
        $this->cek_akses(auth()->user()->id);
        return view("pegawai.jabatan",[
            'title'   => "Manageman Jabatan",
            'jabatan' => Pegawai::get_jabatan_cari($request->cari),
        ]);
    }

    public function divisi(Request $request){
        $this->cek_akses(auth()->user()->id);
        return view("pegawai.divisi",[
            'title'   => "Manageman Divisi",
            'divisi' => Pegawai::get_divisi_cari($request->cari),
        ]);
    }

    public function index(Request $request){
        $lokasi = $request->lokasi;
        $this->cek_akses(auth()->user()->id);

        if ($lokasi == "jakarta" ){
            $data_pegawai = Pegawai::get_pegawai_cari($request->cari);
        }

        if ($lokasi == "cilacap" ){
            $data_pegawai = Pegawai::get_pegawai_cari_cilacap($request->cari);
        }        

        return view('pegawai.index', 
            [   'title' => "Pegawai",
                'divisi' => Pegawai::get_divisi(),
                'jabatan' => Pegawai::get_jabatan(),
                'lokasi' => Pegawai::get_lokasi(),
                'pegawai' =>  $data_pegawai,
        ]);
    }

    public function cek_akses($user_id){
        $tmp = DB::table("pegawai_hak_akses")->where("modul_id", 1)->where("user_id", $user_id)->get();
        $akses = 0;
        if(count($tmp) > 0 ){
            $akses = $tmp[0]->pegawai_level_user_id;
        }
        switch ($akses) {
            case '1': return "Administrator"; break;
            case '2': return "Administrator HRD"; break;
            case '3': return abort(403); break;
            case '4': return abort(403); break;
            default: return abort(403); break;
        }
    }
}
