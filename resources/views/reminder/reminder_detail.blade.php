
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
                            <h3> Detail Catatan</h3>
                            <button class="btn btn-primary" href="#" data-toggle="modal" data-target="#editdatareminder">Edit</button>
                        </div>
                        
                        <div class="box-body table-respon">
                            
                            <table class="table">
                                <tr>
                                    <td> <b> Type </b> </td> 
                                    <td> <b>:</b> </td>
                                    @foreach ($detail as $d)
                                        
                                    <td> {{ $d->jenis }}</td>
                                    @endforeach
                                </tr>
                                <tr>
                                    <td> <b> Subject </b> </td> 
                                    <td> <b>:</b> </td>
                                    @foreach ($detail as $d)
                                        
                                    <td> {{ $d->nama }}</td>
                                    @endforeach
                                </tr>
                                <tr>
                                    <td> <b>Validity Date</b> </td>
                                    <td>:</td>
                                    @foreach ($detail as $d)
                                        @if ($d->from == null && $d->to == null)
                                            <td> - </td>
                                        @elseif ($d->from == "1899-12-30" && $d->to == "1899-12-30" )
                                            <td> - </td>
                                        @else
                                            <td>{{ tanggl_id(($d->from)) }} - {{ tanggl_id(($d->to)) }} </td>
                                        @endif
                                    @endforeach
                                </tr>
                                <tr>
                                    <td> <b>Expired Date</b> </td>
                                    <td> <b>:</b> </td>
                                    @foreach ($detail as $d)
                                        @if ($d->tanggal_expired == null)
                                            <td> - </td>
                                        @elseif ($d->tanggal_expired == "1899-12-30" )
                                            <td> - </td>
                                        @else
                                            <td> {{ tanggl_id(($d->tanggal_expired)) }} </td>
                                        @endif   
                                    @endforeach
                                </tr>
                                <tr>
                                    <td> <b>Repeat </b> </td>
                                    <td> <b>:</b> </td>
                                    @foreach ($detail as $r)
                                        
                                    <td> @if($r->pengingat == "One")
                                        Never
                                        @elseif($r->pengingat == "Month")
                                        Monthly
                                        @elseif($r->pengingat == "Year")
                                        Yearly
                                        @endif
                                    </td>
                                    @endforeach
                                </tr>
                                <tr>
                                    <td> <b>Reminder Date</b> </td>
                                    <td> <b>:</b> </td>
                                    @foreach ($detail as $r)
                                        
                                    <td> @if($r->pengingat == "Month")
                                        Every {{ $r->tanggal_pengingat }}th
                                        @elseif($r->pengingat == "Year") 
                                        Every {{ bulan(($r->tanggal_pengingat)) }}th
                                        @elseif($r->pengingat == "One")
                                        {{ tanggl_id(($r->tanggal_pengingat)) }} 
                                        @endif
                                    </td>
                                    @endforeach
                                </tr>
                                <tr>
                                    <td> <b>Email</b> </td>
                                    <td> <b>:</b> </td>
                                    @foreach ($detail as $d)
                                        
                                    <td> {{ $d->email }} </td>
                                    @endforeach
                                </tr>
                                <tr>
                                    <td> <b>Email</b> </td>
                                    <td> <b>:</b> </td>
                                    @foreach ($detail as $d)
                                        @if ($d->email_2 == null)
                                            <td> - </td>
                                        @else
                                            <td> {{ $d->email_2 }} </td>
                                        @endif
                                    @endforeach
                                </tr>
                                <tr>
                                    <td> <b>Email</b> </td>
                                    <td> <b>:</b> </td>
                                    @foreach ($detail as $d)
                                        @if ($d->email_3 == null)
                                            <td> - </td>
                                        @else
                                            <td> {{ $d->email_3 }} </td>
                                        @endif
                                    @endforeach
                                </tr>
                                <tr>
                                    <td> <b>Status</b> </td>
                                    <td> <b>:</b> </td>
                                    @foreach ($detail as $d)
                                        @if($d->status == "Ongoing")
                                        <td><b>Ongoing</b></td> 
                                        @elseif($d->status == "prosess")
                                        <td><b>Closed</b></td> 
                                        @endif
                                    @endforeach
                                </tr>

                                @if($d->status == "prosess")
                                    @if($d->komentar != null)
                                    <tr>
                                        <td> <b>Comment</b> </td>
                                        <td> <b>:</b> </td>
                                        @foreach ($detail as $d)
                                        <td>{{ $d->komentar }}</td>
                                        @endforeach
                                    </tr>
                                    @endif
                                @endif
                                <tr>
                                    <td> <b>Description</b> </td>
                                    <td> <b>:</b> </td>
                                    @foreach ($detail as $d)
                                        
                                    <td>{{ $d->keterangan }}</td>
                                    @endforeach
                                </tr>
                                <tr>
                                    <td> <b>Created At</b> </td>
                                    <td> <b>:</b> </td>
                                    @foreach ($detail as $d)
                                        
                                    <td>{{ $d->created_at }}</td>
                                    @endforeach
                                </tr>
                                <tr>
                                    <td> <b>Last Modified</b> </td>
                                    <td> <b>:</b> </td>
                                    @foreach ($detail as $d)
                                        
                                    <td>{{ $d->updated_at }}</td>
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
                    <label class="modal-title" id="editdatareminder">Edit Reminder </label>
                        <button type="button" class="btn close btn-danger" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                         </button>
                </div>
                <div class="modal-body">
                    <form action="/reminder/edit_data_reminder" method="post">
                        @csrf
                        @method("put")
                        <div class="form-group mb-4">
                            <label for="jenis" class="mb-2"> <b>Type *</b> </label>
                            <select name="jenis" class="form-control" required>
                                <option value="">-- Select --</option>
                                <option value="General" @if ($d->jenis == "General") selected @endif>General</option>
                                <option value="Birthday" @if ($d->jenis == "Birthday") selected @endif>Birthday</option>
                            </select>
                        </div>
                        <div class="form-group mb-4">
                            <h5 for="nama" class="mb-2">Subject *</h5>
                            <input type="text" name="nama" class="form-control" value="{{ $d->nama }}">
                        </div>
                        <div class="form-group mb-4">
                            <h5>Validity Date</h5>
                            <small for="s/d" class="mb-2">From :</small>
                            <input type="date" name="from" class="form-control" value="{{ $d->from }}">

                            <small for="s/d" class="mb-2">to</small>
                            <input type="date" name="to" class="form-control" value="{{ $d->to }}">
                        </div>
                        <div class="form-group mb-4">
                            <h5 for="expired" class="mb-2">Expired Date</h5>
                            <input type="date" name="tanggal_expired" class="form-control" value="{{ $d->tanggal_expired }}">
                        </div>
                        <div class="form-group mb-4"> 
                            <label for="pengingat" class="mb-2"> <b>Repeat *</b> </label>
                            <select name="pengingat" class="form-control" required>
                                <option value="">-- Select --</option>
                                <option value="One" @if ($d->pengingat == "One") selected @endif>Never</option>
                                <option value="Month" @if ($d->pengingat == "Month") selected @endif>Monthly</option>
                                <option value="Year" @if ($d->pengingat == "Year") selected @endif>Yearly</option>
                            </select>
                        </div>
                        <div class="form-group mb-4">
                            <h5 for="pengingat" class="mb-2">Reminder Date</h5>
                            <input type="date" name="tanggal_pengingat" class="form-control" value="{{ $d->tanggal_pengingat }}">
                        </div>
                        <div class="form-group mb-4">
                            <h5 for="email" class="mb-2">Email *</h5>
                            <input type="text" name="email" class="form-control" value="{{ $d->email }}">
                        </div>
                        <div class="form-group mb-4">
                            <h5 for="email" class="mb-2">Email</h5>
                            <input type="text" name="email_2" class="form-control" value="{{ $d->email_2 }}">
                        </div>
                        <div class="form-group mb-4">
                            <h5 for="email" class="mb-2">Email</h5>
                            <input type="text" name="email_3" class="form-control" value="{{ $d->email_3 }}">
                        </div>
                        <div class="form-group mb-4">
                            <h5 for="keterangan" class="mb-2">Description *</h5>
                            <textarea class="form-control" name="keterangan" id="" rows="3" value="{{ $d->keterangan }}">{{ $d->keterangan }}</textarea>
                        </div>


                        <div class="form-group mt-5">
                            <input type="hidden" name="r_reminder_data" value="{{ $d->id }}">
                            <button class="btn col-lg-2 btn-primary btn-lg" type="submit"> Save </button>
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

