<?php

namespace App\Models\Reminder;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Worksheet\AutoFilter\Column;
use Psy\CodeCleaner\FunctionReturnInWriteContextPass;

class Reminder extends Model
{
    use HasFactory;
    protected $table = 'r_reminder_data';
    protected $guarded = ['id'];

    static function get_email(){
        return DB::table("r_reminder_data")->get(['email']);
    }

    static function get_data(){
        // return DB::table("r_reminder_data")->orderBy("user_id")->get();
        return DB::table("r_reminder_data")->get();
    }

    static function get_reminder_id(){
        return DB::table("r_reminder_data")->get();
    }

    static function get_reminder_data(){
        $id['user_id'] = Auth::user()->id;

        return DB::table("r_reminder_data")->get();
    }
}
