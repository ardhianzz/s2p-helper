<?php

namespace App\Imports;

use App\Models\Absensi;
use App\Models\Pegawai\Pegawai;
use App\Models\Reminder\Reminder;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ReminderImport implements ToModel, WithHeadingRow
{
    
    public function model(array $row)
    {
        return new Reminder([
            'user_id'           => auth()->user()->id,
            'pegawai_divisi_id' => Pegawai::where('user_id', auth()->user()->id)->get()[0]->pegawai_divisi_id,
            'jenis'             => $row["type"],
            'nama'              => $row["subject"],
            'from'              => date("Y-m-d", (($row["validity_from_date"]-25569)*86400)),
            'to'                => date("Y-m-d", (($row["validity_to_date"]-25569)*86400)),
            'tanggal_expired'   => date("Y-m-d", (($row["expired_date"]-25569)*86400)),
            'tanggal_pengingat' => date("Y-m-d", (($row["reminder_date"]-25569)*86400)),
            'email'             => $row["email"],
            'email_2'             => $row["email_2"],
            'email_3'             => $row["email_3"],
            'keterangan'        => $row["description"],
            'created_at'        => now(),
            'updated_at'        => now(),
        ]);
    }
}
