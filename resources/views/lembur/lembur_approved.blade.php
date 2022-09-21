
@extends('layout.main')
@include('lembur.sidebar.menu')

@section('container')

<style>
    a{
        text-decoration: none;
    }
</style>
        <div class="container-fluid px-4">
            <h1 class="mt-4">{{ $title }}</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active">PT Sumber Segara Primadaya</li>
            </ol>

            <!-- <div class="row"> -->
                <div class="content">
                    <div class="card">

                        {{-- <div class="card-header">
                            <form action="/lembur_approved" method="get" class="form-inline">
                                <input type="search" placeholder="cari nama.." name="cari" value="{{ request()->cari }}">
                                <button class="btn btn-dark inline">Cari</button>
                            </form>
                        </div> --}}

                        <div class="card-body">
                                <table class="table table-bordered table-striped">
                                    <form action="/lembur_approved" method="GET" class="form-inline">@csrf
                                        <thead>
                                            <tr style="vertical-align: middle" class="bg-dark text-light">
                                                <td align="center" width="80px">No</td>
                                                <td>
                                                    <input type="text" name="nama" placeholder="Nama" class="form-control" value="{{ request()->nama }}" id="filterNama">
                                                </td>
                                                <td width="300px">
                                                    <input type="text" name="periode" placeholder="Periode" class="form-control" value="{{ request()->periode }}" id="filterPeriode">
                                                </td>
                                                <td align="center" width="180px">Hari Biasa</td>
                                                <td align="center" width="180px">Hari Libur</td>
                                                <td align="center" width="100px">
                                                    Status
                                                </td>
                                                <td align="center" width="150px">
                                                    <input type="submit" name="Cari" value="Cari" class="btn btn-primary form-control">
                                                </td>
                                            </tr>
                                        </thead>
                                    </form>
                                    <tbody>
                                        @if(count($pengajuan_lembur) > 0)
                                        @foreach ($pengajuan_lembur as $d)
                                            <tr style="vertical-align: middle">
                                                <td align="center">{{ $pengajuan_lembur->firstItem() + $loop->index  }}</td>
                                                <td>{{ $d->nama }}</td>
                                                <td>{{ $d->periode }}</td>
                                                <td align="center">{{ format_jam($d->total_biasa) }}</td>
                                                <td align="center">{{ format_jam($d->total_libur) }}</td>
                                                @if($d->status == "Disetujui")
                                                    <td align="center" class="bg-info">
                                                        <a href="/lembur_approved/detail_hrd/{{ $d->id }}">
                                                            <div class="text-light">
                                                                {{ $d->status }}
                                                            </div>
                                                        </a>
                                                    </td>
                                                @elseif($d->status == "Selesai")
                                                    <td align="center" class="bg-success">
                                                        <a href="/lembur_approved/detail/{{ $d->id }}">
                                                        <div class="text-light">
                                                            {{ $d->status }}
                                                        </div>
                                                        </a>
                                                    </td>
                                                @else
                                                    <td align="center" class="bg-primary">
                                                        <a href="/lembur_approved/detail_hrd/{{ $d->id }}">
                                                        <div class="text-light">
                                                            {{ $d->status }}
                                                        </div>
                                                        </a>
                                                    </td>
                                                @endif
                                                </td>
                                                <td align="center">
                                                    <a href="/lembur/print/{{ $d->id }}/{{ Str::slug($d->periode) }}" class="btn btn-primary btn-xs">
                                                        <i class="fa fa-print" data-toogle="tooltip" data-placement="top" title="print"></i>
                                                    </a>

                                                        @if ($d->status == "Disetujui")

                                                            <button class="btn btn-success btn-xs" 
                                                                    data-toggle="modal" 
                                                                    data-target="#tambahData{{ $d->id }}">
                                                                    <i class="fa fa-check-circle" data-toogle="tooltip" data-placement="top" title="Terima Pengajuan "></i>
                                                            </button>
                                                        @endif
                                                </td>
                                                <div class="modal fade" id="tambahData{{ $d->id }}" tabindex="-1" role="dialog"
                                                    aria-labelledby="tambahData{{ $d->id }}"
                                                    aria-hidden="true">

                                                        <div class="modal-dialog modal-lg" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="tambahData{{ $d->id }}">Terima Pengajuan</h5>
                                                                        <button type="button" class="btn close btn-danger" data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <form action="/lembur/terima_pengajuan_lembur" method="POST">
                                                                        @csrf
                                                                        <h4>Apakah Anda Yakin Ingin Menerima Pengejuan Lembur ?</h4>
                                                                        <h5>Pengajuan dari : <strong>{{ $d->nama }}</strong></h5>
                                                                        <h5>Periode  : <strong>{{ $d->periode }}</strong></h5>
                                                                        <textarea name="komentar" rows="5" class="form-control"></textarea>

                                                                        <div class="form-group mt-3">
                                                                            <div class="form-check form-check-inline">
                                                                                <input class="form-check-input" type="radio" name="aksi_hrd" value="1" checked>
                                                                                <label class="form-check-label" >Setuju</label>
                                                                            </div>
                                                                            <div class="form-check form-check-inline">
                                                                                <input class="form-check-input" type="radio" name="aksi_hrd" value="0">
                                                                                <label class="form-check-label">Tidak Setuju</label>
                                                                            </div>
                                                                        </div>
                                                                        <input type="hidden" name="lembur_pengajuan_id" value="{{ $d->id }}">
                                                                        <div class="form-group mt-3">
                                                                            <button class="btn col-lg-2 btn-primary btn-lg" type="submit"> Kirim </button>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                            </tr>


                                        @endforeach
                                    </tbody>
                                        @else
                                        <tfoot>
                                            <tr>
                                                <td colspan="5"> Tidak Ada Pengajuan</td>
                                            </tr>
                                        </tfoot>
                                        @endif
                                        
                                        
                                        <tfoot>
                                            <tr>
                                                <td colspan="5"> {{ $pengajuan_lembur->withQueryString()->links() }}</td>
                                            </tr>
                                        </tfoot>
                                       
                                </table>
                            
                        </div>
                    </div>
                </div>
            <!-- </div> -->
        </div>




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

