<?php

namespace App\Http\Controllers;

use App\Http\Middleware\Pegawai;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\notif_login;

class LoginController extends Controller
{


    public function autenticate(Request $request){
        $data = [
            "email" => $request->email,
            "password" => $request->password,
        ];

        if(Auth::attempt($data)){
            //single login 
            Auth::logoutOtherDevices(request()->password);

            $data_ip = DB::table("users")->where("id", auth()->user()->id)->get()[0]->last_login_ip;
            $data_waktu = DB::table("users")->where("id", auth()->user()->id)->get()[0]->last_login_at;
            $check = geoip()->getLocation(trim(shell_exec("curl https://ifconfig.co")));
            $agent = request()->header('user-agent');
            $request->session()->regenerate();
            $details = [
                'title' => 'Notifikasi Keamanan',
                'ip_local' => $data_ip,
                'waktu' => $data_waktu,
                'ip_public' => $check,
                'user_agent' => $agent,
                ];
            
            
            Mail::to($request->email)->send(new notif_login($details));
            

            //insert aktifitas login
            $s['user_id'] = Auth::user()->id;  
            $s['ip_address'] = $data_ip;
            $s['user_agent'] = $agent;
            $s['last_activity'] = $data_waktu;
            $s['ip_public'] = $check->ip;
            $s['lokasi'] = $check->city;
            DB::table("sessions")->insert($s);
                
            return redirect()->intended("/main");
        }
        return back()->with("LoginError", "Login Failed");
    }


    public function logout(Request $request)
    {   
        $request->session()->flush();
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
