
@extends('layout.main')
@include('lembur.sidebar.menu')

@section('container')
<style>
    a{
        text-decoration: none;
    }
    
    input::placeholder {
    font-weight: bold;
    opacity: .5;
    color: red;
    }
    
</style>
<div hidden>
    {{ $jenis_report    = request()->jenis_report }}
    {{ $filter          = request()->filter }}
</div>
<div class="container-fluid px-4">
   <div>

       <div class="row">
           <h1 class="mt-4">{{ $title }}</h1>
        </div>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">PT Sumber Segara Primadaya</li>
        </ol>
    </div>
    
    {{-- <div class="content">
        <div class="box">
            <div class="box-header">
                <a href="#" class="btn btn-dark text-light btn-sm" data-toggle="collapse" id="hide_filter" aria-expanded="true">
                    <i class="fa fa-filter"></i>
                    <span class="hidden-xs" >Filter</span>
                </a>
                <div class="card" id="show">
                    <div class="card-header">
                        <div class="card-body">
                            <form action="/lembur_report" method="get" >
                                <div class="row">

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <div class="mb-2"><strong>Periode</strong></div>
                                            <select name="periode" class="form-control" id="periode_lembur">
                                                @foreach ($periode as $p)
                                                    <option value="{{ $p->periode }}"
                                                        @if(request()->periode == $p->periode) selected @endif>
                                                         {{ $p->periode }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <div class="mb-2"><strong>Jenis Laporan</strong></div>
                                            <select name="jenis_report" class="form-control">
                                                <option value="detail"  @if(request()->jenis_report == "detail") selected @endif>Detail</option>
                                                <option value="general" @if(request()->jenis_report == "general") selected @endif>General</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <div class="mb-2"><strong>Status</strong></div>
                                            <select name="filter" class="form-control">
                                                <option @if(request()->filter == "semua") selected @endif value="semua">Semua</option>
                                                <option @if(request()->filter == "disetujui") selected @endif value="disetujui">Disetujui</option>
                                                <option @if(request()->filter == "diajukan") selected @endif value="diajukan">Diajukan</option>
                                                <option @if(request()->filter == "selesai") selected @endif value="selesai">Selesai</option>
                                            </select>
                                        </div>
                                    </div>


                                </div>
                            
                                <div class="form-group mt-3">
                                    <button class="btn btn-dark text-light">
                                        <i class="fa fa-check"></i>
                                        Apply
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
    <hr>


    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <form action="/lembur_report" method="get" > @csrf
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <div class="mb-2"><strong>Periode</strong></div>
                                            <select name="periode" class="form-control" id="periode_lembur">
                                                @foreach ($periode as $p)
                                                    <option value="{{ $p->periode }}"
                                                        @if(request()->periode == $p->periode) selected @endif>
                                                         {{ $p->periode }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <div class="mb-2"><strong>Jenis Laporan</strong></div>
                                            <select name="jenis_report" class="form-control">
                                                <option value="detail"  @if(request()->jenis_report == "detail") selected @endif>Detail</option>
                                                <option value="general" @if(request()->jenis_report == "general") selected @endif>General</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <div class="mb-2"><strong>Status</strong></div>
                                            <select name="filter" class="form-control">
                                                <option @if(request()->filter == "semua") selected @endif value="semua">Semua</option>
                                                <option @if(request()->filter == "disetujui") selected @endif value="disetujui">Disetujui</option>
                                                <option @if(request()->filter == "diajukan") selected @endif value="diajukan">Diajukan</option>
                                                <option @if(request()->filter == "selesai") selected @endif value="selesai">Selesai</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-4 d-flex justify-content-between">
                                        <span>
                                            <div class="mb-2"><strong>&nbsp;</strong></div>
                                            <button class="btn btn-dark text-light">
                                                <i class="fa fa-check"></i>
                                                Apply
                                            </button>
                                        </span>

                                        <div class="col-md-4">
                                            <div class="mb-2"><strong>&nbsp;</strong></div>
                                            <button class="btn btn-success btn-block" onclick="ExportToExcel('xlsx')">
                                                <i class="fa fa-file-excel" style="font-size: 20px"></i> &nbsp;
                                                Export to Excel
                                            </button>
                                        </div>
                                    </div>

                                    {{-- <div class="col-md-2">
                                        <div class="mb-2"><strong>&nbsp;</strong></div>
                                        <button class="btn btn-success btn-block" onclick="ExportToExcel('xlsx')">
                                            <i class="fa fa-file-excel" style="font-size: 20px"></i> &nbsp;
                                            Export to Excel
                                        </button>
                                    </div> --}}
                                </div> 
                            </form>
                </div>
                <div class="card-body">
                    @if(request()->jenis_report == null || request()->jenis_report== "general")
                        <table class="table table-bordered" id="tbl_exporttable_to_xls">
                            <tr>
                                <td width="50px">No</td>
                                <td>Nama</td>
                                <td>Lembur Biasa</td>
                                <td>Lembur Libur</td>
                                <td>status</td>
                            </tr>
                            @foreach ($data_lembur as $i)
                            <tr>
                                <td>{{ $loop->index+1 }}</td>
                                <td>{{ $i->nama }}</td>
                                <td>{{ format_jam($i->total_biasa) }}</td>
                                <td>{{ format_jam($i->total_libur) }}</td>
                                <td>{{ $i->status }}</td>
                            </tr>
                            @endforeach
                        </table>
                    @else
                    <table class="table table-bordered" id="tbl_exporttable_to_xls">
                        <tr>
                            <td width="50px">No</td>
                            <td>Nama</td>
                            <td>Tanggal Lembur</td>
                            <td>Lembur Pagi</td>
                            <td>Keterangan</td>
                            <td >Jam Masuk</td>
                            <td >Jam Pulang Standar</td>
                            <td >Jam Pulang Sebenarnya</td>
                            <td >Jam Lembur</td>
                            <td >Status Hari</td>
                        </tr>
                        @foreach ($data_lembur as $i)
                        <tr>
                            <td >{{ $loop->index+1 }}</td>
                            <td>{{ $i->nama }}</td>
                            <td>{{ tanggl_id($i->tanggal) }}</td>
                            <td>
                                @if($i->lembur_pagi == 1)
                                    Ya
                                @else
                                    Tidak
                                @endif
                            </td>
                            <td>{{ $i->keterangan }}</td>
                            <td>{{ format_jam($i->jam_masuk) }}</td>
                            <td>{{ format_jam($i->jam_pulang_standar) }}</td>
                            <td>{{ format_jam($i->jam_pulang) }}</td>
                            <td>{{ format_jam($i->jam_lembur) }}</td>
                            <td>
                                @if($i->hari_libur == 0) Hari Biasa @endif
                                @if($i->hari_libur == 1) Hari Libur @endif
                            </td>
                        </tr>
                        @endforeach
                    </table>
                    @endif
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
       var periode = document.getElementById("periode_lembur").value.trim();

       return dl ?
         XLSX.write(wb, { bookType: type, bookSST: true, type: 'base64' }):
         XLSX.writeFile(wb, fn || ('Lembur_'+periode+'.'+ (type || 'xlsx')));
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



<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
$(document).ready(function(){
// $("#show").hide();
  $("#hide_filter").click(function(){
    $("#show").toggle();
  });
});
</script>