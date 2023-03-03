<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Modul_tema extends Model
{
    use HasFactory;
    protected $table = 'modul_tema';
    protected $guarded = ['id'];
}
