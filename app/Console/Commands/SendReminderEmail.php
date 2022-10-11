<?php

namespace App\Console\Commands;

use App\Mail\ReminderEmail;
use App\Models\Reminder\Reminder;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class SendReminderEmail extends Command
{  

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reminder:emails';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Pengiriman notifikasi reminder via email  ';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        //ambil data reminder
       

        $jumlah = Reminder::where("tanggal_pengingat", date("m-d"))->count();

        for($i=0; $i<$jumlah; $i++){
            $id = Reminder::where("tanggal_pengingat", date("m-d"))->get()[$i]->id;
            $untuk = Reminder::where("tanggal_pengingat", date("m-d"))->get()[$i]->email;   
            $this->sendEmail(Reminder::where("id",$id)->get(), $untuk);
            dd($untuk);
        }
    }

    private function sendEmail($reminders, $untuk){
        // Mail::to($untuk)->send(new ReminderEmail($reminders));
    }
}