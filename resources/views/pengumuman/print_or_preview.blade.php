<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-print-css/css/bootstrap-print.min.css" media="print">
    <title>{{ $subtitle }}</title>
  </head>
  <body>

    <ul class="nav justify-content-center bg-dark d-print-none" style="text-align: center;">
        <div class="col-md-2 mt-1 mb-1">
            <a href="{{ URL::previous() }}">
                <button class="btn btn-light">Kembali</button>
            </a>
        </div>
        <div class="col-md-2  mt-1 mb-1">
            <button class="btn btn-light"> Print </button>
        </div>
    </ul>

    <div class="container .d-print">
        
    <header>
        <div class="row">
            <div class="col-lg-2">
                <span>
                    <p align="center">
                        <img src="/img/logo.jpg" alt="Logo S2P" width="100px">
                    </p>
                </span>
            </div>
            <div class="col-lg-8">
                <p align="center">
                    <strong> PT SUMBER SEGARA PRIMADAYA    </strong> <br>
                    <strong> LAPORAN PEMBAYARAN PENDAPATAN </strong><br>
                    <i>(PAYROLL SLIP)</i> <br>
                    BULAN : {BULAN}
                </p>
            </div>
        </div>
    </header>


    <hr>
    <section class="detail_pegawai">
        <div class="row">
            <div class="col-lg-3">NAMA</div>
            <div class="col-lg-1">:</div>
            <div class="col-lg-8">{{ $pegawai->nama }}</div>
        </div>
        <div class="row">
            <div class="col-lg-3">NPK</div>
            <div class="col-lg-1">:</div>
            <div class="col-lg-8">{{ $pegawai->nik }}</div>
        </div>
        <div class="row">
            <div class="col-lg-3">JABATAN</div>
            <div class="col-lg-1">:</div>
            <div class="col-lg-8">{{ $pegawai->pegawai_jabatan->nama }}</div>
        </div>
        <div class="row">
            <div class="col-lg-3">LEVEL</div>
            <div class="col-lg-1">:</div>
            <div class="col-lg-4">
                @if($pegawai->pegawai_level_id == 0)
                -
                @else
                {{ $pegawai->pegawai_level->nama }}
                @endif
            </div>
            <div class="col-lg-4">Lokasi :
                @if($pegawai->pegawai_lokasi_id == 0)
                -
                @else
                {{ $pegawai->pegawai_lokasi->nama }}
                @endif 
            </div>
        </div>
    </section>
    <hr>

    <section class="perhitungan">
        <div class="row">


            <div class="col-lg-6">
                <span>PENDAPATAN</span>
                
                <div class="row">
                    <div class="col-md-5">Gaji Dasar</div>
                    <div class="col-md-1">:</div>
                    <div class="col-md-6">{{ $data[0]->i_gaji_dasar }}</div>
                </div>

                <div class="row">
                    <div class="col-md-5">Tunjangan</div>
                    <div class="col-md-1">:</div>
                    <div class="col-md-6">{{ $data[0]->i_tunjangan }}</div>
                </div>

                <div class="row">
                    <div class="col-md-5">Tunjangan Jabatan</div>
                    <div class="col-md-1">:</div>
                    <div class="col-md-6">{{ $data[0]->i_tunjangan_jabatan }}</div>
                </div>

                <div class="row">
                    <div class="col-md-5">Tunjangan Komunikasi</div>
                    <div class="col-md-1">:</div>
                    <div class="col-md-6">{{ $data[0]->i_tunjangan_komunikasi }}</div>
                </div>

                <div class="row">
                    <div class="col-md-5">Tunjangan Pensiun</div>
                    <div class="col-md-1">:</div>
                    <div class="col-md-6">{{ $data[0]->i_tunjangan_pensiun }}</div>
                </div>

                <div class="row">
                    <div class="col-md-5">Lembur</div>
                    <div class="col-md-1">:</div>
                    <div class="col-md-6">{{ $data[0]->i_lembur }}</div>
                </div>

                <hr>
                <div class="row">
                    <div class="col-md-5">TOTAL PENDAPATAN</div>
                    <div class="col-md-1">:</div>
                    <div class="col-md-6">{{ $data[0]->t_pendapatan }}</div>
                </div>
            </div>

            <div class="col-lg-6">
                <span>POTONGAN</span>

                <div class="row">
                    <div class="col-md-5">BPJS Tenaga Kerja</div>
                    <div class="col-md-1">:</div>
                    <div class="col-md-6">{{ $data[0]->o_bpjs_tenaga_kerja }}</div>
                </div>

                <div class="row">
                    <div class="col-md-5">BPJS Kesehatan</div>
                    <div class="col-md-1">:</div>
                    <div class="col-md-6">{{ $data[0]->o_bpjs_kesehatan }}</div>
                </div>

                <div class="row">
                    <div class="col-md-5">Dana Pensiun</div>
                    <div class="col-md-1">:</div>
                    <div class="col-md-6">{{ $data[0]->o_dana_pensiun }}</div>
                </div>

                <div class="row">
                    <div class="col-md-5">Potongan Komunikasi</div>
                    <div class="col-md-1">:</div>
                    <div class="col-md-6">{{ $data[0]->o_komunikasi }}</div>
                </div>

                <div class="row">
                    <div class="col-md-5">Potongan Lain-Lain</div>
                    <div class="col-md-1">:</div>
                    <div class="col-md-6">{{ $data[0]->o_lain_1 }}</div>
                </div>

                <div class="row">
                    <div class="col-md-5">Potongan Lain-Lain (2)</div>
                    <div class="col-md-1">:</div>
                    <div class="col-md-6">{{ $data[0]->o_lain_2 }}</div>
                </div>

                <div class="row">
                    <div class="col-md-5">Potongan Lain-Lain (3)</div>
                    <div class="col-md-1">:</div>
                    <div class="col-md-6">{{ $data[0]->o_lain_3 }}</div>
                </div>

                <hr>
                <div class="row">
                    <div class="col-md-5">TOTAL POTONGAN</div>
                    <div class="col-md-1">:</div>
                    <div class="col-md-6">{{ $data[0]->t_potongan }}</div>
                </div>
            </div>

            <hr>
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-6">&nbsp;</div>
                    <div class="col-lg-6">
                        <div class="row">
                            <div class="col-md-5">TAKE HOME PAY</div>
                            <div class="col-md-1">:</div>
                            <div class="col-md-6">{{ $data[0]->t_takehome }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-12 mt-3">
                <div class="row">
                    <div class="col-lg-6">
                        <span>Lain-lain</span>
        
                        <div class="row">
                            <div class="col-md-5">Tunjangan Hari Raya </div>
                            <div class="col-md-1">: </div>
                            <div class="col-md-6">{{ $data[0]->i_hari_raya }}</div>
                        </div>
        
                        <div class="row">
                            <div class="col-md-5">Tun. Work Annyversary </div>
                            <div class="col-md-1">: </div>
                            <div class="col-md-6">{{ $data[0]->i_work_anniversary }} </div>
                        </div>
        
                        <div class="row">
                            <div class="col-md-5">Jasa Kerja {{ date("Y")-1 }}</div>
                            <div class="col-md-1">: </div>
                            <div class="col-md-6">{{ $data[0]->i_jasa_kerja }} </div>
                        </div>
        
                        <div class="row">
                            <div class="col-md-5">Rapel {{ date("Y") }} </div>
                            <div class="col-md-1">: </div>
                            <div class="col-md-6">{{ $data[0]->i_rapel }} </div>
                        </div>

                        <div class="row">
                            <div class="col-md-5">Tunjangan Lain-Lain </div>
                            <div class="col-md-1">: </div>
                            <div class="col-md-6">{{ $data[0]->i_lain_1 }} </div>
                        </div>

                        <div class="row">
                            <div class="col-md-5">Tunjangan Lain-Lain (2) </div>
                            <div class="col-md-1">: </div>
                            <div class="col-md-6">{{ $data[0]->i_lain_2 }} </div>
                        </div>

                        <div class="row">
                            <div class="col-md-5">Tunjangan Lain-Lain (3) </div>
                            <div class="col-md-1">: </div>
                            <div class="col-md-6">{{ $data[0]->i_lain_3 }} </div>
                        </div>

                    </div>
        
        
                    <div class="col-lg-6">
                        <span>METODE TRANSFER</span>
        
                        <div class="row">
                            <div class="col-md-5">BANK </div>
                            <div class="col-md-1">: </div>
                            <div class="col-md-6">- </div>
                        </div>
        
                        <div class="row">
                            <div class="col-md-5">NO. REKENING </div>
                            <div class="col-md-1">: </div>
                            <div class="col-md-6">- </div>
                        </div>
        
                        <div class="row">
                            <div class="col-md-5">ATAS NAMA</div>
                            <div class="col-md-1">: </div>
                            <div class="col-md-6">- </div>
                        </div>
        
                        <div class="row">
                            <div class="col-md-5">JUMLAH </div>
                            <div class="col-md-1">: </div>
                            <div class="col-md-6">{{ $data[0]->t_takehome }} </div>
                        </div>

                        <div class="row">
                            <div class="col-md-5">TANGGAL </div>
                            <div class="col-md-1">: </div>
                            <div class="col-md-6">{{ $data[0]->tanggal }} </div>
                        </div>
                    </div>
                </div>
            </div>
            


        </div>
    </section>


    </div>















    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  </body>
</html>