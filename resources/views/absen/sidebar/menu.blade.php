@section('menu')

<nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
    <div class="sb-sidenav-menu">
        <div class="nav">
            <a class="nav-link {{ Request::is('absen') ? 'active' : ''}}" href="/absen">
                <div class="sb-nav-link-icon"><i class="fa fa-bar-chart"></i></div>
                Statistik Absensi
            </a>
	    <a class="nav-link {{ Request::is('absen/data_absensi_pegawai') ? 'active' : ''}}" href="/absen/data_absensi_pegawai">
                <div class="sb-nav-link-icon"><i class="fa fa-calendar"></i></div>
                Data Absensi
            </a>


            @can("absensiAdmin")
            <a class="nav-link {{ Request::is('absen_data*') ? 'active' : ''}}" href="/absen_data">
                <div class="sb-nav-link-icon"><i class="fa fa-newspaper"></i></div>
                Upload Data Absensi
            </a>
            
            <a class="nav-link {{ Request::is('absen_pengaturan*') ? 'active' : ''}}" href="/absen_pengaturan2">
                <div class="sb-nav-link-icon"><i class="fa fa-wrench"></i></div>
                Pengaturan
            </a>
            @endcan

            @can("absensiHrd")
            <a class="nav-link {{ Request::is('absen_data*') ? 'active' : ''}}" href="/absen_data">
                <div class="sb-nav-link-icon"><i class="fa fa-newspaper"></i></div>
                Upload Data Absensi
            </a>
            
            <a class="nav-link {{ Request::is('absen_pengaturan*') ? 'active' : ''}}" href="/absen_pengaturan2">
                <div class="sb-nav-link-icon"><i class="fa fa-wrench"></i></div>
                Pengaturan
            </a>
            @endcan
            
        </div>
    </div>
    <div class="sb-sidenav-footer" align="center">
        <p align="center">
            <img src="{{ foto() }}" width="100px" style="border-radius: 50%;">
        </p>
        {{ DB::table("pegawai")->where("user_id", auth()->user()->id)->get()[0]->nama }}
        {{ DB::table("users")->where("id", auth()->user()->id)->get()[0]->email }}
    </div>
</nav>
    
@endsection
