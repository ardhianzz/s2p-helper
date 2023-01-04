
@extends('layout.main')
@include('pengumuman.sidebar.menu')

@section('container')
        <style>
            a{
                text-decoration: none;
            }
        </style>
        <div class="container-fluid px-4">
            <h1 class="mt-4">{{ $title }}</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active">{{ $sub_title }}</li>
            </ol>
            
            <div class="row">
                <div class="col-lg-12">
                    <div class="nav card">
                        <div class="card-header d-flex justify-content-between">
                            <div class="col-lg-3">
                                <form class="row">
                                    <div class="col-md-9" style="padding-right: 0px">
                                        <input class="form-control" type="search" placeholder="Periode.." aria-label="Periode.." name="cari" value="{{ request()->cari }}">
                                    </div>
                                    <div class="col-md-3">
                                        <button class="btn btn-dark text-white" type="submit">Search</button>
                                    </div>
                                </form>
                            </div> 
                            {{-- <form>
                                <input type="search" name="cari" value="{{ request()->cari }}" autocomplete="off">
                                <button type="submit" class="bnt btn-sm btn-dark">Cari</button>
                            </form> --}}

                            
                            <button class="btn btn-success btn-block" onclick="ExportToExcel('xlsx')">
                                <i class="fa fa-file-excel" style="font-size: 20px"></i> &nbsp;
                                Export to Excel
                            </button>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div @if(request()->previewID == null) class="col-lg-12" @else class="col-lg-5" @endif>
                                    <table class="table table-bordered" id="tbl_exporttable_to_xls">
                                        <thead> 
                                            <tr>
                                                <td width="50px">No</td>
                                                <td>Nama</td>
                                                <td>Periode</td>
                                                @if(request()->previewID == null)
                                                <td>Pendapatan</td>
                                                <td>Potongan</td>
                                                @endif
                                                <td>Total</td>
                                                @if(request()->previewID == null)
                                                <td width="150px">Aksi</td>
                                                @endif
                                            </tr>
                                        </thead>
        
                                        <tbody>
                                            @foreach ($rincian_gaji as $i)
                                                <tr @if($i->has_opened == null) style="background-color: beige; font-weight: bold;" @endif>
                                                    <td>{{ $loop->index + $rincian_gaji->firstItem() }}</td>
                                                    <td> <a href="?previewID={{ $i->id }}"> {{ $i->nama }} </a></td>
                                                    <td> <a href="?previewID={{ $i->id }}"> {{ $i->periode }} </a></td>
                                                    @if(request()->previewID == null)
                                                    <td> <a href="?previewID={{ $i->id }}"> {{  rupiah(enkipsi_decript($i->t_pendapatan, "de"))  }} </a></td>
                                                    <td> <a href="?previewID={{ $i->id }}"> {{  rupiah(enkipsi_decript($i->t_potongan, "de"))  }} </a></td>
                                                    @endif
                                                    <td> <a href="?previewID={{ $i->id }}"> {{  rupiah(enkipsi_decript($i->t_takehome, "de"))  }} </a></td>
                                                    @if(request()->previewID == null)
                                                    <td>
                                                        <a href="?previewID={{ $i->id }}">
                                                            <button class="btn btn-info">Preview</button>
                                                        </a>
                                                    </td>
                                                    @endif
                                                </tr>
                                            @endforeach
                                        </tbody>
        
                                        <tfoot>
                                            <tr>
                                                <td colspan="6">{{ $rincian_gaji->withQueryString()->links() }}</td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>

                                @if(request()->previewID != null)
                                    <div class="col-lg-7">

                                        <div class="card">
                                            <div class="card-header d-flex justify-content-between">
                                                <span>Preview</span>
                                                <span>
                                                    <a href="/pengumuman/slip_gaji/{{ $i->nik }}/{{ $i->id }}" target="_blank">
                                                        <button class="btn btn-sm btn-primary">Open New Tab</button>
                                                    </a>
                                                    <a href="/pengumuman/slip_gaji/{{ $i->nik }}/{{ $i->id }}/export_pdf" 
                                                        class="btn btn-sm btn-success">
                                                        Save As PDF
                                                    </a>
                                                    <a href="{{ request()->url() }}">
                                                        <button class="btn btn-sm btn-warning">Close</button>
                                                    </a>
                                                </span>
                                            </div>
                                            
                                            <div class="card-body">
                                                <table border="1" class="table">
                                                    <tr width="100%">
                                                        <td width="50%">
                                                            <span> <strong> PENDAPATAN </strong></span>

                                                            <div class="row">
                                                                <div class="col-md-5">Gaji Dasar</div>
                                                                <div class="col-md-7">: {{ rupiah(enkipsi_decript($detailGaji->i_gaji_dasar, "de")) }} </div>
                                                            </div>

                                                            <div class="row">
                                                                <div class="col-md-5">Tunjangan</div>
                                                                <div class="col-md-7">: {{ rupiah(enkipsi_decript($detailGaji->i_tunjangan, "de")) }} </div>
                                                            </div>

                                                            <div class="row">
                                                                <div class="col-md-5">Tunjangan Jabatan</div>
                                                                <div class="col-md-7">: {{ rupiah(enkipsi_decript($detailGaji->i_tunjangan_jabatan, "de")) }} </div>
                                                            </div>

                                                            <div class="row">
                                                                <div class="col-md-5">Tunjangan Komunikasi</div>
                                                                <div class="col-md-7">: {{ rupiah(enkipsi_decript($detailGaji->i_tunjangan_komunikasi, "de")) }} </div>
                                                            </div>

                                                            <div class="row">
                                                                <div class="col-md-5">Tunjangan Pensiun</div>
                                                                <div class="col-md-7">: {{ rupiah(enkipsi_decript($detailGaji->i_tunjangan_pensiun, "de")) }} </div>
                                                            </div>

                                                            <div class="row">
                                                                <div class="col-md-5">Lembur</div>
                                                                <div class="col-md-7">: {{ rupiah(enkipsi_decript($detailGaji->i_lembur, "de")) }} </div>
                                                            </div>
                                                        </td>

                                                        <td width="50%">
                                                            <span> <strong>POTONGAN</strong></span>

                                                            <div class="row">
                                                                <div class="col-md-5">BPJS Tenaga Kerja</div>
                                                                <div class="col-md-7">: {{ rupiah(enkipsi_decript($detailGaji->o_bpjs_tenaga_kerja,"de")) }}</div>
                                                            </div>

                                                            <div class="row">
                                                                <div class="col-md-5">BPJS Kesehatan</div>
                                                                <div class="col-md-7">: {{ rupiah(enkipsi_decript($detailGaji->o_bpjs_kesehatan,"de")) }}</div>
                                                            </div>

                                                            <div class="row">
                                                                <div class="col-md-5">Dana Pensiun</div>
                                                                <div class="col-md-7">: {{ rupiah(enkipsi_decript($detailGaji->o_dana_pensiun,"de")) }}</div>
                                                            </div>

                                                            <div class="row">
                                                                <div class="col-md-5">Potongan Komunikasi</div>
                                                                <div class="col-md-7">: {{ rupiah(enkipsi_decript($detailGaji->o_komunikasi,"de")) }}</div>
                                                            </div>

                                                            <div class="row">
                                                                <div class="col-md-5">Potongan Lain-Lain</div>
                                                                <div class="col-md-7">: {{ rupiah(enkipsi_decript($detailGaji->o_lain_1,"de")) }}</div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    
                                                    <tr>
                                                        <td width="50%">
                                                            <div class="row">
                                                                <div class="col-md-5"><strong>TOTAL PENDAPATAN</strong></div>
                                                                <div class="col-md-7">: {{ rupiah(enkipsi_decript($detailGaji->t_pendapatan, "de"))  }}</div>
                                                            </div>
                                                        </td>

                                                        <td width="50%">
                                                            <div class="row">
                                                                <div class="col-md-5"><strong>TOTAL POTONGAN</strong></div>
                                                                <div class="col-md-7">: {{ rupiah(enkipsi_decript($detailGaji->t_potongan ,"de")) }}</div>
                                                            </div>
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td width="50%">
                                                            <div class="row">
                                                                <div class="col-md-5">&nbsp;</div>
                                                                <div class="col-md-7">&nbsp;</div>
                                                            </div>
                                                        </td>

                                                        <td width="50%">
                                                            <div class="row">
                                                                <div class="col-md-5"><strong><i>PAY TAKE HOME</i></strong></div>
                                                                <div class="col-md-7">: {{ rupiah( enkipsi_decript($detailGaji->t_pendapatan, "de")- enkipsi_decript($detailGaji->t_potongan, "de")) }}</div>
                                                            </div>
                                                        </td>
                                                    </tr>


                                                    <tr>
                                                        <td width="50%">
                                                            <span>Lain-Lain :</span>

                                                            <div class="row">
                                                                <div class="col-md-5">Tunjangan Hari Raya</div>
                                                                <div class="col-md-7">: {{ rupiah(enkipsi_decript($detailGaji->i_hari_raya, "de")) }}</div>
                                                            </div>

                                                            <div class="row">
                                                                <div class="col-md-5">Tunj. Work Anniversary</div>
                                                                <div class="col-md-7">: {{ rupiah(enkipsi_decript($detailGaji->i_work_anniversary, "de")) }}</div>
                                                            </div>

                                                            <div class="row">
                                                                <div class="col-md-5">Jasa Kerja {{ date("Y")-1 }}</div>
                                                                <div class="col-md-7">: {{ rupiah(enkipsi_decript($detailGaji->i_jasa_kerja, "de")) }}</div>
                                                            </div>

                                                            <div class="row">
                                                                <div class="col-md-5">Rapel {{ date("Y") }}</div>
                                                                <div class="col-md-7">: {{ rupiah(enkipsi_decript($detailGaji->i_rapel, "de")) }}</div>
                                                            </div>

                                                            <div class="row">
                                                                <div class="col-md-5">PENDAPATAN LAIN</div>
                                                                <div class="col-md-7">: {{ rupiah(( enkipsi_decript($detailGaji->t_pendapatan_lain, "de"))) }}</div>
                                                            </div>



                                                        </td>

                                                        <td width="50%">

                                                            <div class="row">
                                                                <div class="col-md-5">&nbsp;</div>
                                                                <div class="col-md-7"></div>
                                                            </div>

                                                            <div class="row">
                                                                <div class="col-md-5">METODE TRANSFER</div>
                                                                <div class="col-md-7"></div>
                                                            </div>

                                                            <div class="row">
                                                                <div class="col-md-5">Bank</div>
                                                                <div class="col-md-7">:</div>
                                                            </div>

                                                            <div class="row">
                                                                <div class="col-md-5">No. Rekening</div>
                                                                <div class="col-md-7">:</div>
                                                            </div>

                                                            <div class="row">
                                                                <div class="col-md-5">A/N</div>
                                                                <div class="col-md-7">:</div>
                                                            </div>

                                                            <div class="row">
                                                                <div class="col-md-5">Jumlah</div>
                                                                <div class="col-md-7">: {{ rupiah(( enkipsi_decript($detailGaji->t_pendapatan, "de") +  enkipsi_decript($detailGaji->t_pendapatan_lain, "de")) - enkipsi_decript($detailGaji->t_potongan, "de")) }}</div>
                                                            </div>

                                                            <div class="row">
                                                                <div class="col-md-5">Tanggal Transfer</div>
                                                                <div class="col-md-7">:</div>
                                                            </div>
                                                        </td>
                                                    </tr>



                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
<script type="text/javascript" src="https://unpkg.com/xlsx@0.15.1/dist/xlsx.full.min.js"></script>
<script>

function ExportToExcel(type, fn, dl) {
        var elt = document.getElementById('tbl_exporttable_to_xls');
        var wb = XLSX.utils.table_to_book(elt, { sheet: "sheet1" });
        var periode = "Rekap_Pendapatan";

        return dl ?
        XLSX.write(wb, { bookType: type, bookSST: true, type: 'base64' }):
        XLSX.writeFile(wb, fn || (Date.now()+'_'+periode+'.'+ (type || 'xlsx')));
    }
</script>

@if(session()->has('success'))
    <div class="alert alert-success" role="alert">
        {{ session('success') }}
    </div>
@endif
@if(session()->has('error'))
    <div class="alert alert-danger" role="alert">
        {{ session('error') }}
    </div>
@endif
@endsection

