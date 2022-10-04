
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
                                        <h5 class="modal-title" id="buatreminder">Tambah Catatan Pengingat</h5>
                                            <button type="button" class="btn close btn-danger" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                             </button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="/reminder/tambah_catatan" method="post">
                                            @csrf
                                            <div class="form-group mb-4">
                                                <label for="nama" class="mb-2">Nama</label>
                                                <input type="text" name="nama" class="form-control" placeholder="Nama catatan yang akan diingatkan" required>
                                            </div>
                                            <div class="form-group mb-4">
                                                <h6>Masa Berlaku</h6>
                                                <input type="date" name="from" class="form-control" required value="{{ date("Y-m-d") }}">

                                                <label for="s/d" class="mb-2">s/d</label>
                                                <input type="date" name="to" class="form-control" required value="{{ date("Y-m-d") }}">
                                            </div>
                                            <div class="form-group mb-4">
                                                <label for="expired" class="mb-2">Tanggal Expired</label>
                                                <input type="date" name="tanggal_expired" class="form-control" required value="{{ date("Y-m-d") }}">
                                            </div>
                                            <div class="form-group mb-4">
                                                <label for="pengingat" class="mb-2">Tanggal Pengingat</label>
                                                <input type="date" name="tanggal_pengingat" class="form-control" required value="{{ date("Y-m-d") }}">
                                            </div>
                                            <div class="form-group mb-4">
                                                <label for="email" class="mb-2">Email</label>
                                                <input type="text" name="email" class="form-control" placeholder="example@ssprimadaya.co.id" required>
                                            </div>
                                            <div class="form-group mb-4">
                                                <label for="keterangan" class="mb-2">Keterangan</label>
                                                <textarea class="form-control" name="keterangan" id="" rows="3" required></textarea>
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
                            <td width="50px">
                                <a href="/reminder/manage_reminder/detail/{{ $r->user_id }}" class="btn btn-info btn-xs">
                                    <i class="fa fa-info" aria-hidden="true" data-toogle="tooltip" data-placement="top" title="Detail"></i>
                                </a>
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