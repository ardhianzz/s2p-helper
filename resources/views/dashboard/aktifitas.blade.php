@extends('layout.main')
@include('dashboard.sidebar.menu')

@section('container')

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
                <h5>Aktifitas User</h5>
            </div>
            <div class="card-body table-respon">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr align="center">
                            <td width="10px">No</td>
                            <td width="100px">User</td>
                            <td width="100px">IP Address</td>
                            <td width="150px">User Agent</td>
                            <td width="100px">Payload</td>
                            <td width="100px">Waktu</td>
                            <td width="100px">IP Public</td>
                            <td width="100px">Lokasi</td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $a)
                            <tr>
                                <td>{{ $loop->index+1 }}</td>
                                <td>{{ $a->nama }}</td>
                                <td>{{ $a->ip_address }}</td>
                                <td>{{ $a->user_agent }}</td>
                                <td>{{ $a->payload }}</td>
                                <td>{{ $a->last_activity }}</td>
                                <td>{{ $a->ip_public }}</td>
                                <td>{{ $a->lokasi }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="4">{{ $data->withQueryString()->links() }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection