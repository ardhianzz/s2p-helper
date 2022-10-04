
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
                            <form>
                                <input type="search" name="cari" value="{{ request()->cari }}" autocomplete="off">
                                <button type="submit" class="bnt btn-sm btn-dark">Cari</button>
                            </form>

                            
                            <button class="btn btn-success btn-block" onclick="ExportToExcel('xlsx')">
                                <i class="fa fa-file-excel" style="font-size: 20px"></i> &nbsp;
                                Export to Excel
                            </button>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered" id="tbl_exporttable_to_xls">
                                <thead> 
                                    <tr>
                                        <td width="50px">No</td>
                                        {{-- <td width="150px">NIK</td> --}}
                                        <td>Nama</td>
                                        <td>Pendapatan</td>
                                        <td>Pendapatan Lain</td>
                                        <td>Potongan</td>
                                        <td>Total</td>
                                        <td width="150px">Aksi</td>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($rincian_gaji as $i)
                                        <tr>
                                            <td>{{ $loop->index + $rincian_gaji->firstItem() }}</td>
                                            {{-- <td>{{ $i->nik }}</td> --}}
                                            <td>{{ $i->nama }}</td>
                                            <td>{{ rupiah($i->pendapatan) }}</td>
                                            <td>{{ rupiah($i->pendapatan_lain) }}</td>
                                            <td>{{ rupiah($i->potongan) }}</td>
                                            <td>{{ rupiah($i->total) }}</td>
                                            <td>
                                                <a href="/pengumuman/manage_slip_gaji/detail_periode/print/{{ $i->nik }}?dan={{ $i->id }}">
                                                    <button class="btn btn-info">Preview</button>
                                                </a>
                                            </td>
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

