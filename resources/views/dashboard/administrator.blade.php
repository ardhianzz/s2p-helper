@extends('layout.main')
@include('dashboard.sidebar.menu')

@section('container')
<h1>Pengaturan Go Live Aplikasi</h1>
<div class="row">
  <div class="container mt-3">
    <div class="col-lg-6">
      <div class="card">
        <div class="card-header">
          <h5>Aktifasi Modul</h5>
        </div>
  
        <div class="card-body">
            <form>
              <table class="table">
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
</div>


@endsection