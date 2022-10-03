<?php

namespace App\Models\Pengumuman;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PSlipGaji extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $table = 'p_slip_gaji';

    public function p_slip_gaji_detail(){
        return $this->hasMany(PSlipGajiDetail::class);
    }

    
}
