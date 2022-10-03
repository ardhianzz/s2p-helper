
@extends('layout.main')
@include('reminder.sidebar.menu')

@section('container')
        <div class="container-fluid px-4">
            <h1 class="mt-4">{{ $title }}</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active">PT Sumber Segara Primadaya</li>
            </ol>

                <div class="content">
                    <div class="box">
                        <div class="box-header">
                            <h5> Pengajuan Lembur Hari Biasa </h5>
                        </div>
                        
                        <div class="box-body table-respom">
                            
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <td width="10px">No</td>
                                        <td width="100px">Nama Catatan</td>
                                        <td width="150px">Masa Berlaku</td>
                                        <td width="150px">Tanggal Expired</td>
                                        <td width="150px">Tanggal Pengingat </td>
                                        <td width="50px">Email</td>
                                        <td width="60px">Keterangan</td>
                                    </tr>
                                </thead>
                                    <tbody>
                                        @foreach ($detail as $d)
                                            
                                        <tr>
                                            <td>{{ $loop->index+1}}</td>
                                            <td>{{ $d->nama }}</td>
                                            <td>{{ $d->from }} <br> <b>s/d</b> <br> {{ $d->to }}</td>
                                            <td>{{ $d->tanggal_expired }}</td>
                                            <td>{{ $d->tanggal_pengingat }}</td>
                                            <td>{{ $d->email }}</td>
                                            <td>{{ $d->status }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
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

