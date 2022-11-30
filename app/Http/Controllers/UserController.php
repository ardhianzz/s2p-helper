<?php

namespace App\Http\Controllers;

use App\Mail\notif_reset_password;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Pegawai\Pegawai;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{

    public function profile_pegawai($id){
        
        $id_login = auth()->user()->id;
        
        if($id_login != $id){
            return abort(403);
        }

        return view("pegawai.profile",[
            "title" => "Profile",
            'divisi' => Pegawai::get_divisi(),
            'pegawai' => Pegawai::get_profile($id),
            'jabatan' => Pegawai::get_jabatan(),
            'lokasi' => Pegawai::get_lokasi(),
        ]);
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

    public function pegawai_put(Request $request){

        $lokasi = Pegawai::where("user_id", auth()->user()->id)->get()[0]->pegawai_lokasi_id;
        $pegawai['id'] = $request->id;
        $data['nik'] = $request->nik;
        $data['nama'] = $request->nama;
        $data['pegawai_jabatan_id'] = $request->pegawai_jabatan_id;
        $data['pegawai_divisi_id'] = $request->pegawai_divisi_id;

        if ($lokasi == 1){
            $data['pegawai_lokasi_id'] = "1";
        }
        if ($lokasi == 2){
            $data['pegawai_lokasi_id'] = "2";
        }
        //$data['email'] = $request->email;

        $user['email'] = $request->email;
        $id['id'] = $request->user_id;

        $validate1 = DB::table('pegawai')->where($pegawai)->update($data);
        $validate2 = DB::table('users')->where($id)->update($user);

        if($validate1 || $validate2){
            return back()->with('success', "Data berhasil dirubah");
        }else{
            return back()->with('error', "Data gagal dirubah");
        }
    }

    public function pegawai_store(Request $request){

        $data['nik'] = $request->nik;
        $data['nama'] = $request->nama;
        $data['pegawai_jabatan_id'] = $request->jabatan;
        $data['pegawai_divisi_id'] = $request->divisi;
        
        $data['created_at'] = now();
        $data['updated_at'] = now();

        $data['pegawai_lokasi_id'] = 1;
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
                if ($data['pegawai_lokasi_id'] = 1)
                    {
                    DB::table("pegawai_hak_akses")->insert(["user_id" => $data['user_id'] , "modul_id"=> $i, "pegawai_level_user_id" => 4]);
                    }
                if ($data['pegawai_lokasi_id'] = 1)
                    {
                    DB::table("pegawai_hak_akses")->insert(["user_id" => $data['user_id'] , "modul_id"=> $i, "pegawai_level_user_id" => 5]);  
                    }
                
                }
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

    public function detail($nik, Request $request){
        
        $lokasi = $request->lokasi;

        if($lokasi == "jakarta"){
            $data_detail = Pegawai::get_detail($request->nik);
        }

        if($lokasi == "cilacap"){
            $data_detail = Pegawai::get_detail_cilacap($request->nik);
        }
        
        return view("pegawai.detail",[
            "title" => "Detail",
            'divisi' => Pegawai::get_divisi(),
            'pegawai' => $data_detail,
            'jabatan' => Pegawai::get_jabatan(),
            'lokasi' => Pegawai::get_lokasi(),
        ]);
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


    public function jabatan(){
        $this->cek_akses(auth()->user()->id);
        return view("pegawai.jabatan",[
            'title'   => "Manageman Jabatan",
            'jabatan' => Pegawai::get_jabatan(),
        ]);
    }

    public function divisi(){
        $this->cek_akses(auth()->user()->id);
        return view("pegawai.divisi",[
            'title'   => "Manageman Divisi",
            'divisi' => Pegawai::get_divisi(),
        ]);
    }


    // public function indexCilacap(Request $request){
    //     $this->cek_akses(auth()->user()->id);
        

    //     return view('pegawai.indexCilacap', 
    //         [   'title' => "Pegawai",
    //             'divisi' => Pegawai::get_divisi(),
    //             'jabatan' => Pegawai::get_jabatan(),
    //             'lokasi' => Pegawai::get_lokasi(),
    //             'pegawai' =>  Pegawai::get_pegawai_cari_cilacap($request->cari),
    //     ]);
    // }

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
