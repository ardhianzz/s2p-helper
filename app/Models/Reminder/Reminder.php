<?php

namespace App\Models\Reminder;

use App\Models\Pegawai\Pegawai;
use App\Models\Pegawai\PegawaiDivisi;
use App\Models\User;
use DateTime;
use DateTimeZone;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Worksheet\AutoFilter\Column;
use Psy\CodeCleaner\FunctionReturnInWriteContextPass;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Reminder extends Model
{
    use HasFactory;
    protected $table = 'r_reminder_data';
    protected $guarded = ['id'];

    public function pegawai_divisi(){
        return $this->belongsTo(PegawaiDivisi::class);
    }
    
    public function pegawai(){
        return $this->belongsTo(Pegawai::class);
    }

    static function get_tanggal(){
        $today = new DateTime('now', new DateTimeZone('Asia/Kolkata'));
        $time = $today->format('Y-m-d');
        return DB::table("r_reminder_data")->where("tanggal_pengingat",$time)->get();
        // return DB::table("r_reminder_data")->where("tanggal_expired", now()->today('Y-m-d'))->get()[0];
    }

    static function get_data(){
        // return DB::table("r_reminder_data")->orderBy("user_id")->get();
        return DB::table("r_reminder_data")->get();
    }

    static function get_reminder_id(){
        $id = DB::table("r_reminder_data")->get(['id']);
        return DB::table("r_reminder_data")->where("id", $id)->get()[0];
    }

    static function get_reminder_data(){
        $id['user_id'] = Auth::user()->id;

        return DB::table("r_reminder_data")->get();
    }
}
