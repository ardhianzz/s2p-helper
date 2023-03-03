
@extends('layout.main')
@include('reminder.sidebar.menu')

@section('container')
<style>
    a{
        text-decoration: none;
    }
</style>


<div class="container-fluid px-4">
    <div class="row">
        <h1 class="mt-4">{{ $title }}</h1>
    </div>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">PT Sumber Segara Primadaya</li>
    </ol>
    
    <div class="conten">
        <div class="card">
            <div class="nav justify-content-between card-header">
                <h5>List Schedule</h5>
                <div class="col-lg-3">
                    <form class="row">
                        <div class="col-md-8" style="padding-right: 0px">
                            <input class="form-control" type="search" placeholder="Subject.." aria-label="Subject.." name="cari" value="{{ request()->cari }}">
                        </div>
                        <div class="col-md-3">
                            <button class="btn btn-dark text-white" type="submit">Search</button>
                        </div>
                    </form>
                </div> 
            </div>
            <div class="card-body table-respon">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr align="center">
                            <td width="10px">No</td>
                            <td width="200px">Subject</td>
                            <td width="150px">Expired Date</td>
                            <td width="150px">Reminder Date</td>
                            <td width="100px">Email</td>
                            <td width="100px">Divisi</td>
                            <td width="100px">Created</td>
                            <td width="50px">Action</td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($reminder_data as $r)
                            <tr>
                                <td align="center">{{ $loop->index+1 }}</td>
                                <td>{{ $r->nama }}</td>
                                <td>
                                    @if ($r->tanggal_expired == null)
                                        -
                                    @elseif ($r->tanggal_expired == "1899-12-30")
                                        -
                                    @else
                                    {{ tanggl_id(($r->tanggal_expired)) }}
                                    @endif
                                </td>
                                <td>@if($r->pengingat == "Month")
                                    Every {{ $r->tanggal_pengingat }}th
                                    @elseif($r->pengingat == "Year") 
                                    Every {{ bulan(($r->tanggal_pengingat)) }}th
                                    @elseif($r->pengingat == "One")
                                    {{ tanggl_id(($r->tanggal_pengingat)) }} 
                                    @endif
                                </td>
                                <td>{{ $r->email }}</td>
                                <td align="center">{{ $r->pegawai_divisi->nama }}</td>
                                <td>{{ $r->user->pegawai->nama }}</td>
                                <td width="50px" align="center">
                                    <a href="/reminder/divisi/detail/{{ $r->id }}" >
                                        <i class="material-icons" data-toogle="tooltip" data-placement="top" title="Detail"  style="font-size: 30px">
                                            info
                                        </i>
                                    </a>
                                </td>
                            </tr>
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

