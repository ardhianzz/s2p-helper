<?php

namespace App\Mail;

use App\Models\Pengumuman\PPengumuman as PengumumanPPengumuman;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Http\Request;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use PPengumuman;

class send_pengumuman extends Mailable
{
    use Queueable, SerializesModels;

    public $pengumuman;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($pengumuman)
    {
        $this->pengumuman = $pengumuman;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(Request $request)
    {
        $isi = DB::table('p_pengumuman')->leftJoin("p_pengumuman_dokumen", "p_pengumuman.id", "=", "p_pengumuman_dokumen.p_pengumuman_id")
                                        ->select("p_pengumuman.id", "p_pengumuman.nama", "p_pengumuman.keterangan", "p_pengumuman_dokumen.path")
                                        ->where("p_pengumuman.id", $request->publish_pengumuman)
                                        ->get()[0]->path;

        $subject = DB::table('p_pengumuman')->leftJoin("p_pengumuman_dokumen", "p_pengumuman.id", "=", "p_pengumuman_dokumen.p_pengumuman_id")
                                        ->select("p_pengumuman.id", "p_pengumuman.nama", "p_pengumuman.keterangan", "p_pengumuman_dokumen.path")
                                        ->where("p_pengumuman.id", $request->publish_pengumuman)
                                        ->get()[0]->nama;
        if ($isi == null){
            return $this->subject($subject)
                        ->view('emails.send_pengumuman');
        } 
        else if ($isi != null ){
            $id = DB::table("p_pengumuman")->where("id", $request->publish_pengumuman)->get()[0]->id;
            $name1 = DB::table("p_pengumuman_dokumen")->where("p_pengumuman_id", $id)->get()[0]->path;
            $path = public_path($name1);

            return $this->subject($subject)
                        ->view('emails.send_pengumuman_att')
                        ->attach($path);
        }
    }
}