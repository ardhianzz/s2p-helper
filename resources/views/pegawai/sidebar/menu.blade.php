@section('menu')

<nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
    <div class="sb-sidenav-menu">
        <div class="nav">

            {{-- <a class="nav-link {{ Request::is('pegawai*') ? 'active' : ''}}" href="/pegawai">
                <div class="sb-nav-link-icon"><i class="fas fa-user"></i></div>
                Pegawai
            </a> --}}

            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#pegawai" aria-expanded="false" aria-controls="pegawai">
                <div class="sb-nav-link-icon"><i class="fas fa-user"></i></div>
                Pegawai
                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
            </a>

            <div class="collapse 
            {{ Request::is('pegawai/jakarta*') ? 'show' : ''}}
            {{ Request::is('pegawai/cilacap*') ? 'show' : ''}}
            " 
            id="pegawai" aria-labelledby="headingOne" 
                data-bs-parent="#sidenavAccordion">
                <nav class="sb-sidenav-menu-nested nav">
                    <a class="nav-link {{ Request::is('pegawai/jakarta') ? 'active' : ''}}" href="/pegawai/jakarta">Jakarta</a>
                    <a class="nav-link {{ Request::is('pegawai/cilacap') ? 'active' : ''}}" href="/pegawai/cilacap">Cilacap</a>
                </nav>
            </div>



            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#organisasi" aria-expanded="false" aria-controls="organisasi">
                <div class="sb-nav-link-icon"><i class="fa fa-institution"></i></div>
                Organisasi
                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
            </a>

            <div class="collapse
            {{ Request::is('jabatan*') ? 'show' : ''}}
            {{ Request::is('divisi*') ? 'show' : ''}}
            " id="organisasi" aria-labelledby="headingOne" 
                data-bs-parent="#sidenavAccordion">
                <nav class="sb-sidenav-menu-nested nav">
                    <a class="nav-link {{ Request::is('divisi*') ? 'active' : ''}}" href="/divisi">Divisi</a>
                    <a class="nav-link {{ Request::is('jabatan*') ? 'active' : ''}}" href="/jabatan">Jabatan</a>
                </nav>
            </div>

            @if(isJakarta())
            {{-- <a class="nav-link {{ Request::is('hak_akses*') ? 'active' : ''}}" href="/hak_akses">
                <div class="sb-nav-link-icon"><i class="fa fa-wrench"></i></div>
                Hak Akses
            </a> --}}

            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#hak" aria-expanded="false" aria-controls="pegawai">
                <div class="sb-nav-link-icon"><i class="fa fa-wrench"></i></div>
                Hak Akses
                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
            </a>

            <div class="collapse
            {{ Request::is('hak_akses/administrator*') ? 'show' : ''}}
            {{ Request::is('hak_akses/hrd*') ? 'show' : ''}}
            {{ Request::is('hak_akses/approver*') ? 'show' : ''}}
            {{ Request::is('hak_akses/user_jakarta*') ? 'show' : ''}}
            {{ Request::is('hak_akses/user_cilacap*') ? 'show' : ''}}" 
            id="hak" aria-labelledby="headingOne" 
                data-bs-parent="#sidenavAccordion">
                <nav class="sb-sidenav-menu-nested nav">
                    <a class="nav-link {{ Request::is('hak_akses/administrator') ? 'active' : ''}}" href="/hak_akses/administrator">Administrator</a>
                    <a class="nav-link {{ Request::is('hak_akses/hrd') ? 'active' : ''}}" href="/hak_akses/hrd">HRD</a>
                    <a class="nav-link {{ Request::is('hak_akses/approver') ? 'active' : ''}}" href="/hak_akses/approver">Approver</a>
                    <a class="nav-link {{ Request::is('hak_akses/user_jakarta') ? 'active' : ''}}" href="/hak_akses/user_jakarta">User Jakarta</a>
                    <a class="nav-link {{ Request::is('hak_akses/user_cilacap') ? 'active' : ''}}" href="/hak_akses/user_cilacap">User Cilacap</a>
                </nav>
            </div>
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