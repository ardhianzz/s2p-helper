
@extends('layout.main')
@include('pengumuman.sidebar.menu')

@section('container')

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

        <style>
            a{
                text-decoration: none;
                color: aliceblue;
            }
            a:hover{
                color: aliceblue;
            }
        </style>
        <div class="container-fluid px-4">
            <h1 class="mt-4">{{ $title }}</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active">{{ $sub_title }}</li>
            </ol>
            
           


            <div class="row mt-4">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <span>
                                <a href="/form/Nomor%20Rekening.xlsx">
                                    <button class="btn btn-success text-light">Form</button>
                                </a>
                                <button class="btn btn-primary text-light" data-toggle="modal" data-target="#uploadDataRekening" >Upload Data</button>
                                <button class="btn btn-info text-light" data-toggle="modal" data-target="#tambahDataRekening" >Tambah Data</button>
                            </span>

                            <span>
                                <form>
                                    <input type="search" name="cari" value="{{ request()->cari }}" autocomplete="off">
                                    <button type="submit" class="bnt btn-sm btn-dark">Cari</button>
                                </form>
                            </span>
                        </div>


                        <div class="card-body">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <td width="20px">No</td>
                                        <td width="100px">Nama</td>
                                        <td width="250px">Rekening</td>
                                        <td width="160px">Penggunaan</td>
                                        @if("tombolHapus()" == null)
                                            <td width="80px">Aksi</td>
                                        @else 
                                            <td width="20px">Aksi</td>
                                        @endif

                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($pegawai2 as $peg)
                                                {{-- Modal Edit Nomor Rekening --}}
                                                <div class="modal fade" id="editNomorRek{{ $peg->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                                                    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <form action="/pengumuman/manage_nomor_rekening/edit_nomor_rekenig" method="POST" enctype="multipart/form-data"> @csrf
                                                        
                                                            <div class="modal-header">
                                                            <h5 class="modal-title" id="editNomorRek{{ $peg->id }}">Edit Nomor Rekening</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                            </div>

                                                            <div class="modal-body">
                                                                <div class="container">
                                                                    <input class="form-control mt2 mb-2" type="text" name="nama_bank" value="{{ $peg->nama_bank }}">
                                                                    <input class="form-control mt2 mb-2" type="text" name="nama_akun" value="{{ $peg->nama_akun }}">
                                                                    <input class="form-control mt2 mb-2" type="text" name="nomor_rekening" value="{{ $peg->nomor_rekening }}">
                                                                    <input type="hidden" name="id" value="{{ $peg->id }}">
                                                                    <hr>
                                                                    <button class="btn btn-info" type="submit">Simpan</button>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                    </div>
                                                </div>
                                        <tr>
                                            <td>{{ $loop->index + $pegawai2->firstItem() }}</td>
                                            <td>{{ $peg->nama }}</td>
                                            <td> <div data-toggle="modal" data-target="#editNomorRek{{ $peg->id }}" style="color:rgb(0, 0, 110)">
                                                    <strong>{{ $peg->nama_bank }}</strong> : <i>({{  $peg->nama_akun  }}-{{$peg->nomor_rekening }})</i>
                                                </div> 
                                            </td>
                                            <td>
                                                <span hidden>{{ $data = peruntukan_rekening($peg->user_id, $peg->id) }}</span>
                                                
                                                @for ($z = 0; $z<count($data); $z++)
                                                    <span>
                                                        <button class="btn btn-sm btn-info"> 
                                                            {{ $data[$z]->nama }}
                                                        </button>  

                                                        <button class="btn btn-sm btn-danger" id="hapusPenggunaan{{ $data[$z]->id }}" onclick="toggleButton({{ $data[$z]->id }})">
                                                            <strong>
                                                                <i data-toogle="tooltip" data-placement="top" title="Hapus">-</i>
                                                            </strong>
                                                        </button>
                                                        
                                                        <button hidden 
                                                                class="btn btn-sm btn-danger" 
                                                                id="hapusPenggunaanAksi{{ $data[$z]->id }}" 
                                                                onclick="toggleButtonAksi({{ $data[$z]->id }})">
                                                                <a href="?hapusPenggunaanNomorIni={{ $data[$z]->id }}">
                                                                    <strong>Hapus</strong>
                                                                </a>
                                                        </button>
                                                        <button hidden class="btn btn-sm btn-success" id="hapusPenggunaanBatal{{ $data[$z]->id }}" onclick="toggleButtonBatal({{ $data[$z]->id }})">Batal</button>          
                                                    </span>
                                                @endfor
                                                <span>
                                                        <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#add{{ $peg->id }}"><b>+</b></button>
                                                </span>
                                            </td>

                                            <td>
                                                <span>
                                                    <button class="btn btn-sm btn-info" id="tombolHapus{{ $peg->id }}" onclick="tombolHapus({{ $peg->id }})">
                                                        <i data-toogle="tooltip" data-placement="top" title="Hapus" class="fa fa-trash"></i>
                                                        <form>
                                                            <input type="hidden" name="hapus_rekening_id" value="{{ $peg->id }}">
                                                            <button hidden class="btn btn-sm btn-danger" id="tombolHapusKonfirm{{ $peg->id }}">
                                                            <strong>Hapus</strong> 
                                                            </button>
                                                        </form>
                                                        <button hidden class="btn btn-sm btn-success" id="tombolHapusBatal{{ $peg->id }}" onclick="tombolHapusBatal({{ $peg->id }})">
                                                        <strong>Batal</strong> 
                                                        </button>
                                                    </button>
                                                </span>
                                            </td>
                                        </tr>

                                        {{-- Modal Penggunaan Rekening --}}
                                        <div class="modal fade" id="add{{ $peg->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                
                                                
                                                    <div class="modal-header">
                                                    <h5 class="modal-title" id="add{{ $peg->id }}">Tambah Penggunaan Rekening</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                    </div>

                                                    <div class="modal-body">
                                                        <div class="container">
                                                            <form action="/pengumuman/manage_nomor_rekening/tambah_penggunaan_rekening" method="POST">
                                                                @csrf
                                                                <input type="hidden" name="user_id" value="{{ $peg->user_id }}">
                                                                <input type="hidden" name="pegawai_nomor_rekening_id" value="{{ $peg->id }}">
                                                                <h5>Nomor Rekening</h5>
                                                                
                                                                <select name="pegawai_jenis_pembayaran_id" class="form-control">
                                                                    @foreach ($pembayaran as $y)
                                                                    <option value="{{ $y->id }}-{{ $y->nama }}">{{ $y->nama }}</option>
                                                                    @endforeach
                                                                </select>
                                                                <button class="btn btn-info" type="submit">Simpan</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                
                                            </div>
                                            </div>
                                        </div>
                                    @endforeach
                                   
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="4"> {{ $rekening->withQueryString()->links() }}</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

{{-- Modal Tambah Nomor Rekening Manual --}}
<div class="modal fade" id="tambahDataRekening" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content">
        <form action="/pengumuman/manage_nomor_rekening/tambah_nomor_rekenig" method="POST" enctype="multipart/form-data"> @csrf
        
            <div class="modal-header">
            <h5 class="modal-title" id="tambahDataRekening">Tambah Nomor Rekening</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>

            <div class="modal-body">
                <div class="container">
                    <select name="nik" class="form-control mb-2">
                        @foreach ($pegawai as $i)
                            <option value="{{ $i->nik }}">{{ $i->nama }}</option>
                        @endforeach
                    </select>
                    <input class="form-control mt2 mb-2" type="text" name="nama_bank" placeholder="Nama Bank" required>
                    <input class="form-control mt2 mb-2" type="text" name="nama_akun" placeholder="Nama Akun Bank" required>
                    <input class="form-control mt2 mb-2" type="text" name="nomor_rekening" placeholder="Nomor Rekening" required>
                    <hr>
                    <button class="btn btn-info" type="submit">Simpan</button>
                </div>
            </div>
        </form>
    </div>
    </div>
</div>


{{-- Modal Pengajuan Service--}}
<div class="modal fade" id="uploadDataRekening" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
      <div class="modal-content">
        <form action="/pengumuman/manage_nomor_rekening/upload_data_rekening" method="POST" enctype="multipart/form-data"> @csrf
        
            <div class="modal-header">
            <h5 class="modal-title" id="uploadDataRekening">Upload File No Rekening</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>

            <div class="modal-body">
                <div class="container">

                    <h5>Upload File No Rekening</h5>
                    <input type="file" name="no_rekening" class="form-control" required>
                    
                    <hr>
                    <button class="btn btn-info" type="submit">Simpan</button>
                </div>
            </div>

            
            
        </form>
      </div>
    </div>
</div>


<script>

    function toggleButtonBatal(id){
        document.getElementById("hapusPenggunaanBatal"+id).hidden = true;
        document.getElementById("hapusPenggunaan"+id).hidden = false;
        document.getElementById("hapusPenggunaanAksi"+id).hidden = true;
    }

    function toggleButton(id){
        document.getElementById("hapusPenggunaanBatal"+id).hidden = false;
        document.getElementById("hapusPenggunaan"+id).hidden = true;
        document.getElementById("hapusPenggunaanAksi"+id).hidden = false;
    }

    function toggleButtonAksi(id){
        document.getElementById("hapusPenggunaanBatal"+id).hidden = false;
        document.getElementById("hapusPenggunaan"+id).hidden = false;
        document.getElementById("hapusPenggunaanAksi"+id).hidden = true;
    }

    function tombolHapusBatal(id){
        document.getElementById("tombolHapusBatal"+id).hidden = true;
        document.getElementById("tombolHapus"+id).hidden = false;
        document.getElementById("tombolHapusKonfirm"+id).hidden = true;
    }

    function tampilSimpan(id){
        document.getElementById("tombolSimpan"+id).hidden = false;
    }

    function tombolHapus(id){
        document.getElementById("tombolHapus"+id).hidden = true;
        document.getElementById("tombolHapusKonfirm"+id).hidden = false;
        document.getElementById("tombolHapusBatal"+id).hidden = false;

    }
</script>

@endsection

