<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LemburCatatan extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $table = 'lembur_catatan';

    public function lembur_absensi(){
        return $this->belongsTo(Absensi::class);
    }
}
 