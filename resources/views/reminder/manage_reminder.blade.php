
@extends('layout.main')
@include('reminder.sidebar.menu')

@section('container')

<style>
    a{
        text-decoration: none;
    }
</style>
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

<div class="container-fluid px-4">
    <div class="row">
        <h1 class="mt-4">{{ $title }}</h1>
    </div>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">PT Sumber Segara Primadaya</li>
    </ol>

    <div class="row">
        <div class="col-xl-12">
            <div class="card mb-4 col-md-4">
                <div class="btn-group">
                    <button class="btn btn-success mr-2" data-toggle="modal" data-target="#buatreminder">Buat Pengingat </button>
                </div>

                <div class="modal fade" id="buatreminder" tabindex="-1" role="dialog"
                            aria-labelledby="buatreminder"
                            aria-hidden="true">

                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="buatreminder">Tambah Catatan</h5>
                                            <button type="button" class="btn close btn-danger" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                             </button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="/reminder/tambah_catatan" method="post">
                                            @csrf
                                            <div class="form-group mb-4">
                                                <h5 for="nama" class="mb-2">Nama Catatan *</h5>
                                                <input type="text" name="nama" class="form-control" placeholder="Nama catatan yang akan diingatkan" required>
                                            </div>
                                            <div class="form-group mb-4">
                                                <h5>Masa Berlaku *</h5>
                                                <input type="date" name="from" class="form-control" required value="{{ date("Y-m-d") }}">

                                                <h7 for="s/d" class="mb-2">s/d</h7>
                                                <input type="date" name="to" class="form-control" required value="{{ date("Y-m-d") }}">
                                            </div>
                                            <div class="form-group mb-4">
                                                <h5 for="expired" class="mb-2">Tanggal Expired *</h5>
                                                <input type="date" name="tanggal_expired" class="form-control" required value="{{ date("Y-m-d") }}">
                                            </div>
                                            <div class="form-group mb-4">
                                                <h5 for="pengingat" class="mb-2">Tanggal Pengingat *</h5>
                                                <input type="date" name="tanggal_pengingat" class="form-control" required value="{{ date("Y-m-d") }}">
                                            </div>
                                            <div class="form-group mb-4">
                                                <h5 for="email" class="mb-2">Email *</h5>
                                                <input type="text" name="email" class="form-control" placeholder="example@ssprimadaya.co.id" required>
                                            </div>
                                            <div class="form-group mb-4">
                                                <h5 for="keterangan" class="mb-2">Keterangan / Deskripsi *</h5>
                                                <textarea class="form-control" name="keterangan" id="" rows="3" placeholder="Keterangan atau Deskripsi Catatan" required></textarea>
                                            </div>


                                            <div class="form-group mt-5">
                                                <button class="btn col-lg-2 btn-primary btn-lg" type="submit"> Tambah </button>
                                            </div>
                                        </form>
                                    </div>


                                </div>
                            </div>
                        </div>

            </div>
            <div class="card-body table-respon mt-4">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <td>No</td>
                            <td>Nama Catatan</td>
                            <td>Tanggal Expired</td>
                            <td>Tanggal Pengingat</td>
                            <td>Email</td>
                            <td>Aksi</td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($reminder_data as $r)
                        <tr>
                            <td width="10px">{{ $loop->index+1 }}</td>
                            <td width="150px">{{ $r->nama }}</td>
                            <td width="150px">{{ $r->tanggal_expired }}</td>
                            <td width="150px">{{ $r->tanggal_pengingat }}</td>
                            <td width="100px">{{ $r->email }}</td>
                            <td width="100px">
                                <a href="/reminder/manage_reminder/detail/{{ $r->id }}" class="btn btn-info btn-xs">
                                    <i class="fa fa-info" aria-hidden="true" data-toogle="tooltip" data-placement="top" title="Detail"></i>
                                </a>
                                <button class="btn btn-danger btn-xs" 
                                        data-toggle="modal" 
                                        data-target="#hapusdata{{ $r->id }}">
                                        <i class="fa fa-trash" data-toogle="tooltip" data-placement="top" title="Batalkan Pengajuan"></i>
                                </button>

                                <div class="modal fade" id="hapusdata{{ $r->id }}" tabindex="-1" role="dialog"
                                    aria-labelledby="hapusdata{{ $r->id }}"
                                    aria-hidden="true">

                                        <div class="modal-dialog modal-lg" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="hapusdata{{ $r->id }}">Hapus Catatan </h5>
                                                        <button type="button" class="btn close btn-danger" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="/reminder/hapus_data_reminder" method="POST">
                                                        @csrf
                                                        <label>Apakah Anda Yakin Ingin Menghapus Catatan {{ $r->nama }}?</label>
                                                        <input type="hidden" name="r_reminder_data" value="{{ $r->id }}">
                                                        <div class="form-group mt-5">
                                                            <button class="btn col-lg-2 btn-primary btn-xs" type="submit"> Hapus </button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                            </td>
                        </tr>

                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>

@endsection