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
            'user_id' => Auth::user()->id,
            'pegawai_divisi_id' => Pegawai::where('user_id', auth()->user()->id)->get()[0]->pegawai_divisi_id,
            'jenis' => $row["type"],
            'nama' => $row["subject"],
            'from' => date("Y-m-d", (($row["dari"]-25569)*86400)),
            'to' => date("Y-m-d", (($row["sampai"]-25569)*86400)),
            'tanggal_expired' => date("Y-m-d", (($row["expired"]-25569)*86400)),
            'tanggal_pengingat' => date("Y-m-d", (($row["pengingat"]-25569)*86400)),
            'email' => $row["email"],
            'keterangan' => $row["deskripsi"],
            'created_at' => now(),
            'updated_at' => now(),
            // 'tanggal' => date("Y-m-d", (($row["date"]-25569)*86400)),
            // 'jam_masuk' => date("H:i:s", (($row["check_in"]-25569)*86400)),
            // 'jam_pulang' => date("H:i:s", (($row["check_out"]-25569)*86400)),
        ]);
    }
}
