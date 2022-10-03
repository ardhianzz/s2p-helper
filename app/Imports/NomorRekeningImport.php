<?php

namespace App\Imports;

use App\Models\Pegawai\PegawaiNomorRekening;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class NomorRekeningImport implements ToModel, WithHeadingRow
{
    
    public function model(array $row)
    {
        return new PegawaiNomorRekening([
            //database => //slug row in exel
            'user_id' => $row["user_id"],
            'nama_bank' => $row["nama_bank"],
            'nama_akun' => $row["nama_akun"],
            'nomor_rekening' => $row["nomor_rekening"],
            
        ]);
    }
}
