<?php

namespace App\Mail;

use App\Http\Middleware\Pegawai;
use App\Models\Pegawai\PegawaiDivisi;
use App\Models\Reminder\Reminder;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class ReminderEmail extends Mailable implements ShouldQueue
{
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
        $reminders = $this->reminders;
        foreach ($reminders as $r)
        if ($r->jenis == "Birthday"){
            return $this->subject($r->nama)
            ->view("emails.preview_email_birthday");
            // ->markdown("emails.reminder");
        } else {
            return $this->subject($r->nama)
            // ->view("emails.preview_email");
            ->view("emails.preview_email");
        }
    }
}
