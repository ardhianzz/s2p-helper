<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Modul_email extends Model
{
    use HasFactory;
    protected $table = 'modul_email';
    protected $guarded = ['id'];
}
