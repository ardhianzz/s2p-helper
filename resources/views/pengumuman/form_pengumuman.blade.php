
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
                    <div class="card">
                        <div class="card-body">
                           <form action="/pengumuman/manage_kebijakan/membuat_pengumuman_baru" 
                           method="POST" enctype="multipart/form-data">
                            @csrf

                            <span class="input-group mt-3 mb-3">
                                <div class="col-lg-3">
                                    <label for="">Lokasi</label>
                                </div>
                                <select name="lokasi" class="form-control" required>
                                    <option value="">-- Select --</option>
                                    <option value="Jakarta">Jakarta</option>
                                    <option value="Cilacap">Cilacap</option>
                                    <option value="Semua">Semua Lokasi</option>
                                </select>
                            </span>

                            <span class="input-group mt-3 mb-3">
                                <div class="col-lg-3">
                                    <label for="">Nama Pengumuman / Peraturan</label>
                                </div>
                                <div class="col-lg-9">
                                    <input type="text" name="nama" class="form-control">
                                </div>
                            </span>

                            <span class="input-group mt-3 mb-3">
                                <div class="col-lg-3">
                                    <label for="">Keterangan</label>
                                </div>
                                <div class="col-lg-9">

                                    <textarea name="keterangan" rows="5" class="form-control"></textarea>
                                </div>
                            </span>

                            <span class="input-group mt-3 mb-3">
                                <div class="col-lg-3">

                                    <label for="">Lampiran File</label>
                                </div>
                                <div class="col-lg-9">

                                    <input type="file" name="file" class="form-control">
                                </div>
                            </span>


                            <span class="input-group mt-3 mb-3">
                                <div class="col-lg-3">

                                    
                                </div>
                                <div class="col-lg-9">

                                    <button type="submit" class="btn btn-primary">simpan</button>
                                </div>
                            </span>

                            
                            </form>
                        </div>
                    </div>
                </div>
                
            </div>
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

