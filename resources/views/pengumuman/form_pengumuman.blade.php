
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

                            <span class="input-group">
                                <label for="">Nama Pengumuman / Peraturan</label>
                                <input type="text" name="nama" class="form-control">
                            </span>

                            <span class="input-group">
                                <label for="">Keterangan</label>
                                <textarea name="keterangan" cols="30" class="form-control"></textarea>
                            </span>

                            <span class="input-group">
                                <label for="">Lampiran File</label>
                                <input type="file" name="file" class="form-control">
                            </span>

                            <button type="submit" class="btn btn-primary">simpan</button>
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

