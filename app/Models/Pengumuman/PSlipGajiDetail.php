<?php

namespace App\Models\Pengumuman;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PSlipGajiDetail extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $table = 'p_slip_gaji_detail';

    public function p_slip_gaji(){
        return $this->belongsTo(PSlipGaji::class);
    }

    
}
