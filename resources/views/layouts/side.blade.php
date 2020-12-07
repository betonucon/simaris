<ul class="sidebar-menu" data-widget="tree">
    
    <li><a href="{{url('/')}}"><i class="fa fa-home"></i>Halaman Utama</a></li>
    
    
    @if(admin()>0)
        <li class="treeview">
            <a href="#">
            <i class="fa fa-folder text-yellow"></i> <span>Otorisasi Pengguna</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
            </a>
            <ul class="treeview-menu">
                <li><a href="{{url('admin/')}}">&nbsp;<i class="fa fa-minus text-yellow"></i> Role Akses</a></li>
            </ul>
        </li>
        <li class="treeview">
            <a href="#">
            <i class="fa fa-folder text-yellow"></i> <span>Master</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
            </a>
            <ul class="treeview-menu">
                <li><a href="{{url('periode/')}}">&nbsp;<i class="fa fa-minus text-yellow"></i> Periode</a></li>
                <li><a href="{{url('kpi/')}}">&nbsp;<i class="fa fa-minus text-yellow"></i> KPI</a></li>
            </ul>
        </li>
        
    @endif

    @if(pimpinanunit()>0)
        <li class="treeview">
            <a href="#">
            <i class="fa fa-folder text-yellow"></i> <span>KPI Pimpinan</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
            </a>
            <ul class="treeview-menu">
             @foreach(unit_pimpinanunit() as $get_pin)
                <li><a href="{{url('kpi/pimpinanunit?unit='.$get_pin['unit_id'])}}">&nbsp;<i class="fa fa-minus text-yellow"></i> {{substr(cek_unit($get_pin['unit_id'])['nama'],0,25)}}</a></li>
             @endforeach
            </ul>
        </li>
    @endif

    @if(keyperson()>0)
        <li class="treeview">
            <a href="#">
            <i class="fa fa-folder text-yellow"></i> <span>KPI Keyperson</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
            </a>
            <ul class="treeview-menu">
             @foreach(unit_keyperson() as $get_key)
                <li><a href="{{url('kpi/keyperson?unit='.$get_key['unit_id'])}}">&nbsp;<i class="fa fa-minus text-yellow"></i> {{substr(cek_unit($get_key['unit_id'])['nama'],0,25)}}</a></li>
             @endforeach
            </ul>
        </li>
        <li class="treeview">
            <a href="#">
            <i class="fa fa-folder text-yellow"></i> <span>Risiko Bisnis</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
            </a>
            <ul class="treeview-menu">
             @foreach(unit_keyperson() as $get_key)
                <li><a href="{{url('risiko?unit='.$get_key['unit_id'])}}">&nbsp;<i class="fa fa-minus text-yellow"></i> {{substr(cek_unit($get_key['unit_id'])['nama'],0,25)}}</a></li>
             @endforeach
            </ul>
        </li>
        <li class="treeview">
            <a href="#">
            <i class="fa fa-folder text-yellow"></i> <span>Laporan Risiko Bisnis</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
            </a>
            <ul class="treeview-menu">
             @foreach(unit_keyperson() as $get_key)
                <li><a href="{{url('laporan_risiko?unit='.$get_key['unit_id'])}}">&nbsp;<i class="fa fa-minus text-yellow"></i> {{substr(cek_unit($get_key['unit_id'])['nama'],0,25)}}</a></li>
             @endforeach
            </ul>
        </li>
    @endif
    @if(verifikatur()>0)
        <li class="treeview">
            <a href="#">
            <i class="fa fa-folder text-yellow"></i> <span>Master </span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
            </a>
            <ul class="treeview-menu">
                <li><a href="{{url('kpi')}}">&nbsp;<i class="fa fa-minus text-yellow"></i> KPI</a></li>
            </ul>
        </li>
        <li class="treeview">
            <a href="#">
            <i class="fa fa-folder text-yellow"></i> <span>Risiko Bisnis</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
            </a>
            <ul class="treeview-menu">
                    <li><a href="{{url('risiko/verifikatur')}}">&nbsp;<i class="fa fa-minus text-yellow"></i> Risiko Bisnis</a></li>
                    <li><a href="{{url('laporan_risiko/user')}}">&nbsp;<i class="fa fa-minus text-yellow"></i> Laporan Risiko Bisnis</a></li>
            
            </ul>
        </li>
    @endif
        

</ul>