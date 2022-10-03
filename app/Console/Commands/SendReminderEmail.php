<?php

namespace App\Console\Commands;

use App\Mail\ReminderEmail;
use App\Models\Reminder\Reminder;
use Illuminate\Console\Command;
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
        $reminders = Reminder::get_data();
            
        // //data user
        // $data = [];
        // foreach ($reminders as $r) {
        //     $data[$r->user_id]; 
        // }
        // dd($reminders);
            $this->sendEmail($reminders);
    }

    private function sendEmail($reminders){
        $email = Reminder::get_email();
        Mail::to($email)->send(new ReminderEmail($reminders));
    }
}