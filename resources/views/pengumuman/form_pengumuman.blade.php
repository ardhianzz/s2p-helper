
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
                    <div class="card">
                        <div class="card-body">
                           <form action="/pengumuman/manage_kebijakan/membuat_pengumuman_baru" method="POST">
                            @csrf

                            <button type="submit">simpan</button>
                            </form>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>

@endsection

