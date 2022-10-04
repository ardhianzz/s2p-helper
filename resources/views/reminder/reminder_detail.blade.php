
@extends('layout.main') 
@include('reminder.sidebar.menu')

@section('container')
        <div class="container-fluid px-4">
            <h1 class="mt-4">{{ $title }}</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active">PT Sumber Segara Primadaya</li>
            </ol>

                <div class="content">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <h5> Detail Catatan</h5>
                            <button class="btn btn-primary" href="#" data-toggle="modal" data-target="#editdatareminder">Edit</button>
                        </div>
                        
                        <div class="box-body table-respon">
                            
                            <table class="table">
                                <tr>
                                    <td style="width:300px">Nama Catatan</td>
                                    <td>:</td>
                                    @foreach ($detail as $d)
                                        
                                    <td> {{ $d->nama }}</td>
                                    @endforeach
                                </tr>
                                <tr>
                                    <td>Berlaku</td>
                                    <td>:</td>
                                    @foreach ($detail as $d)
                                        
                                    <td> <b>Dari</b> {{ $d->from }} <b>S/d</b> {{ $d->to }}</td>
                                    @endforeach
                                </tr>
                                <tr>
                                    <td>Tanggal Expired</td>
                                    <td>:</td>
                                    @foreach ($detail as $d)
                                        
                                    <td> {{ $d->tanggal_expired }} </td>
                                    @endforeach
                                </tr>
                                <tr>
                                    <td>Tanggal Pengingat</td>
                                    <td>:</td>
                                    @foreach ($detail as $d)
                                        
                                    <td> {{ $d->tanggal_pengingat }} </td>
                                    @endforeach
                                </tr>
                                <tr>
                                    <td>Email</td>
                                    <td>:</td>
                                    @foreach ($detail as $d)
                                        
                                    <td> {{ $d->email }} </td>
                                    @endforeach
                                </tr>
                                <tr>
                                    <td>Keterangan / Deskripsi</td>
                                    <td>:</td>
                                    @foreach ($detail as $d)
                                        
                                    <td>{{ $d->keterangan }}</td>
                                    @endforeach
                                </tr>
                                    
                            </table>
                            


                        </div>
                    </div>
               </div>
            {{-- </div> --}}
        </div>

        <div class="modal fade" id="editdatareminder" tabindex="-1" role="dialog"
        aria-labelledby="editdatareminder"
        aria-hidden="true">

        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <label class="modal-title" id="editdatareminder">Edit Catatan</label>
                        <button type="button" class="btn close btn-danger" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                         </button>
                </div>
                <div class="modal-body">
                    <form action="/reminder/edit_data_reminder" method="post">
                        @csrf
                        @method("put")
                        <div class="form-group mb-4">
                            <h5 for="nama" class="mb-2">Nama Catatan *</h5>
                            <input type="text" name="nama" class="form-control" value="{{ $d->nama }}">
                        </div>
                        <div class="form-group mb-4">
                            <h5>Masa Berlaku *</h5>
                            <input type="date" name="from" class="form-control" value="{{ $d->from }}">

                            <h7 for="s/d" class="mb-2">s/d</h7>
                            <input type="date" name="to" class="form-control" value="{{ $d->to }}">
                        </div>
                        <div class="form-group mb-4">
                            <h5 for="expired" class="mb-2">Tanggal Expired *</h5>
                            <input type="date" name="tanggal_expired" class="form-control" value="{{ $d->tanggal_expired }}">
                        </div>
                        <div class="form-group mb-4">
                            <h5 for="pengingat" class="mb-2">Tanggal Pengingat *</h5>
                            <input type="date" name="tanggal_pengingat" class="form-control" value="{{ $d->tanggal_pengingat }}">
                        </div>
                        <div class="form-group mb-4">
                            <h5 for="email" class="mb-2">Email *</h5>
                            <input type="text" name="email" class="form-control" value="{{ $d->email }}">
                        </div>
                        <div class="form-group mb-4">
                            <h5 for="keterangan" class="mb-2">Keterangan / Deskripsi *</h5>
                            <input class="form-control" name="keterangan" id="" rows="3" value="{{ $d->keterangan }}">
                        </div>


                        <div class="form-group mt-5">
                            <input type="hidden" name="r_reminder_data" value="{{ $d->id }}">
                            <button class="btn col-lg-2 btn-primary btn-lg" type="submit"> Simpan </button>
                        </div>
                    </form>
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

