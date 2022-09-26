<?php

namespace App\Models\Pengumuman;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PPengumuman extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $table = 'p_pengumuman';

    
}
