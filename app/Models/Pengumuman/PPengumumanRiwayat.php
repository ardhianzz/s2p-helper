<?php

namespace App\Models\Pengumuman;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PPengumumanRiwayat extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $table = 'p_pengumuman_riwayat';

    public function p_pengumuman(){
        return $this->belongsTo(PPengumuman::class);
    }

    
}
