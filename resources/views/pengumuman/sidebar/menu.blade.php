@section('menu')
{{-- @inject('pController', 'App\Http\Controllers\Pengumuman\PengumumanController') --}}

<nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
    <div class="sb-sidenav-menu">
        <div class="nav">

            <a class="nav-link {{ Request::is('pengumuman') ? 'active' : ''}}" href="/pengumuman">
                <div class="sb-nav-link-icon"><i class="fas fa-tachometer"></i></div>
                Dashboard
            </a>


            <a class="nav-link {{ Request::is('pengumuman/kebijakan*') ? 'active' : ''}}" href="/pengumuman/kebijakan/{{ DB::table("pegawai")->where("user_id", auth()->user()->id)->get()[0]->nik }}">
                <div class="sb-nav-link-icon"><i class="fas fa-user"></i></div>
                @if(pengumuman_belum_dibuka(auth()->user()->id) > 0)
                    <span class="position-flex top-0 start-100 translate-middle badge rounded-pill bg-danger">{{ pengumuman_belum_dibuka(auth()->user()->id) }}</span>
                @endif
                Pengumuman
            </a>

            <a class="nav-link {{ Request::is('pengumuman/slip_gaji*') ? 'active' : ''}}" href="/pengumuman/slip_gaji/{{ DB::table("pegawai")->where("user_id", auth()->user()->id)->get()[0]->nik }}">
                <div class="sb-nav-link-icon"><i class="fa fa-university"></i></div>
                @if(gaji_belum_dibuka(auth()->user()->id) > 0)
                    <span class="position-flex top-5 start-100 translate-middle badge rounded-pill bg-danger">{{ gaji_belum_dibuka(auth()->user()->id) }}</span>
                @endif
                Slip Gaji
            </a>

            @if(hrd())
                <a class="nav-link {{ Request::is('pengumuman/manage_kebijakan*') ? 'active' : ''}}" href="/pengumuman/manage_kebijakan">
                    <div class="sb-nav-link-icon"><i class="fas fa-cogs"></i></div>
                    Manage Pengumuman
                </a>
                @if(hrdcilacap())
                    <a class="nav-link {{ Request::is('pengumuman/manage_slip_gaji*') ? 'active' : ''}}" href="/pengumuman/manage_slip_gaji">
                        <div class="sb-nav-link-icon"><i class="fas fa-cogs"></i></div>
                        Manage Slip Gaji
                    </a>

                    <a class="nav-link {{ Request::is('pengumuman/manage_nomor_rekening*') ? 'active' : ''}}" href="/pengumuman/manage_nomor_rekening">
                        <div class="sb-nav-link-icon"><i class="fas fa-cogs"></i></div>
                        Manage Rekening Gaji
                    </a>
                @endif
            @endif

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