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
        // $id = Reminder::get_reminder_id();
        // $id = DB::table("r_reminder_data")->get(["id"]);
        $nama = Reminder::get(['nama']);
        // dd($id);
        return $this->subject("Reminder")
                    ->markdown("emails.reminder");
    }
}
