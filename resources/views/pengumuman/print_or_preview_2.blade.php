<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Print Slip Gaji</title>
</head>
<style>
    *{
        font-family: 'Segoe UI', Tahoma, sans-serif;
        font-size: 13px;
    }
    .row{
        display: flex;
        padding: 15px;
        width: 100%;}
    .border{
        border-style: solid;
        border-width: .5px;
        padding: 10px;
    }
    hr{
        width: 100%
    }

    .footer{
        width: 100%;
        height: 10px;
        background-color: rgb(4, 30, 146);
    }

</style>
<body>
{{-- Header --}}
<div class="border">
    <table width="100%">
        <tr align="center">
            <td width="20%">
                <img src="/img/logo.jpg" alt="Logo S2P" width="80px">
            </td>
            <td width="80%">
                <p>
                    <span style="font-size: 20px"> PT SUMBER SEGARA PRIMADAYA</span> <br>
                    <strong>LAPORAN PEMBAYARAN PENDAPATAN</strong> <br>
                    <i>(PAYROLL SLIP)</i> <br>
                    Bulan : {{ date("M Y") }}
                    
                </p>
            </td>
        </tr>
    </table>
    <hr>
    <table width="100%">
        <tr>
            <td>NAMA</td>
            <td>:</td>
            <td>{{ $pegawai->nama }}</td>
            <td width="20%">&nbsp;</td>
        </tr>

        <tr>
            <td>NPK</td>
            <td>:</td>
            <td>{{ $pegawai->nik }}</td>
            <td>&nbsp;</td>
        </tr>

        <tr>
            <td>JABATAN</td>
            <td>:</td>
            <td>{{ $pegawai->pegawai_jabatan->nama }}</td>
            <td>&nbsp;</td>
        </tr>

        <tr>
            <td>LEVEL</td>
            <td>:</td>
            <td>{{ $pegawai->pegawai_level->nama }}</td>
            <td>LOKASI : {{ $pegawai->pegawai_lokasi->nama }}</td>
        </tr>
    </table>

    <hr>

    <table width="100%">
        <tr>
            <td width="50%">
                <span style="color: darkblue"><i>PENDAPATAN</i></span>
                <table width="100%">
                    <tr>
                        <td>Gaji Dasar</td>
                        <td>: {{ rupiah($data[0]->i_gaji_dasar) }}</td>
                    </tr>

                    <tr>
                        <td>Tunjangan</td>
                        <td>: {{ rupiah($data[0]->i_tunjangan) }}</td>
                    </tr>

                    <tr>
                        <td>Tunjagnan Jabatan</td>
                        <td>: {{ rupiah($data[0]->i_tunjangan_jabatan) }}</td>
                    </tr>

                    <tr>
                        <td>Tunjangan Komunikasi</td>
                        <td>: {{ rupiah($data[0]->i_tunjangan_komunikasi) }}</td>
                    </tr>
                    
                    <tr>
                        <td>Tunjangan Pensiun</td>
                        <td>: {{ rupiah($data[0]->i_tunjangan_pensiun) }}</td>
                    </tr>

                    <tr>
                        <td>Lembur</td>
                        <td>: {{ rupiah($data[0]->i_lembur) }}</td>
                    </tr>
                </table>
            
            </td>

            <td width="50%" style="vertical-align: top">
                <span style="color: brown"><i>POTONGAN</i></span>
                <table width="100%">
                    <tr>
                        <td>BPJS Tenaga Kerja</td>
                        <td>: {{ rupiah($data[0]->o_bpjs_tenaga_kerja) }}</td>
                    </tr>

                    <tr>
                        <td>BPJS Kesehatan</td>
                        <td>: {{ rupiah($data[0]->o_bpjs_kesehatan) }}</td>
                    </tr>
                    <tr>
                        <td>Dana Pensiun</td>
                        <td>: {{ rupiah($data[0]->o_dana_pensiun) }}</td>
                    </tr>

                    <tr>
                        <td>Potongan Komunikasi</td>
                        <td>: {{ rupiah($data[0]->o_komunikasi) }}</td>
                    </tr>

                    <tr>
                        <td>Potongan Lain-Lain</td>
                        <td>: {{ rupiah($data[0]->o_lain_1) }}</td>
                    </tr>

                </table>


            </td>
        </tr>

        <tr>
            <td>
                <table width="100%">
                    <tr>
                        <td><strong style="color: darkblue"><i>TOTAL PENDAPATAN</i></strong></td>
                        <td style="border-top : solid 0.5px">: 
                            <i style="color: darkblue">
                                <strong>
                                    {{-- <span hidden>
                                        {{ $t_pendapatan = $data[0]->i_gaji_dasar+$data[0]->i_tunjangan+$data[0]->i_tunjangan_jabatan+$data[0]->i_tunjangan_komunikasi+$data[0]->i_tunjangan_pensiun+$data[0]->i_lembur }}
                                    </span> --}}
                                    {{-- {{ dd($data) }} --}}
                                    {{ rupiah($data[0]->t_pendapatan) }}
                                </strong>
                            </i>
                        </td>
                    </tr>
                </table>
            </td>
            <td>
                <table width="100%">
                    <tr>
                        
                        <td><strong><span style="color: brown"><i>TOTAL POTONGAN</i></span></strong></td>
                        <td style="border-top : solid 0.5px">: <i style="color: brown"> <strong>
                            {{-- <span hidden>
                                {{ $t_potongan = $data[0]->o_bpjs_tenaga_kerja+$data[0]->o_bpjs_kesehatan+$data[0]->o_dana_pensiun+$data[0]->o_komunikasi+$data[0]->o_lain_1 }}
                            </span> --}}
                            {{ rupiah($data[0]->t_potongan) }}
                        </strong></i></td>
                    </tr>
                </table>
            </td>
        </tr>


        <tr>
            <td>&nbsp;</td>
            <td>
                <br>
                <table width="100%">
                    <tr>
                        <td>
                            <strong>TAKE HOME PAY</strong>
                        </td>
                        <td style="border-bottom: double; border-top: double; background-color: rgb(243, 207, 130)">
                            <strong>: {{ rupiah($data[0]->t_takehome) }}
                            </strong>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>


        <tr>
            <td>
                <br>
                <table width="100%">
                    <tr>
                        <td>Lain-Lain: </td>
                        <td>&nbsp;</td>
                    </tr>

                    <tr>
                        <td>Tunjangan Hari Raya</td>
                        <td>: {{ rupiah($data[0]->i_hari_raya) }}</td>
                    </tr>

                    <tr>
                        <td>Tunjangan Cuti</td>
                        <td>: {{ rupiah($data[0]->i_tunjangan_cuti) }}</td>
                    </tr>

                    <tr>
                        <td>Tunj. Work Anniversary</td>
                        <td>: {{ rupiah($data[0]->i_work_anniversary) }}</td>
                    </tr>

                    <tr>
                        <td>Jasa Kerja {{ date("Y")-1 }}</td>
                        <td>: {{ rupiah($data[0]->i_jasa_kerja) }}</td>
                    </tr>

                    <tr>
                        <td>Rapel {{ date("Y") }}</td>
                        <td>: {{ rupiah($data[0]->i_rapel) }}</td>
                    </tr>

                    <tr>
                        <td><strong><i>PENDAPATAN LAIN</i></strong></td>
                        <td style="border-top : solid 0.5px">: <strong> <i>
                            {{-- <span hidden>
                                {{ $t_pendapatan_lain = $data[0]->i_work_anniversary+$data[0]->i_hari_raya+$data[0]->i_jasa_kerja+$data[0]->i_rapel+$data[0]->i_tunjangan_cuti}}
                            </span> --}}
                            {{ rupiah($data[0]->t_pendapatan_lain) }}
                        </i></strong></td>
                    </tr>
                </table>
            </td>

            <td style="vertical-align: middle">
                
                <table width="100%">
                    <tr>
                        <td><strong><i>MODE TRANSFER</i></strong></td>
                        <td>&nbsp;</td>
                    </tr>
                    
                    @if($no_rekening != null)
                    <tr>
                        <td>TANGGAL TRANSFER</td>
                        <td>: {{ $data[0]->tanggal }}</td>
                    </tr>

                    <tr>
                        <td>BANK</td>
                        <td>: {{ $no_rekening[0]->nama_bank }}</td>
                    </tr>

                    <tr>
                        <td>NO. REK</td>
                        <td>: {{ $no_rekening[0]->nomor_rekening }}</td>
                    </tr>

                    <tr>
                        <td>A/N</td>
                        <td>: {{ $no_rekening[0]->nama_akun }}</td>
                    </tr>

                    @endif
                    <tr>
                        <td>JUMLAH</td>
                        <td>: <b>{{ rupiah(($data[0]->t_pendapatan + $data[0]->t_pendapatan_lain) - $data[0]->t_potongan) }}</b>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>
<br>
<br>
<br>
    <div class="footer"></div>
    <span><i>Slip Elektronik - Sah Tanpa Tandatangan</i></span>
</div>
</body>
</html>