@extends('layout.main')
@include('dashboard.sidebar.menu')

@section('container')
<h1>Pengaturan Email</h1>
<div class="row">
  <div class="container mt-3">
    <div class="row">
    <div class="col-lg-6">
      <div class="card">
        <div class="card-header">
          <h5>Mailer System</h5>
        </div>
  
        <div class="card-body">
            <form>
              <div class="row mt-1 mb-2">
                <div class="col-lg-3">Akun</div>
                <div class="col-lg-1">:</div>
                <div class="col-lg-8"><input type="text" class="form-control" name="server_account"></div>
              </div>

              <div class="row mt-1 mb-2">
                <div class="col-lg-3">Outgoing Server</div>
                <div class="col-lg-1">:</div>
                <div class="col-lg-8"><input type="text" class="form-control" name="server_outgoing"></div>
              </div>

              <div class="row mt-1 mb-2">
                <div class="col-lg-3">Outgoing Port</div>
                <div class="col-lg-1">:</div>
                <div class="col-lg-8"><input type="number" class="form-control" name="server_port"></div>
              </div>

              <div class="row mt-1 mb-2">
                <div class="col-lg-3">Use SSL</div>
                <div class="col-lg-1">:</div>
                <div class="col-lg-8">
                  <select name="use_ssl" class="form-control">
                    <option value="1" selected>YES</option>
                    <option value="0">NO</option>
                  </select>
                </div>
              </div>

              <div class="row mt-1 mb-2">
                <button type="submit" class="form-control btn btn-info">Simpan</button>
              </div>
            </form>
        </div>
      </div>
    </div>

    <div class="col-lg-5">
      <div class="card">
        <div class="card-header">
          Tets Akun
        </div>

        <div class="card-body">
          <form>
            <div class="row mt-1 mb-2">
              <div class="col-lg-3">Test Akun</div>
              <div class="col-lg-1">:</div>
              <div class="col-lg-8"><input type="text" class="form-control" name="server_account" required></div>
            </div>

            <div class="row mt-1 mb-2">
              <button type="submit" name="test" class="form-control btn btn-primary">Test</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  </div>
</div>


@endsection