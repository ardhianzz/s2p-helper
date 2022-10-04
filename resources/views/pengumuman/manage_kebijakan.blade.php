
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
                            {{-- <button class="btn btn-dark text-light" data-toggle="modal" data-target="#tambahPengajuanService" >Pengajuan Perbaikan</button> --}}
                            <a href="/pengumuman/manage_kebijakan/membuat_pengumuman_baru">
                                <button class="btn btn-dark text-light">Pengumuman Baru</button>
                            </a>


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
                                                    <td>Status</td> 
                                                @endif
                                                <td width="100px">Aksi</td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($pengumuman as $i)    
                                                <tr>
                                                    <td>{{ $loop->index + $pengumuman->firstItem() }}</td>
                                                    <td><a href="?previewID={{ $i->id }}"> {{ $i->nama }} </a></td>
                                                    @if(request()->previewID == null) 
                                                        <td><a href="?previewID={{ $i->id }}"> {{ $i->keterangan }} </a></td> 
                                                        <td><a href="?previewID={{ $i->id }}"> {{ $i->status }} </a></td> 
                                                    @endif
                                                    <td>
                                                        @if($i->status == "Belum Diumumkan") 
                                                            <button class="btn btn-primary" data-toggle="modal" data-target="#publish{{ $i->id }}">Publish</button>
                                                        @endif

                                                        @if($i->status == "Diumumkan") 
                                                            <button class="btn btn-warning" data-toggle="modal" data-target="#takedown{{ $i->id }}">Takedown</button>
                                                        @endif

                                                    </td>

                                                    {{-- Modal Publish Pengumuman --}}
                                                    <div class="modal fade" id="publish{{ $i->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                            <h5 class="modal-title" id="publish{{ $i->id }}">Publish Pengumuman</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                            </div>
                                            
                                                            <form action="/pengumuman/manage_kebijakan/aksi_publish_pengumuman" method="POST">@csrf
                                                                <p>
                                                                    <strong>{{ $i->nama }}</strong> <br>
                                                                    {{ $i->keterangan }}
                                                                </p>
                                                                <hr>
                                                                <input type="hidden" name="type" value="publish">
                                                                <input type="hidden" name="publish_pengumuman" value="{{ $i->id }}">
                                                                <button type="submit" class="btn btn-primary"> Publish</button>
                                                            </form>
                                                        </div>
                                                        </div>
                                                    </div>

                                                    {{-- Modal Takedown Pengumuman --}}
                                                    <div class="modal fade" id="takedown{{ $i->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                            <h5 class="modal-title" id="takedown{{ $i->id }}">Takedown Pengumuman</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                            </div>
                                            
                                                            <form action="/pengumuman/manage_kebijakan/aksi_publish_pengumuman" method="POST">@csrf
                                                                <p>
                                                                    <strong>{{ $i->nama }}</strong> <br>
                                                                    {{ $i->keterangan }}
                                                                </p>
                                                                <hr>
                                                                <input type="hidden" name="type" value="takedown">
                                                                <input type="hidden" name="publish_pengumuman" value="{{ $i->id }}">
                                                                <button type="submit" class="btn btn-warning"> Takedown</button>
                                                            </form>
                                                        </div>
                                                        </div>
                                                    </div>
                                                
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
                                            <a href="/pengumuman/manage_kebijakan">
                                                <button class="btn btn-warning btn-sm">Close</button>
                                            </a>
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

