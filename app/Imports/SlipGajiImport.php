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
            'i_gaji_dasar'              => enkipsi_decript($row['gaji_dasar'], "en"),
            'i_tunjangan'               => enkipsi_decript($row['tunjangan'], "en"),
            'i_tunjangan_jabatan'       => enkipsi_decript($row['tunjangan_jabatan'], "en"),
            'i_tunjangan_komunikasi'    => enkipsi_decript($row['tunjangan_komunikasi'], "en"),
            'i_tunjangan_pensiun'       => enkipsi_decript($row['tunjangan_pensiun'], "en"),
            'i_tunjangan_cuti'          => enkipsi_decript($row['tunjangan_cuti'], "en"),
            'i_lembur'                  => enkipsi_decript($row['lembur'], "en"),
            'i_hari_raya'               => enkipsi_decript($row['hari_raya'], "en"),
            'i_work_anniversary'        => enkipsi_decript($row['work_anniversary'], "en"),
            'i_jasa_kerja'              => enkipsi_decript($row['jasa_kerja'], "en"),
            'i_rapel'                   => enkipsi_decript($row['rapel'], "en"),
            'i_lain_1'                  => enkipsi_decript($row['pendapatan_lain_1'], "en"),
            'i_lain_2'                  => enkipsi_decript($row['pendapatan_lain_2'], "en"),
            'i_lain_3'                  => enkipsi_decript($row['pendapatan_lain_3'], "en"),
            'o_bpjs_tenaga_kerja'       => enkipsi_decript($row['bpjs_tenaga_kerja'], "en"),
            'o_bpjs_kesehatan'          => enkipsi_decript($row['bpjs_kesehatan'], "en"),
            'o_dana_pensiun'            => enkipsi_decript($row['dana_pensiun'], "en"),
            'o_komunikasi'              => enkipsi_decript($row['komunikasi'], "en"),
            'o_lain_1'                  => enkipsi_decript($row['potongan_lain_1'], "en"),
            'o_lain_2'                  => enkipsi_decript($row['potongan_lain_2'], "en"),
            'o_lain_3'                  => enkipsi_decript($row['potongan_lain_3'], "en"),
            't_pendapatan'              => enkipsi_decript($row['total_pendapatan'], "en"),
            't_pendapatan_lain'         => enkipsi_decript($row['total_pendapatan_lain'], "en"),
            't_potongan'                => enkipsi_decript($row['total_potongan'], "en"),
            't_takehome'                => enkipsi_decript($row['total_takehome'], "en"),
        ]);
    }
}
