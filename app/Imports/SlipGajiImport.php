<?php

namespace App\Imports;

use App\Models\Pengumuman\PSlipGaji;
use App\Models\Pengumuman\PSlipGajiDetail;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SlipGajiImport implements ToModel, WithHeadingRow
{
    
    public function model(array $row)
    {
        $id = PSlipGaji::where("status", "Belum Diumumkan")->orderBy("id", "desc")->limit("1")->get()[0]->id;
        
        return new PSlipGajiDetail([
            //database => //slug row in exel

            'nik' => $row['nik'],
            'p_slip_gaji_id' => $id,
            'i_gaji_dasar' => $row['gaji_dasar'],
            'i_tunjangan' => $row['tunjangan'],
            'i_tunjangan_jabatan' => $row['tunjangan_jabatan'],
            'i_tunjangan_komunikasi' => $row['tunjangan_komunikasi'],
            'i_tunjangan_pensiun' => $row['tunjangan_pensiun'],
            'i_tunjangan_cuti' => $row['tunjangan_cuti'],
            'i_lembur' => $row['lembur'],
            'i_hari_raya' => $row['hari_raya'],
            'i_work_anniversary' => $row['work_anniversary'],
            'i_jasa_kerja' => $row['jasa_kerja'],
            'i_rapel' => $row['rapel'],
            'i_lain_1' => $row['pendapatan_lain_1'],
            'i_lain_2' => $row['pendapatan_lain_2'],
            'i_lain_3' => $row['pendapatan_lain_3'],
            'o_bpjs_tenaga_kerja' => $row['bpjs_tenaga_kerja'],
            'o_bpjs_kesehatan' => $row['bpjs_kesehatan'],
            'o_bpjs_dana_pensiun' => $row['bpjs_dana_pensiun'],
            'o_komunikasi' => $row['komunikasi'],
            'o_lain_1' => $row['potongan_lain_1'],
            'o_lain_2' => $row['potongan_lain_2'],
            'o_lain_3' => $row['potongan_lain_3'],
        ]);
    }
}
