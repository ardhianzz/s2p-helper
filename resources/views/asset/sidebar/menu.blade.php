@section('menu')

<nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
    <div class="sb-sidenav-menu">
        <div class="nav">
            <div class="sb-sidenav-menu-heading">Core</div>
            <a class="nav-link" href="/kendaraan">
                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                Dashboard
            </a>

            <a class="nav-link" href="/kendaraan/mobil">
                <div class="sb-nav-link-icon"><i class="fas fa-car"></i></div>
                Kendaraan
            </a>

            <a class="nav-link" href="/kendaraan/service">
                <div class="sb-nav-link-icon"><i class="fas fa-wrench"></i></div>
                Perbaikan
            </a>

            <a class="nav-link" href="/kendaraan/asuransi">
                <div class="sb-nav-link-icon"><i class="fas fa-heart"></i></div>
                Asuransi
            </a>

            <a class="nav-link" href="/kendaraan/setting">
                <div class="sb-nav-link-icon"><i class="fas fa-cogs"></i></div>
                Pengaturan
            </a>

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