
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
                                                <td width="50px">No</td>
                                                <td>Nama</td>
                                                @if(request()->previewID == null) 
                                                    <td>Deskripsi / Keterangan</td> 
                                                @endif
                                                <td width="100px">Aksi</td>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            @if(DB::table("pegawai")->where("user_id", auth()->user()->id)->get()[0]->pegawai_lokasi_id == 1)
                                            {{-- dd(DB::table("Pegawai")->where("user_id", auth()->user()->id)->get()[0]->pegawai_lokasi_id == 1); --}}

                                                @foreach ($pengumuman_jkt as $i)
                                                <div hidden>
                                                    {{ $dibuka = DB::table("p_pengumuman_riwayat")->where("user_id", auth()->user()->id)->where("p_pengumuman_id", $i->id)->count() }}
                                                </div>    
                                                    <tr @if($dibuka == 0) style="background-color: beige; font-weight: bold;" @endif>
                                                        <td>{{ $loop->index + $pengumuman_jkt->firstItem() }}</td>
                                                        <td><a href="?previewID={{ $i->id }}"> {{ $i->nama }} </a></td>
                                                        @if(request()->previewID == null) 
                                                            <td><a href="?previewID={{ $i->id }}"> {{ $i->keterangan }} </a>
                                                            </td> 
                                                        @endif
                                                        <td>
                                                            <a href="?previewID={{ $i->id }}">
                                                                <button class="btn btn-success">Preview</button>
                                                            </a>
                                                        </td>
                                                    
                                                    </tr>
                                                @endforeach
                                            @endif

                                            @if(DB::table("pegawai")->where("user_id", auth()->user()->id)->get()[0]->pegawai_lokasi_id == 2)
                                                @foreach ($pengumuman_clcp as $i)
                                                <div hidden>
                                                    {{ $dibuka = DB::table("p_pengumuman_riwayat")->where("user_id", auth()->user()->id)->where("p_pengumuman_id", $i->id)->count() }}
                                                </div>    
                                                    <tr @if($dibuka == 0) style="background-color: beige; font-weight: bold;" @endif>
                                                        <td>{{ $loop->index + $pengumuman_clcp->firstItem() }}</td>
                                                        <td><a href="?previewID={{ $i->id }}"> {{ $i->nama }} </a></td>
                                                        @if(request()->previewID == null) 
                                                            <td><a href="?previewID={{ $i->id }}"> {{ $i->keterangan }} </a>
                                                            </td> 
                                                        @endif
                                                        <td>
                                                            <a href="?previewID={{ $i->id }}">
                                                                <button class="btn btn-success">Preview</button>
                                                            </a>
                                                        </td>
                                                    
                                                    </tr>
                                                @endforeach
                                            @endif

                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="4">
                                                    @if(DB::table("pegawai")->where("id", auth()->user()->id)->get()[0]->pegawai_lokasi_id == 1)
                                                        {{ $pengumuman_jkt->withQueryString()->links() }}
                                                    @endif
                                                    @if(DB::table("pegawai")->where("id", auth()->user()->id)->get()[0]->pegawai_lokasi_id == 2)
                                                        {{ $pengumuman_clcp->withQueryString()->links() }}
                                                @endif
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

