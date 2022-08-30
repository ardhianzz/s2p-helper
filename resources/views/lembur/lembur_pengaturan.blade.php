
@extends('layout.main')
@include('lembur.sidebar.menu')

@section('container')
        <div class="container-fluid px-4">
            <h1 class="mt-4">{{ $title }}</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active">PT Sumber Segara Primadaya</li>
            </ol>

            <div class="row">
                <div class="col-xl-6">
                    <div class="card mb-4">
                        <div class="card-header">
                            
                            <nav class="navbar navbar-light bg-light justify-content-between">
                                <h5 class="mb-2"> Pengaturan Approver Lembur </h5> 
                                <form class="form-inline">
                                  <input class="" type="search" placeholder="Search" aria-label="Search" name="nama">
                                  <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
                                </form>
                              </nav>
                        </div>
                        <div class="card-body">
                           <table class="table">
                                <thead>
                                    <tr>
                                        <td>Nomor</td>
                                        <td>Nama Pegawai</td>
                                        <td>Nama Manager / Approver</td>
                                        <td width="100px" align="center">Aksi</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($user as $i)
                                        <tr>
                                            <td>{{ $user->firstItem() + $loop->index }}</td>
                                            <td>{{ $i->nama }}</td>
                                            <td>
                                                @foreach ($users as $p)
                                                    @if($i->lembur_approve_id == $p->user_id) {{ $p->nama }} @endif
                                                @endforeach
                                            </td>
                                            <td width="100px" align="center">
                                                <a href="#" data-toggle="modal" data-target="#rubahData{{ $i->id }}">
                                                    <span class="material-icons">
                                                        edit
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
                                                        <h5 class="modal-title" id="rubahData{{ $i->id }}">Rubah Data Approver</h5>
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
                                                                        <option value="">--Pilih Satu---</option>
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
                                                                    Rubah
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



                <div class="col-xl-6">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5> Pengaturan Waktu Kerja </h5>
                        </div>
                        <div class="card-body">
                           <table class="table">
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
                                                <input type="submit" value="Submit" class="btn btn-dark form-control">
                                            </td>
                                        </tr>
                                    </tfoot>
                                </form>
                           </table>
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
