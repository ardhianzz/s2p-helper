
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
                                <button class="btn btn-dark text-light" data-toggle="modal" data-target="#uploadDataRekening" >Upload Data</button>
                            </span>


                            <form>
                                <input type="search" name="cari" value="{{ request()->cari }}">
                                <button type="submit" class="bnt btn-sm btn-dark">Cari</button>
                            </form>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                {{-- <form> @csrf --}}
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <td>No</td>
                                            <td>Nama</td>
                                            <td>NIK</td>
                                            <td>Nama Bank</td>
                                            <td>Nama Akun Bank</td>
                                            <td>Nama Rekenig</td>
                                            <td>Penggunaan</td>
                                            <td>Aksi</td>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach ($rekening as $i)    
                                            <tr>
                                                <td>{{ $loop->index + $rekening->firstItem() }}</td>
                                                <td>
                                                    {{-- {{ dd($pegawai[0]['nik']) }} --}}
                                                    @for ($p=0 ; $p<count($pegawai) ; $p++)
                                                        @if($pegawai[$p]['nik'] == $i->nik)
                                                            {{ $pegawai[$p]['nama'] }}
                                                        @endif
                                                    @endfor
                                                    
                                                   
                                                </td>
                                                <td>{{ $i->nik }}</td>
                                                <td>{{ $i->nama_bank }}</td>
                                                <td>{{ $i->nama_akun }}</td>
                                                <td>{{ $i->nomor_rekening }}</td>
                                                <td>
                                                    <form id="rubahPenggunaan">
                                                        <span class="d-flex">

                                                        
                                                        <select name="pegawai_jenis_pembayaran_id" class="form-control" onchange="tampilSimpan({{ $i->id }})">
                                                            <option value="0" @if($i->pegawai_penggunaan_nomor_rekening->count() == 0) selected @endif>-- Belum Ditentukan --</option>
                                                            @foreach ($pembayaran as $pay)
                                                                <option value="{{ $pay->id }}"
                                                                    @if(count($i->pegawai_penggunaan_nomor_rekening) >= 1)
                                                                        @if($i->pegawai_penggunaan_nomor_rekening[0]->pegawai_jenis_pembayaran->nama == $pay->nama)
                                                                        selected
                                                                        @endif
                                                                    @endif
                                                                    >{{ $pay->nama }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        <input type="hidden" name="pegawai_nomor_rekening_id" value="{{ $i->id }}">
                                                        <button class="btn btn-primary" type="submit" hidden id="tombolSimpan{{ $i->id }}">Simpan</button>
                                                    </span> 
                                                    </form>
                                                </td>
                                                <td>
                                                    <span>
                                                        <button class="btn btn-warning" id="tombolHapus{{ $i->id }}" onclick="tombolHapus({{ $i->id }})">Hapus</button>
                                                        <form>
                                                            <input type="hidden" name="hapus_rekening_id" value="{{ $i->id }}">
                                                            <button hidden class="btn btn-danger" type="submit" id="tombolHapusKonfirm{{ $i->id }}">Hapus</button>
                                                            <button hidden class="btn btn-success" id="tombolHapusBatal{{ $i->id }}" onclick="tombolHapusBatal({{ $i->id }})">Batal</button>
                                                        </form>
                                                    </span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="8">
                                                <div class="row d-flex justify-content-between">
                                                    <div class="col-md-6">

                                                        <span>
                                                            {{ $rekening->withQueryString()->links() }}
                                                        </span>
                                                    </div>
                                                    
                                                </div>
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            {{-- </form> --}}


                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>

{{-- Modal Pengajuan Service --}}
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
    function tombolHapusBatal(id){
        
        document.getElementById("tombolHapusBatal"+id).hidden = false;
        document.getElementById("tombolHapus"+id).hidden = true;
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

