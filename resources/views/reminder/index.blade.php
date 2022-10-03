
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
            <div class="card-header">
                <h5>List Schedule</h5>
            </div>
            <div class="card-body table-respon">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <td width="10px">No</td>
                            <td width="150px">Name</td>
                            <td width="100px">Expired Date</td>
                            <td width="100px">Date Reminder</td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($reminder_data as $r)
                            <tr>
                                <td>{{ $r->nama }}</td>
                            </tr>
                        @endforeach
                    </tbody>
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

