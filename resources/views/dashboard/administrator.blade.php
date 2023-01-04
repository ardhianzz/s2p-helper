@extends('layout.main')
@include('dashboard.sidebar.menu')

@section('container')


<div class="container-fluid px-4">
    <div class="row">
      <h1 class="mt-4">Pengaturan Go Live Aplikasi</h1>
    </div>
    <ol class="breadcrumb mb-4">
      <li class="breadcrumb-item active">PT Sumber Segara Primadaya</li>
    </ol>

    <div class="conten">
      <div class="card">
        <div class="card-header">
          <h5>Aktifasi Modul</h5>
        </div>
  
        <div class="card-body table-respo">
            <form>
              <table class="table table-bordered table-striped">
                <thead>
                <tr>
                  <td>Nama Modul</td>
                  <td>Status</td>
                </tr>
              </thead>
              
              <tbody>
                @foreach ($modul as $i)
                <tr>
                  <td>{{ $i->nama }}</td>
                  <td>
                    <select name="keterangan[]" class="form-control">
                      <option value="">-- Pilih Satu --</option>
                      <option @if($i->keterangan == "Aktif") selected @endif value="Aktif">Aktif</option>
                      <option @if($i->keterangan == "Tidak Aktif") selected @endif value="Tidak Aktif">Tidak Aktif</option>
                      <input type="hidden" name="id[]" value="{{ $i->id }}">
                    </select>
                  </td>
                </tr>
                @endforeach
              </tbody>
              
              <tfoot>
                <tr>
                  <td colspan="2">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                  </td>
                </tr>
              </tfoot>
            </form>
          </table>
        </div>
      </div>
    </div>
</div>


@endsection