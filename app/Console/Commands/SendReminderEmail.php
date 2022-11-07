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
       

        $jumlah = Reminder::where("tanggal_pengingat", date("Y-m-d"))->count();

        for($i=0; $i<$jumlah; $i++){
            $id = Reminder::where("tanggal_pengingat", date("Y-m-d"))->get()[$i]->id;
            $untuk = Reminder::where("tanggal_pengingat", date("Y-m-d"))->get()[$i]->email;   
            $untuk2 = Reminder::where("tanggal_pengingat", date("Y-m-d"))->get()[$i]->email_2;   
            $untuk3 = Reminder::where("tanggal_pengingat", date("Y-m-d"))->get()[$i]->email_3;   

            $this->sendEmail(Reminder::where("id",$id)->get(), $untuk, $untuk2, $untuk3);
            // $a = Reminder::where("tanggal_pengingat", date("Y-m-d"))->get()[0]->email == !null ||
            //      Reminder::where("tanggal_pengingat", date("Y-m-d"))->get()[0]->email_2 == null ||
            //      Reminder::where("tanggal_pengingat", date("Y-m-d"))->get()[0]->email_3 == null;   
            // $b = Reminder::where("tanggal_pengingat", date("Y-m-d"))->get()[0]->email == !null ||
            //      Reminder::where("tanggal_pengingat", date("Y-m-d"))->get()[0]->email_2 == !null ||
            //      Reminder::where("tanggal_pengingat", date("Y-m-d"))->get()[0]->email_3 == null;  
            // $c = Reminder::where("tanggal_pengingat", date("Y-m-d"))->get()[0]->email == !null ||
            //      Reminder::where("tanggal_pengingat", date("Y-m-d"))->get()[0]->email_2 == !null ||
            //      Reminder::where("tanggal_pengingat", date("Y-m-d"))->get()[0]->email_3 == !null;  
            // dd($a, $b, $c);
            // dd($untuk);
        }
    }

    private function sendEmail($reminders, $untuk, $untuk2, $untuk3){
        if (Reminder::where("tanggal_pengingat", date("Y-m-d"))->get()[0]->email == !null ||
            Reminder::where("tanggal_pengingat", date("Y-m-d"))->get()[0]->email_2 == null ||
            Reminder::where("tanggal_pengingat", date("Y-m-d"))->get()[0]->email_3 == null ) 
            {
            Mail::to($untuk)->send(new ReminderEmail($reminders));
            }
        if (Reminder::where("tanggal_pengingat", date("Y-m-d"))->get()[0]->email == !null ||
            Reminder::where("tanggal_pengingat", date("Y-m-d"))->get()[0]->email_2 == !null ||
            Reminder::where("tanggal_pengingat", date("Y-m-d"))->get()[0]->email_3 == null ) 
            {
            Mail::to($untuk2)->send(new ReminderEmail($reminders));
            }
        if (Reminder::where("tanggal_pengingat", date("Y-m-d"))->get()[0]->email == !null ||
            Reminder::where("tanggal_pengingat", date("Y-m-d"))->get()[0]->email_2 == !null ||
            Reminder::where("tanggal_pengingat", date("Y-m-d"))->get()[0]->email_3 == !null ) 
            {
            Mail::to($untuk3)->send(new ReminderEmail($reminders));
            }
        
    }
}