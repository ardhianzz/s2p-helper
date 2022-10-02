
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
                                <input type="search" name="cari" value="{{ request()->cari }}">
                                <button type="submit" class="bnt btn-sm btn-dark">Cari</button>
                            </form>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div @if(request()->previewID != null) class="col-lg-6" @else class="col-lg-12" @endif >
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <td>No</td>
                                                <td>Nama</td>
                                                @if(request()->previewID == null) 
                                                    <td>Deskripsi / Keterangan</td> 
                                                @endif
                                                <td>Aksi</td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($pengumuman as $i)    
                                                <tr>
                                                    <td>{{ $loop->index + $pengumuman->firstItem() }}</td>
                                                    <td><a href="?previewID={{ $i->id }}"> {{ $i->nama }} </a></td>
                                                    @if(request()->previewID == null) 
                                                        <td><a href="?previewID={{ $i->id }}"> {{ $i->keterangan }} </a></td> 
                                                    @endif
                                                    <td>
                                                        <a href="?previewID={{ $i->id }}">
                                                            <button class="btn btn-success">Preview</button>
                                                        </a>
                                                    </td>
                                                
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="4">
                                                    {{ $pengumuman->withQueryString()->links() }}
                                                </td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>

                                @if(request()->previewID != null)
                                <div class="col-lg-6">
                                    <div class="card">
                                        <div class="card-header d-flex justify-content-between">
                                            <span>
                                                Preview
                                            </span>
                                            <span>
                                                <a href="{{ $i->p_pengumuman_dokumen->path }}" target="_blank">
                                                    <button class="btn btn-primary btn-sm"> Open New Tab</button>
                                                </a>
                                                <a href="{{ request()->url() }}">
                                                    <button class="btn btn-warning btn-sm">Close</button>
                                                </a>
                                            </span>
                                        </div>
                                        <div class="card-body">
                                            <div class="col-md-12">
                                                <embed src="{{ $dokumen[0]->path }}" type="" width="100%" height="750px">
                                            </div>
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

