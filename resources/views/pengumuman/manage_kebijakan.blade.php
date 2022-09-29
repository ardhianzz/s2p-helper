
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
                                <button class="btn btn-dark text-light">Pengajuan Perbaikan</button>
                            </a>


                            <form>
                                <input type="search" name="cari" value="{{ request()->cari }}">
                                <button type="submit" class="bnt btn-sm btn-dark">Cari</button>
                            </form>
                        </div>
                        <div class="card-body">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <td>No</td>
                                        <td>Nama Mobil</td>
                                        <td>No Polisi</td>
                                        <td>Nama Bengkel</td>
                                        <td>Biaya Service</td>
                                        <td>Driver PIC</td>
                                        <td>Jenis Service</td>
                                        <td>Status Perbaikan</td>
                                    </tr>
                                </thead>
                                <tbody>
                                   
                                    <tr>
                                        
                                    </tr>
                                    
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td>
                                            
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
                <div class="modal fade" id="tambahPengajuanService" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="tambahPengajuanService">Tambah Pengajuan Service</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
        
                        gf
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

