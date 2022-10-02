<?php

namespace App\Models\Pengumuman;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PPengumumanDokumen extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $table = 'p_pengumuman_dokumen';

    public function p_pengumuman(){
        return $this->belongsTo(PPengumuman::class);
    }

    
}
