
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
                            <span>
                                <button class="btn btn-dark text-light" data-toggle="modal" data-target="#buatPengumumanSlip" >Upload Data</button>
                                <a href="/form/Detail%20Slip%20Gaji.xlsx">
                                    <button class="btn btn-primary text-light" >Download From</button>
                                </a>
                                
                            </span>
                            <form>
                                <input type="search" name="cari" value="{{ request()->cari }}" autocomplete="off">
                                <button type="submit" class="bnt btn-sm btn-dark">Cari</button>                                     
                            </form>
                        </div>
                        <div class="card-body">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <td width="30px">No</td>
                                        <td>Periode</td>
                                        <td>Status</td>
                                        <td width="200px">Aksi</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($slip_gaji as $i)
                                    <tr>
                                        <td>{{ $loop->index + $slip_gaji->firstItem() }}</td>
                                        <td>
                                            <a href="/pengumuman/manage_slip_gaji/detail_periode/{{ $i->id }}">
                                                {{ $i->periode }}
                                            </a>
                                        </td>
                                        <td>{{ $i->status }}</td>
                                        <td>
                                            @if($i->status == "Belum Diumumkan") 
                                                <span data-toggle="modal" data-target="#publish{{ $i->id }}">
                                                    <button class="btn btn-sm btn-primary">Publish</button>
                                                </span>
                                            @endif

                                            @if($i->status == "Diumumkan") 
                                                <span data-toggle="modal" data-target="#takedown{{ $i->id }}">
                                                    <button class="btn btn-sm btn-info">Takedown</button>
                                                </span> 
                                            @endif

                                            <span data-toggle="modal" data-target="#hapus{{ $i->id }}">
                                                <button class="btn btn-sm btn-warning">Hapus</button>
                                            </span>
                                        </td>

                                        {{-- Modal Publish --}}
                                        <div class="modal fade" id="publish{{ $i->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <form action="/pengumuman/manage_slip_gaji/publish_slip_gaji" method="POST" enctype="multipart/form-data"> @csrf
                                                    <input type="hidden" name="id" value="{{ $i->id }}">
                                                    <div class="modal-header">
                                                    <h5 class="modal-title" id="publish{{ $i->id }}">Publish Slip Gaji</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                    </div>

                                                    <div class="modal-body">
                                                        <h5>Tanggal Transfer</h5>
                                                        <input type="date" name="tanggal" value="{{ date("Y-m-d") }}" class="form-control">
                                                        <hr>
                                                        <button class="btn btn-primary" type="submit">Publish</button>
                                                    </div>
                                                </form>
                                            </div>
                                            </div>
                                        </div>


                                        {{-- Modal Publish --}}
                                        <div class="modal fade" id="takedown{{ $i->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                                            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <form action="/pengumuman/manage_slip_gaji/takedown_slip_gaji" method="POST" enctype="multipart/form-data"> @csrf
                                                    <input type="hidden" name="id" value="{{ $i->id }}">
                                                    <div class="modal-header">
                                                    <h5 class="modal-title" id="takedown{{ $i->id }}">Takedown Slip Gaji</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                    </div>

                                                    <div class="modal-body">
                                                        <h5>Takedown pengumuman slip gaji ini ? <strong>{{ $i->periode }}</strong>
                                                        </h5>
                                                        <hr>
                                                        <button class="btn btn-info" type="submit">Takedown</button>
                                                    </div>
                                                </form>
                                            </div>
                                            </div>
                                        </div>


                                        {{-- Modal Publish --}}
                                        <div class="modal fade" id="hapus{{ $i->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                                            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <form action="/pengumuman/manage_slip_gaji/hapus_slip_gaji" method="POST" enctype="multipart/form-data"> @csrf
                                                    <input type="hidden" name="id" value="{{ $i->id }}">
                                                    <div class="modal-header">
                                                    <h5 class="modal-title" id="hapus{{ $i->id }}">Hapus Pengumuman Slip Gaji</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                    </div>

                                                    <div class="modal-body">
                                                        <h5>Hapus pengumuman slip gaji ini ? <strong>{{ $i->periode }}</strong>
                                                        </h5>
                                                        <hr>
                                                        <button class="btn btn-danger" type="submit">Hapus</button>
                                                    </div>
                                                    </div>
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
                                            {{ $slip_gaji->withQueryString()->links() }}
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>

                {{-- Modal Pengajuan Service --}}
                <div class="modal fade" id="buatPengumumanSlip" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                      <div class="modal-content">
                        <form action="/pengumuman/manage_slip_gaji/simpan_upload_data" method="POST" enctype="multipart/form-data"> @csrf
                        
                            <div class="modal-header">
                            <h5 class="modal-title" id="buatPengumumanSlip">Membuat Pengumuman Slip Gaji</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            </div>

                            <div class="modal-body">
                                <div class="container">

                                    <h5>Periode</h5>
                                    <select name="periode" class="form-control">
                                        <option value="Januari {{ date("Y") }}">Januari {{ date("Y") }}</option>
                                        <option value="Februari {{ date("Y") }}">Februari {{ date("Y") }}</option>
                                        <option value="Maret {{ date("Y") }}">Maret {{ date("Y") }}</option>
                                        <option value="April {{ date("Y") }}">April {{ date("Y") }}</option>
                                        <option value="Mei {{ date("Y") }}">Mei {{ date("Y") }}</option>
                                        <option value="Juni {{ date("Y") }}">Juni {{ date("Y") }}</option>
                                        <option value="Juli {{ date("Y") }}">Juli {{ date("Y") }}</option>
                                        <option value="Agustus {{ date("Y") }}">Agustus {{ date("Y") }}</option>
                                        <option value="September {{ date("Y") }}">September {{ date("Y") }}</option>
                                        <option value="Oktober {{ date("Y") }}">Oktober {{ date("Y") }}</option>
                                        <option value="November {{ date("Y") }}">November {{ date("Y") }}</option>
                                        <option value="Desember {{ date("Y") }}">Desember {{ date("Y") }}</option>
                                    </select>

                                    <h5>Upload File Slip Gaji</h5>
                                    <input type="file" name="slip_gaji" class="form-control" required>
                                    
                                    <hr>
                                    <button class="btn btn-info" type="submit">Simpan</button>
                                </div>
                            </div>

                            
                            
                        </form>
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

