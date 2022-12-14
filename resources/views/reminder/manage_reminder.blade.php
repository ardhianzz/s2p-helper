
@extends('layout.main')
@include('reminder.sidebar.menu')

@section('container')

<style>
    a{
        text-decoration: none;
    }
    i.icon-green
    {
    color: rgb(7, 169, 34);
    }
    i.icon-red
    {
    color: rgb(186, 5, 5);
    }
</style>
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
    <div class="row">
        <h1 class="mt-4">{{ $title }}</h1>
    </div>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">PT Sumber Segara Primadaya</li>
    </ol>

    <div class="row">
        <div class="col-xl-12">
            <div class="card mb-4 col-md-4">
                <div class="btn-group">
                    <button class="btn btn-primary btn-xs" data-toggle="modal" data-target="#buatreminder">Add Reminder </button>
                    <button class="btn btn-success btn-xs" data-toggle="modal" data-target="#uploaddata">Upload Data</button>
                </div>
            </div>
            <div class="conten">
                <div class="card">
                    <div class="nav justify-content-between card-header">
                        <h5>List Schedule</h5>
                        <form>
                            <input type="search" name="cari" placeholder="Subject.." value="{{ request()->cari }}">
                            <button type="submit" class="bnt btn-sm btn-dark">Cari</button>
                        </form>
                    </div>
                    <div class="card-body table-respon">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <td>No</td>
                                    <td>Subject</td>
                                    <td>Expired Date</td>
                                    <td>Reminder Date</td>
                                    <td>Email</td>
                                    <td>Status</td>
                                    <td>Action</td>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($reminder_data as $r)
                                <tr>
                                    <td width="10px">{{ $loop->index+1 }}</td>
                                    <td width="150px">{{ $r->nama }}</td>
                                    <td width="150px">
                                        @if ($r->tanggal_expired == null)
                                            -
                                        @elseif ($r->tanggal_expired == "1899-12-30")
                                            -
                                        @else
                                            {{ tanggl_id(($r->tanggal_expired)) }}
                                        @endif
                                    </td>
                                    <td width="150px">
                                        @if($r->pengingat == "Month")
                                        Every {{ $r->tanggal_pengingat }}th
                                        @elseif($r->pengingat == "Year") 
                                        Every {{ bulan(($r->tanggal_pengingat)) }}th
                                        @elseif($r->pengingat == "One")
                                        {{ tanggl_id(($r->tanggal_pengingat)) }} 
                                        @endif
                                    </td>
                                    <td width="100px">{{ $r->email }}</td>
                                    <td width="100px">
                                        @if($r->status == "Ongoing")
                                        Ongoing
                                        @elseif($r->status == "prosess")
                                        Finished
                                        @endif
                                    </td>
                                    <td width="120px" align="center">
                                        <a href="/reminder/manage_reminder/detail/{{ $r->id }}">
                                            <i class="material-icons" data-toogle="tooltip" data-placement="top" title="Detail"  style="font-size: 30px">
                                                info
                                            </i>
                                        </a>
                                        @if($r->status == "Ongoing")
                                            <a href="#" data-toggle="modal" data-target="#persetujuan{{ $r->id }}">
                                                <i class="material-icons icon-green" style="font-size: 30px" data-toogle="tooltip" data-placement="top" title="Process">
                                                    verified
                                                </i>
                                            </a> 
                                        @endif

                                        <a href="#" data-toggle="modal" data-target="#hapusdata{{ $r->id }}">
                                            <i class="material-icons icon-red" style="font-size: 30px" data-toogle="tooltip" data-placement="top" title="Delete">
                                                delete
                                            </i>
                                        </a>

                                        <div class="modal fade" id="hapusdata{{ $r->id }}" tabindex="-1" role="dialog"
                                            aria-labelledby="hapusdata{{ $r->id }}"
                                            aria-hidden="true">

                                                <div class="modal-dialog modal-lg" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="hapusdata{{ $r->id }}">Delete Reminder </h5>
                                                                <button type="button" class="btn close btn-danger" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form action="/reminder/hapus_data_reminder" method="POST">
                                                                @csrf
                                                                <label>Apakah Anda Yakin Ingin Menghapus Catatan {{ $r->nama }}?</label>
                                                                <input type="hidden" name="r_reminder_data" value="{{ $r->id }}">
                                                                <div class="form-group mt-5">
                                                                    <button class="btn col-lg-2 btn-primary btn-xs" type="submit"> Delete </button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                    </td>
                                </tr>

                                {{-- Button modal untuk Proccess --}}
                                <div class="modal fade" id="persetujuan{{ $r->id }}" tabindex="-1" role="dialog"
                                    aria-labelledby="persetujuan{{ $r->id }}"
                                    aria-hidden="true">

                                    <div class="modal-dialog modal-lg" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="persetujuan{{ $r->id }}">Finished Reminder</h5>
                                                    <button type="button" class="btn close btn-danger" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="/reminder/process/aksi" method="post">
                                                    @csrf
                                                    @method("put")
                                                        <div class="form-group">
                                                            <label for="keterangan" class="mb-3">Comment</label> <i>(Optional)</i> 
                                                            <textarea name="komentar" class="form-control" rows="5"></textarea>
                                                        </div>
                                                        <div class="form-group mt-3" hidden>
                                                            <input class="form-check-input" type="radio" name="status" value="prosess" checked>
                                                            <label class="form-check-label" for="inlineRadio1">Process</label>
                                                        </div>
                                                        <div class="form-group mt-5">
                                                            <input type="hidden" name="prosess_reminder_id" value="{{ $r->id }}">
                                                            <button class="btn col-lg-2 btn-primary" type="submit"> Submit </button>
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
                                    <td colspan="4">
                                        {{ $reminder_data->withQueryString()->links() }}
                                    </td>
                                </tr>
                            </tfoot>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


                        {{-- Button modal untuk Add Catatan --}}
                        <div class="modal fade" id="buatreminder" tabindex="-1" role="dialog"
                            aria-labelledby="buatreminder"
                            aria-hidden="true">

                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="buatreminder">Add Reminder</h5>
                                            <button type="button" class="btn close btn-danger" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                             </button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="/reminder/tambah_catatan" method="post">
                                            @csrf
                                            <div class="form-group mb-4">
                                                <label for="jenis" class="mb-2"> <b>Type *</b> </label>
                                                <select name="jenis" class="form-control" required>
                                                    <option value="">-- Select --</option>
                                                    <option value="General">General</option>
                                                    <option value="Birthday">Birthday</option>
                                                </select>
                                            </div>
                                            <div class="form-group mb-4">
                                                <label for="nama" class="mb-2"><b>Subject *</b></label>
                                                <input type="text" name="nama" class="form-control" placeholder="Subject" required autocomplete="off">
                                            </div>
                                            <div class="form-group mb-4">
                                                <label for="validity" class="mb-2"><b>Validity Date</b> </label> <small>(Optional)</small>
                                                <br>
                                                <small for="s/d" class="mb-2">From :</small>
                                                <input type="date" name="from" class="form-control">

                                                <small for="s/d" class="mb-2">To :</small>
                                                <input type="date" name="to" class="form-control">
                                            </div>
                                            <div class="form-group mb-4"> 
                                                <label for="expired" class="mb-2"><b>Expired Date</b> </label> <small>(Optional)</small>
                                                <input type="date" name="tanggal_expired" class="form-control">
                                            </div>
                                            <div class="form-group mb-4"> 
                                                <label for="pengingat" class="mb-2"> <b>Repeat *</b> </label>
                                                <select name="pengingat" class="form-control" required>
                                                    <option value="">-- Select --</option>
                                                    <option value="One">Never</option>
                                                    <option value="Month">Monthly</option>
                                                    <option value="Year">Yearly</option>
                                                </select>
                                            </div>
                                            <div class="form-group mb-4"> 
                                                <label for="pengingat" class="mb-2"><b>Reminder Date *</b></label>
                                                <input type="date" name="tanggal_pengingat" class="form-control" required value="{{ date("Y-m-d") }}">
                                            </div>
                                            <div class="form-group mb-4">
                                                <label for="email" class="mb-2"><b>Email *</b></label>
                                                <input type="text" name="email" class="form-control" placeholder="example@ssprimadaya.co.id" required>
                                            </div><div class="form-group mb-4">
                                                <label for="email" class="mb-2"><b>Email </b></label> <small>(Optional)</small>
                                                <input type="text" name="email_2" class="form-control" placeholder="example@ssprimadaya.co.id" >
                                            </div><div class="form-group mb-4">
                                                <label for="email" class="mb-2"><b>Email </b></label> <small>(Optional)</small>
                                                <input type="text" name="email_3" class="form-control" placeholder="example@ssprimadaya.co.id" >
                                            </div>
                                            <div class="form-group mb-4">
                                                <label for="keterangan" class="mb-2"><b>Description *</b></label>
                                                <textarea class="form-control" name="keterangan" id="" rows="3" placeholder="Description" required></textarea>
                                            </div>


                                            <div class="form-group mt-5">
                                                <button class="btn col-lg-2 btn-primary btn-lg" type="submit"> Save </button>
                                            </div>
                                        </form>
                                    </div>


                                </div>
                            </div>
                        </div>


                        {{-- Button modal untuk Add Catatan --}}
                        <div class="modal fade" id="uploaddata" tabindex="-1" role="dialog"
                            aria-labelledby="uploaddata"
                            aria-hidden="true">

                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="uploaddata">Upload Data</h5>
                                            <button type="button" class="btn close btn-danger" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                             </button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="/reminder/import" method="post" enctype="multipart/form-data">
                                            @csrf
                                            <div class="form-group mb-4">
                                                <h5 for="Upload" class="mb-2">Upload File *</h5>
                                                <input type="file" name="import" class="form-control" required>
                                            </div>
                                            
                                            <div class="form-group mt-5">
                                                <a href="/reminder/format.xlsx" class="btn col-lg-2 btn-success btn-xs">Form</a>
                                                <button class="btn col-lg-2 btn-primary btn-xs" type="submit"> Upload </button>
                                            </div>
                                        </form>
                                    </div>


                                </div>
                            </div>
                        </div>


@endsection