@section('menu')

<nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
    <div class="sb-sidenav-menu">
        <div class="nav">

            <a class="nav-link {{ Request::is('main/administrator*') ? 'active' : ''}}" href="/main/administrator">
                <div class="sb-nav-link-icon"><i class="fas fa-user"></i></div>
                Go Live Modul
            </a>

            <a class="nav-link {{ Request::is('main/aktifitas*') ? 'active' : ''}}" href="/main/aktifitas">
                <div class="sb-nav-link-icon"><i class="fas fa-user"></i></div>
                Aktivitas
            </a>

            {{-- <a class="nav-link {{ Request::is('main/mailler*') ? 'active' : ''}}" href="/main/mailler">
                <div class="sb-nav-link-icon"><i class="fas fa-user"></i></div>
                Pengaturan Email
            </a> --}}

        </div>
    </div>
    <div class="sb-sidenav-footer">
        <div class="fa fa-address-card"></div>
        {{ DB::table("pegawai")->where("user_id", auth()->user()->id)->get()[0]->nama }}
    </div>
</nav>
    
@endsection