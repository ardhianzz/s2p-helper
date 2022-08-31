@section('menu')

<nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
    <div class="sb-sidenav-menu">
        <div class="nav">
            <div class="sb-sidenav-menu-heading">Menu</div>

            @can("lemburUser")
                <a class="nav-link" href="/lembur">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                    Lembur
                </a>

                <a class="nav-link" href="/lembur_settings/approver">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                    Pengaturan
                </a>

            @endcan





            



            @can("lemburApprove")
                <a class="nav-link" href="/lembur">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                    Lembur
                </a>
                <a class="nav-link" href="/lembur_approve">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                    Pengajuan Lembur
                </a>
                <a class="nav-link" href="/lembur_settings/approver">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                    Pengaturan
                </a>
            @endcan





            @can("lemburHrd")
                <a class="nav-link" href="/lembur">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                    Lembur
                </a>
                <a class="nav-link" href="/lembur_approve">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                    Pengajuan Lembur
                </a>
                <a class="nav-link" href="/lembur_approved">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                    Data Lembur
                </a>
                <a class="nav-link" href="/lembur_report">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                    Laporan
                </a>
                <a class="nav-link" href="/lembur_settings">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                    Pengaturan
                </a>        
            @endcan






            @can("lemburAdmin")
                <a class="nav-link" href="/lembur">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                    Lembur
                </a>
                <a class="nav-link" href="/lembur_approve">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                    Pengajuan Lembur
                </a>
                <a class="nav-link" href="/lembur_approved">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                    Data Lembur
                </a>
                <a class="nav-link" href="/lembur_settings">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                    Pengaturan
                </a>   
            @endcan


        </div>
    </div>
    <div class="sb-sidenav-footer">
        <div class="fa fa-address-card"></div>
        {{ DB::table("pegawai")->where("user_id", auth()->user()->id)->get()[0]->nama }}
    </div>
</nav>
    
@endsection