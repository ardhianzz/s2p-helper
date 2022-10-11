
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
                                        @else
                                            <td> {{ tanggl_id(($d->tanggal_expired)) }} </td>
                                        @endif   
                                    @endforeach
                                </tr>
                                <tr>
                                    <td> <b>Reminder Date</b> </td>
                                    <td> <b>:</b> </td>
                                    @foreach ($detail as $d)
                                        
                                    <td> {{ tanggl_id(($d->tanggal_pengingat)) }} </td>
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

