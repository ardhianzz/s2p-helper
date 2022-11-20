<?php

namespace App\Models\Sessions;

use App\Models\Pegawai\Pegawai;
use App\Models\Pegawai\PegawaiDivisi;
use App\Models\Pegawai\PegawaiNama;
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


class Sessions extends Model
{
    use HasFactory;
    protected $table = 'sessions';
    protected $guarded = ['id'];



   public function user(){
        return $this->belongsTo(User::class);
   }

   public function pegawai(){
    return $this->belongsTo(Pegawai::class);
   }
    
   static function get_sessions(){
//     $id['user_id'] = Auth::user()->id;

    return DB::table("sessions")->join("pegawai", "sessions.user_id", "=", "pegawai.user_id")
                                ->select("pegawai.nama", "sessions.ip_address", "sessions.user_agent", "sessions.payload", "sessions.last_activity", "sessions.ip_public", "sessions.lokasi")
                                ->orderBy("sessions.last_activity", "desc")->paginate(5);
   }
}
