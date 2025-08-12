<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="@if (Auth::user()->avatar != '') {{ asset('storage/' . Auth::user()->avatar) }}@else{{ URL::asset('build/dist/img/user2-160x160.jpg') }} @endif"
                    class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p>{{ Auth::user()->name }}</p>
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>
        {{-- <hr> --}}
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" data-widget="tree">
            <li class="main-utama">
                <a href="{{ route('dashboard') }}">
                    <i class="fa fa-dashboard"></i><span>Dashboard</span>
                </a>
            </li>
            <li class="header">MAIN NAVIGATION</li>
            <li
                class="treeview {{ Request::is('panel/kelas*', 'panel/pelajaran*', 'panel/tahunajaran*') ? 'active menu-open' : '' }}">
                <a href="#">
                    <i class="fa fa-cubes"></i>
                    <span>Master Data</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="{{ Request::is('panel/kelas*') ? 'active' : '' }}"><a
                            href="{{ route('kelas.index') }}"><i class="fa fa-circle-o"></i> Kelas</a></li>
                    <li class="{{ Request::is('panel/pelajaran*') ? 'active' : '' }}"><a
                            href="{{ route('pelajaran.index') }}"><i class="fa fa-circle-o"></i> Pelajaran</a></li>
                    <li class="{{ Request::is('panel/tahunajaran*') ? 'active' : '' }}"><a
                            href="{{ route('tahunajaran.index') }}"><i class="fa fa-circle-o"></i> Tahun Ajaran</a>
                    </li>
                </ul>
            </li>
            <li class="{{ Request::is('panel/siswa*') ? 'active' : '' }}">
                <a href="{{ route('siswa.index') }}"><i class="fa fa-users"></i><span>Siswa</span></a>
            </li>
            <li class="{{ Request::is('panel/ortu*') ? 'active' : '' }}">
                <a href="{{ route('ortu.index') }}"><i class="fa fa-users"></i><span>Orang Tua</span></a>
            </li>
            <li class="{{ Request::is('panel/guru*') ? 'active' : '' }}">
                <a href="{{ route('guru.index') }}"><i class="fa fa-user-secret"></i><span>Guru</span></a>
            </li>
            <li class="treeview {{ Request::is('panel/siswakelas*', 'panel/mapel*') ? 'active menu-open' : '' }}">
                <a href="#">
                    <i class="fa fa-exchange"></i>
                    <span>Relasi</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="{{ Request::is('panel/siswakelas*') ? 'active' : '' }}"><a
                            href="{{ route('siswakelas.index') }}"><i class="fa fa-circle-o"></i> Kelas Siswa</a></li>
                    <li class="{{ Request::is('panel/mapel*') ? 'active' : '' }}"><a
                            href="{{ route('mapel.index') }}"><i class="fa fa-circle-o"></i> Mapel Guru</a></li>
                </ul>
            </li>
            <li class="header">More</li>
            <li class="treeview {{ Request::is('panel/users*', 'panel/aplikasi*') ? 'active menu-open' : '' }}">
                <a href="#">
                    <i class="fa fa-gears"></i> <span>Pengaturan</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="{{ Request::is('panel/users*') ? 'active' : '' }}"><a
                            href="{{ route('users.index') }}"><i class="fa fa-circle-o"></i> Akun Pengguna</a></li>
                    <li class="{{ Request::is('panel/aplikasi*') ? 'active' : '' }}"><a
                            href="{{ route('aplikasi.index') }}"><i class="fa fa-circle-o"></i> Aplikasi</a></li>
                </ul>
            </li>
            <li>
                <a href="javascript:void();"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i
                        class="fa fa-power-off"></i><span>Keluar</span></a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </li>
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>
