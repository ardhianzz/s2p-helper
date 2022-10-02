@section('menu')
{{-- @inject('pController', 'App\Http\Controllers\Pengumuman\PengumumanController') --}}

<nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
    <div class="sb-sidenav-menu">
        <div class="nav">

            <a class="nav-link {{ Request::is('pengumuman') ? 'active' : ''}}" href="/pengumuman">
                <div class="sb-nav-link-icon"><i class="fas fa-user"></i></div>
                Dashboard
            </a>


            <a class="nav-link {{ Request::is('pengumuman/kebijakan*') ? 'active' : ''}}" href="/pengumuman/kebijakan/{{ DB::table("pegawai")->where("user_id", auth()->user()->id)->get()[0]->nik }}">
                <div class="sb-nav-link-icon"><i class="fas fa-user"></i></div>
                Kebijakan Perusahaan
            </a>

            <a class="nav-link {{ Request::is('pengumuman/slip_gaji*') ? 'active' : ''}}" href="/pengumuman/slip_gaji/{{ DB::table("pegawai")->where("user_id", auth()->user()->id)->get()[0]->nik }}">
                <div class="sb-nav-link-icon"><i class="fas fa-user"></i></div>
                Slip Gaji
            </a>

            @if($hak_akses == "Administrator HRD" || $hak_akses == "Administrator")
                <a class="nav-link {{ Request::is('pengumuman/manage_kebijakan*') ? 'active' : ''}}" href="/pengumuman/manage_kebijakan">
                    <div class="sb-nav-link-icon"><i class="fas fa-user"></i></div>
                    Buat Penguman
                </a>
                <a class="nav-link {{ Request::is('pengumuman/manage_slip_gaji*') ? 'active' : ''}}" href="/pengumuman/manage_slip_gaji">
                    <div class="sb-nav-link-icon"><i class="fas fa-user"></i></div>
                    Upload Slip Gaji
                </a>
            @endif

        </div>
    </div>
    <div class="sb-sidenav-footer">
        <div class="fa fa-address-card"></div>
        {{ DB::table("pegawai")->where("user_id", auth()->user()->id)->get()[0]->nama }}
    </div>
</nav>
    
@endsection