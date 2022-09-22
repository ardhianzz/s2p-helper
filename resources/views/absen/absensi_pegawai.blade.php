@extends('layout.main')
@include('absen.sidebar.menu')

@section('container')

        <div class="container-fluid px-4">
            <h1 class="mt-4">{{ $title }}</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active">PT Sumber Segara Primadaya</li>
            </ol>

            {{-- <div class="row"> --}}
		<div class="content">
            <div class="card mb-2">
                <div class="card-header">
                    <div class="col-lg-12">
                            <form method="get" action="data_absensi_pegawai">
                                <div class="form-group">
                                    <span class="input-group" >
                                        <span class="input-group-addon"><i class="fa fa-calendar"></i>
                                            <input type="text" name="daterange" value="{{ date("Y-m-d") }}-{{ date("Y-m-d") }}">
                                        </span>
                                    </span>
                                </div>
                                <button class="btn btn-primary" type="submit">Search</button>
                            </form>
                    </div>
                </div>
            </div>
                    <div class="card">
                        {{-- <div class="card-header">

                            <div class="card" id="show">
                                <div class="card-header">
                                    
                                        <form method="get" action="data_absensi_pegawai">
                                            <div class="form-group">
                                                <i class="ml-3">Tanggal Awal &nbsp;</i><input type="date" placeholder="tanggal " name="cari_akhir" aria-label="Search" value="{{ request('cari_akhir') }}">&nbsp;&nbsp;&nbsp;
                                                <i class="ml-3">Tanggal Akhir &nbsp;</i><input type="date" placeholder="tanggal " name="cari_awal" aria-label="Search" value="{{ request('cari_awal') }}">
                                                <button class="btn btn-primary" type="submit">Search</button>
                                                <input type="text" name="daterange" value="{{ date("Y-m-d") }}-{{ date("Y-m-d") }}" class="form-control">
                                            </div>
                                        </form>
                                    
                                </div>
                        </div> --}}

                        {{-- <hr> --}}


                        <div class="box-body table-respon">
                            {{-- {{ dd($periode) }} --}}
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <td>Nama Pegawai</td>
                                        <td>Tanggal</td>
                                        <td>Jam Masuk</td>
                                        <td>Jam Pulang</td>
                                        <td>Aksi</td>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($absensi as $i)
                                        <tr>
                                            <td>{{ $i->nama }}</td>
                                            <td>{{ tanggl_id($i->tanggal) }}</td>
                                            <td>{{ format_jam($i->jam_masuk) }}</td>
                                            <td>{{ format_jam($i->jam_pulang) }}</td>
                                            <td><button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#tambahData{{ $i->id }}">Tambah</button></td>

                                            <div class="modal fade" id="tambahData{{ $i->id }}" tabindex="-1" role="dialog"
                                                aria-labelledby="tambahData{{ $i->id }}"
                                                aria-hidden="true">

                                                <div class="modal-dialog modal-lg" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="tambahData{{ $i->id }}">Tambah Catatan Lembur</h5>
                                                                <button type="button" class="btn close btn-danger" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form action="/lembur/pengajuan_harian" method="post">
                                                                @csrf
                                                                <div class="form-group mb-4">
                                                                    <label for="tanggal" class="mb-2">Periode</label>
                                                                        <select name="lembur_pengajuan_id" class="form-control">
                                                                            @foreach ($periode as $z)
                                                                            <option value="{{ $z->id }}">{{ $z->periode }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                </div>

                                                                <div class="form-group mb-4">
                                                                    <label for="tanggal" class="mb-2">Tanggal</label>
                                                                    <input type="text" class="form-control" value="{{ tanggl_id($i->tanggal) }}" disabled>
                                                                    <input type="hidden" name="tanggal" value="{{ $i->tanggal }}">
                                                                </div>

                                                                <div class="form-group mb-4">
                                                                    <label for="keterangan" class="mb-2">Keterangan</label>
                                                                    <textarea class="form-control" name="keterangan" id="" rows="10" required></textarea>
                                                                </div>

                                                                <div class="form-group mb-4">
                                                                    <div for=""> <b> Pengajuan lembur ini pada Hari ? </b></div>
                                                                    <div class="form-check form-check-inline">
                                                                        <input class="form-check-input" type="radio" name="hari_libur" value="0" checked>
                                                                        <label class="form-check-label" >Hari Biasa</label>
                                                                    </div>
                                                                    <div class="form-check form-check-inline">
                                                                        <input class="form-check-input" type="radio" name="hari_libur" value="1">
                                                                        <label class="form-check-label">Hari Libur</label>
                                                                    </div>
                                                                </div>

                                                                <div class="form-group mb-4">
                                                                    <div for=""> <b>Pengajuan lembur ini termasuk Lembur Pagi (sebelum jam Masuk Kantor)? </b></div>
                                                                    <div class="form-check form-check-inline">
                                                                        <input class="form-check-input" type="radio" name="lembur_pagi" value="0" checked>
                                                                        <label class="form-check-label" >Bukan Lembur Pagi</label>
                                                                    </div>
                                                                    <div class="form-check form-check-inline">
                                                                        <input class="form-check-input" type="radio" name="lembur_pagi" value="1">
                                                                        <label class="form-check-label">Lembur Pagi</label>
                                                                    </div>
                                                                </div>


                                                                <div class="form-group mt-5">
                                                                    {{-- <input type="hidden" name="lembur_pengajuan_id" value="{{ $lembur_pengajuan_id }}"> --}}
                                                                    <button class="btn col-lg-2 btn-primary btn-lg" type="submit"> Tambah </button>
                                                                </div>
                                                            </form>
                                                        </div>


                                                    </div>
                                                </div>
                                            </div>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="3"> {{ $absensi->withQueryString()->links() }}</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            {{-- </div> --}}
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
<script>
$(document).ready(function(){
// $("#show").hide();
  $("#hide_filter").click(function(){
    $("#show").toggle();
  });
});
</script>
