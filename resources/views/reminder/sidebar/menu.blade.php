@section('menu')
{{-- @inject('pController', 'App\Http\Controllers\Pengumuman\PengumumanController') --}}

<nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
    <div class="sb-sidenav-menu">
        <div class="nav">

            <a class="nav-link {{ Request::is('reminder*') ? 'active' : ''}}" href="/reminder">
                <div class="sb-nav-link-icon"><i class="fas fa-user"></i></div>
                Dashboard
            </a>


            <a class="nav-link {{ Request::is('reminder/manage_reminder*') ? 'active' : ''}}" href="/reminder/manage_reminder">
                <div class="sb-nav-link-icon"><i class="fas fa-user"></i></div>
                Manage Reminder
            </a>

        </div>
    </div>
    <div class="sb-sidenav-footer">
        <div class="fa fa-address-card"></div>
        {{ DB::table("pegawai")->where("user_id", auth()->user()->id)->get()[0]->nama }}
    </div>
</nav>
    
@endsection