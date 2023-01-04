@section('menu')

<nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
    <div class="sb-sidenav-menu">
        <div class="nav">

            <a class="nav-link {{ Request::is('main/administrator*') ? 'active' : ''}}" href="/main/administrator">
                <div class="sb-nav-link-icon"><i class="fa fa-bullhorn"></i></div>
                Go Live Modul
            </a>

            <a class="nav-link {{ Request::is('main/aktifitas*') ? 'active' : ''}}" href="/main/aktifitas">
                <div class="sb-nav-link-icon"><i class="fa fa-child"></i></div>
                Aktivitas
            </a>

            <a class="nav-link {{ Request::is('main/mailler*') ? 'active' : ''}}" href="/main/mailler">
                <div class="sb-nav-link-icon"><i class="fa fa-envelope"></i></div>
                Pengaturan Email
            </a>
            {{-- <a class="nav-link {{ Request::is('main/tema*') ? 'active' : ''}}" href="/main/tema">
                <div class="sb-nav-link-icon"><i class="fas fa-user"></i></div>
                Pengaturan Tema
            </a> --}}

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