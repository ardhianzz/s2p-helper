<?php

namespace App\Mail;


use App\Models\Reminder\Reminder;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class ReminderEmail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $reminders;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($reminders)
    {
        $this->reminders = $reminders;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $subject = DB::table("r_reminder_data")->where("tanggal_pengingat", date("Y-m-d"))->get()[0]->nama;   
        // dd($untuk);
        return $this->subject($subject)
                    // ->view("emails.preview_email");
                    ->markdown("emails.reminder");
    }
}
