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
            <li class="treeview {{ Request::is('panel/kategori*') ? 'active menu-open' : '' }}">
                <a href="#">
                    <i class="fa fa-cubes"></i>
                    <span>Master Data</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="{{ Request::is('panel/kategori*') ? 'active' : '' }}"><a
                            href="{{ route('kategori.index') }}"><i class="fa fa-circle-o"></i> Kategori</a></li>
                </ul>
            </li>
            <li class="{{ Request::is('panel/pengumuman*') ? 'active' : '' }}">
                <a href="{{ route('pengumuman.index') }}"><i class="fa fa-bullhorn"></i><span>Pengumuman</span></a>
            </li>
            <li class="header">More</li>
            <li class="treeview {{ Request::is('panel/halaman*', 'panel/menu*') ? 'active menu-open' : '' }}">
                <a href="#">
                    <i class="fa fa-television"></i> <span>Modul</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="{{ Request::is('panel/halaman*') ? 'active' : '' }}"><a
                            href="{{ route('halaman.index') }}"><i class="fa fa-circle-o"></i> Halaman</a></li>
                    <li class="{{ Request::is('panel/menu*') ? 'active' : '' }}"><a
                            href="{{ route('menu.index') }}"><i class="fa fa-circle-o"></i>
                            Menu</a></li>
                </ul>
            </li>
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
