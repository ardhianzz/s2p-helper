
@extends('layout.main')
@include('pengumuman.sidebar.menu')

@section('container')
<style>
    a{
        text-decoration: none;
    }
</style>


<div class="container-fluid px-4">
    {{-- <div class="row">
        <h1 class="mt-4">{{ $title }}</h1>
    </div>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">PT Sumber Segara Primadaya</li>
    </ol> --}}
    <h1 class="mt-3 mb-3" style="font-size: 180px">&nbsp;</h1>

    <div class="row justify-content-center mt-3">
        <div class="col-lg-3">
            <a href="/pengumuman/kebijakan/{{ DB::table("pegawai")->where("user_id", auth()->user()->id)->get()[0]->nik }}">
                <div class="card">
                    <div class="card-header bg-primary">
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">{{ $infoPengumuman }}</span>
                        <h5><strong class="text-white">Pengumuman</strong></h5>
                    </div>
                    <div class="card-body d-flex justify-content-center">
                        <span class="fa fa-bullhorn text-primary" style="font-size: 180px"></span>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-lg-1">
            &nbsp;
        </div>

        <div class="col-lg-3">
            <a href="pengumuman/slip_gaji/{{ $nik[0]->nik }}">
                <div class="card">
                    <div class="card-header bg-primary">
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">{{ $infoGaji }}</span>
                        <h5><strong class="text-white">Slip Gaji</strong></h5>
                    </div>
                    <div class="card-body d-flex justify-content-center">
                        <span class="fa fa-credit-card text-primary" style="font-size: 180px"></span>
                    </div>
                </div>
            </a>
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

