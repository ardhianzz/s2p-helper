
@extends('layout.main')
@include('lembur.sidebar.menu')

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

        <div class="container-fluid px-4">
            <h1 class="mt-4">{{ $title }}</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active">PT Sumber Segara Primadaya</li>
            </ol>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between">
                                    <div class="col-lg-3">
                                        <h5 class="mb-2"> Pengaturan Approver Lembur </h5> 
                                    </div>
                                    <div class="col-lg-3">
                                        <form class="row">
                                            <div class="col-md-9">
                                                <input class="form-control" type="search" placeholder="Search" aria-label="Search" name="nama" value="{{ request()->nama }}">
                                            </div>
                                            <div class="col-md-3">
                                                <button class="btn btn-dark text-white" type="submit">Search</button>
                                            </div>
                                        </form>
                                    </div> 
                            </div>

                            <div class="card-body">
                            <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <td>No</td>
                                            <td>Nama Pegawai</td>
                                            <td>Nama Manager / Approver</td>
                                            <td width="100px" align="center">Aksi</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($user as $i)
                                            <tr>
                                                <td width="50px">{{ $user->firstItem() + $loop->index }}</td>
                                                <td width="250px">{{ $i->nama }}</td>
                                                <td>
                                                    @foreach ($users as $p)
                                                        @if($i->lembur_approve_id == $p->user_id) {{ $p->nama }} @endif
                                                    @endforeach
                                                </td>
                                                <td width="100px" align="center">
                                                    <a href="#" data-toggle="modal" data-target="#rubahData{{ $i->id }}">
                                                        <span class="fa fa-pencil" data-toggle="tooltip" data-placement="top" title="Edit" >
                                                            
                                                        </span>
                                                    </a>
                                                </td>
                                            </tr>


                                            <div class="modal fade" id="rubahData{{ $i->id }}" tabindex="-1" role="dialog"
                                                aria-labelledby="rubahData{{ $i->id }}"
                                                aria-hidden="true">

                                                <div class="modal-dialog modal-lg" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="rubahData{{ $i->id }}">Edit Data Approver</h5>
                                                                <button type="button" class="btn close btn-danger" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form action="/lembur_settings" method="post">
                                                                @csrf
                                                                @method("put")
                                                                
                                                                    <div class="form-group mt-3">
                                                                        <select name="lembur_approve_id" class="form-control" required>
                                                                            <option value="">-- Pilih ---</option>
                                                                            @foreach ($users as $p)
                                                                                <option value="{{ $p->user_id }}" 
                                                                                    @if($i->lembur_approve_id == $p->user_id) selected @endif> {{ $p->nama }}
                                                                                </option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>

                                                                <div class="form-group mt-5">
                                                                    <input type="hidden" name="user_id" value="{{ $i->user_id }}">
                                                                    <button class="btn col-lg-2 btn-success" type="submit">
                                                                        Save
                                                                    </button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="4">{{ $user->withQueryString()->links() }}</td>
                                        </tr>
                                    </tfoot>
                            </table>
                            </div>
                        </div>
                    </div>
                </div>



                <div class="row mt-3">
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-header text-white bg-success">
                                <h5> Pengaturan Waktu Kerja </h5>
                            </div>

                            <div class="card-body">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <td>#</td>
                                            <td>Pengaturan</td>
                                            <td>Value</td>
                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <form action="/lembur/pengaturan_jam" method="post">
                                            @csrf
                                            @method("put")
                                            <tr>
                                                <td>1</td>
                                                <td>Waktu Masuk</td>
                                                <td><input type="time" name="jam_masuk" value="{{ $jam_kerja->jam_masuk }}" class="form-control"></td>
                                                
                                            </tr>
    
                                            <tr>
                                                <td>2</td>
                                                <td>Waktu Kerja</td>
                                                <td><input type="time" name="jam_kerja" value="{{ $jam_kerja->jam_kerja }}" class="form-control"></td>
                                                
                                            </tr>
    
                                            <tr>
                                                <td>3</td>
                                                <td>Edit Jam Masuk</td>
                                                <td>
                                                      <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="edit_jam_masuk" value="1" 
                                                        @if($jam_kerja->edit_jam_masuk == 1) checked @endif>
                                                        <label class="form-check-label">Aktif</label>
                                                      </div>
                                                      <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="edit_jam_masuk" value="0"
                                                        @if($jam_kerja->edit_jam_masuk == 0) checked @endif>
                                                        <label class="form-check-label">Tidak Aktif</label>
                                                      </div>
    
                                                </td>
                                                
                                            </tr>
    
                                            <tr>
                                                <td>4</td>
                                                <td>Edit Jam Kerja</td>
                                                <td>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="edit_jam_kerja" value="1"
                                                        @if($jam_kerja->edit_jam_kerja == 1) checked @endif>
                                                        <label class="form-check-label" >Aktif</label>
                                                      </div>
                                                      <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="edit_jam_kerja" value="0"
                                                        @if($jam_kerja->edit_jam_kerja == 0) checked @endif>
                                                        <label class="form-check-label" >Tidak Aktif</label>
                                                      </div>
                                                </td>
                                                
                                            </tr>
    
                                            <tr>
                                                <td>5</td>
                                                <td>Edit Jam Pulang</td>
                                                <td>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="edit_jam_pulang" value="1"
                                                        @if($jam_kerja->edit_jam_pulang == 1) checked @endif>
                                                        <label class="form-check-label">Aktif</label>
                                                      </div>
                                                      <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="edit_jam_pulang" value="0"
                                                        @if($jam_kerja->edit_jam_pulang == 0) checked @endif>
                                                        <label class="form-check-label">Tidak Aktif</label>
                                                      </div>
                                                </td>
                                                
                                            </tr>
    
                                        </tbody>
    
                                        <tfoot>
                                            <tr>
                                                <td colspan="3">
                                                    <input type="submit" value="Submit" class="btn btn-dark">
                                                </td>
                                            </tr>
                                        </tfoot>
                                    </form>
                               </table>
                            </div>
                        </div>
                    </div>


                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-header text-white bg-success">
                                <h5>Periode Lembur</h5>
                            </div>

                            <div class="card-body">
                                <form action="/lembur_settings/add_user_periode" method="POST">
                                    @csrf
                                    <div class="form-group mb-3">
                                        <label for="">Nama Pegawai</label>
                                        <select name="user_id" class="form-control">
                                            <option value="">--PILIH SATU--</option>
                                            @foreach ( $users as $d)
                                                <option value="{{ $d->user_id }}">{{ $d->nama }}</option>
                                            @endforeach
                                        </select>
                                    </div>
    
                                    <div class="form-gropu mb-3">
                                        <label for="">Periode</label>
                                        <select name="periode" class="form-control" required>
                                            <option value="" selected>--PILIH SATU--</option>
                                            <option value="Januari {{ date('Y') }}">Januari {{ date('Y') }}</option>
                                            <option value="Februari {{ date('Y') }}">Februari {{ date('Y') }}</option>
                                            <option value="Maret {{ date('Y') }}">Maret {{ date('Y') }}</option>
                                            <option value="April {{ date('Y') }}">April {{ date('Y') }}</option>
                                            <option value="Mei {{ date('Y') }}">Mei {{ date('Y') }}</option>
                                            <option value="Juni {{ date('Y') }}">Juni {{ date('Y') }}</option>
                                            <option value="Juli {{ date('Y') }}">Juli {{ date('Y') }}</option>
                                            <option value="Agustus {{ date('Y') }}">Agustus {{ date('Y') }}</option>
                                            <option value="September {{ date('Y') }}">September {{ date('Y') }}</option>
                                            <option value="Oktober {{ date('Y') }}">Oktober {{ date('Y') }}</option>
                                            <option value="November {{ date('Y') }}">November {{ date('Y') }}</option>
                                            <option value="Desember {{ date('Y') }}">Desember {{ date('Y') }}</option>
                                        </select>
                                    </div>
    
                                    <div>
                                        <button class="btn btn-dark text-light" type="submit">Submit</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>


            <div class="row mt-3">
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header text-white bg-primary">
                            <h5>Pengaturan Tambahan Jam Masuk</h5>
                        </div>

                        <div class="card-body">
                            <form action="/lembur_settings/add_setting_group" method="POST">
                                @csrf
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <td>Deskripsi Peraturan</td>
                                            <td>Jabatan</td>
                                            <td>Aksi</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($setting_tambahan as $i)    
                                            <tr>
                                                <td>{{ $i->nama_pengaturan }}</td>
                                                <td>{{ $i->pegawai_jabatan_id }}</td>
                                                <td>rubah</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            
        </div>

@endsection

