{{-- variable for master session --}}
@php
    $nav_dashboard = ""; $nav_master = ""; $nav_user = ""; $nav_member = ""; $nav_stok = ""; $nav_transaksi = "";

@endphp

{{-- session nav active --}}
@switch(Session::get('nav_active'))
    @case("dashboard")
        @php $nav_dashboard = 'active ' @endphp
        @break
    @case("master")
        @php $nav_master = 'active ' @endphp
        @break
    @case("user")
        @php $nav_user = 'active ' @endphp
        @break
    @case("member")
        @php $nav_member = 'active ' @endphp
        @break
    @case("stok")
        @php $nav_stok = 'active ' @endphp
        @break
    @case("transaksi")
        @php $nav_transaksi = 'active ' @endphp
        @break
@endswitch
{{-- end session nav active --}}

{{-- variable for open treeview --}}
@php
    $sub_master_kategori = ""; $sub_master_supplier = ""; $sub_master_produk = "";
    $sub_transaksi_pembelian = ""; $sub_transaksi_penjualan = "";
@endphp

{{-- session sub active --}}
@switch(Session::get('sub_active'))
    @case("kategori")
        @php $sub_master_kategori = 'active' @endphp
        @break
    @case("supplier")
        @php $sub_master_supplier = 'active' @endphp
        @break
    @case("produk")
        @php $sub_master_produk = 'active' @endphp
        @break
    @case("pembelian")
        @php $sub_transaksi_pembelian = 'active' @endphp
        @break
    @case("penjualan")
        @php $sub_transaksi_penjualan = 'active' @endphp
        @break
@endswitch
{{-- end session sub active --}}

<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="{{ asset('adminLTE/dist/img/user2-160x160.jpg') }}" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p>{{ auth::user()->name }}</p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>
      <!-- search form -->
      <form action="#" method="get" class="sidebar-form">
        <div class="input-group">
          <input type="text" name="q" class="form-control" placeholder="Search...">
          <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
        </div>
      </form>
      <!-- /.search form -->
      <!-- sidebar menu: : style can be found in sidebar.less -->

      <!-- Navigation start -->
      <ul class="sidebar-menu" data-widget="tree">
        <!-- if role = admin -->
        @if (Auth::user()->level == 1)
        <li class="{{ $nav_dashboard }}">
            <a href="/">
                <i class="fa fa-dashboard"></i>
                <span>Dashboard</span>
            </a>
        </li>


        <li class="{{ $nav_master }} treeview">
            <a href="#">
                <i class="fa fa-folder"></i> <span>Master</span>
                <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                </span>
            </a>
            <ul class="treeview-menu">
                <li class="{{ $sub_master_kategori }}">
                    <a href="{{ route('kategori.index') }}">
                        <i class="fa fa-circle-o"></i>
                        Kategori
                    </a>
                </li>
                <li class="{{ $sub_master_supplier }}">
                    <a href="{{ route('supplier.index') }}">
                        <i class="fa fa-circle-o"></i>
                        Supplier
                    </a>
                </li>
                <li class="{{ $sub_master_produk }}">
                    <a href="{{ route('produk.index') }}">
                        <i class="fa fa-circle-o"></i>
                        Produk
                    </a>
                </li>
            </ul>
        </li>

        <li class="{{ $nav_stok }} ">
            <a href="{{ route('stok.index') }}">
                <i class="fa fa-suitcase"></i>
                <span>Stok</span>
            </a>
        </li>

        <li class="{{ $nav_transaksi }} treeview">
            <a href="#">
                <i class="fa fa-shopping-cart"></i> <span>Transaksi</span>
                <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                </span>
            </a>
            <ul class="treeview-menu">
                <li class="{{ $sub_transaksi_penjualan }}">
                    <a href="{{ route('penjualan.index') }}">
                        <i class="fa fa-circle-o"></i>
                        Penjualan
                    </a>
                </li>
                <li class="{{ $sub_transaksi_pembelian }}">
                    <a href="{{ route('pembelian.index') }}">
                        <i class="fa fa-circle-o"></i>
                        Pembelian
                    </a>
                </li>
            </ul>
        </li>

        <li class="{{ $nav_member }} ">
            <a href="{{ route('member.index') }}">
                <i class="fa fa-user-plus"></i>
                <span>Member</span>
            </a>
        </li>

        <li class="{{ $nav_user }} ">
            <a href="{{ route('user.index') }}">
                <i class="fa fa-user"></i>
                <span>User</span>
            </a>
        </li>

        @endif
        <!-- end if role = admin -->
      </ul>
      <!-- Navigation End -->
    </section>
    <!-- /.sidebar -->
  </aside>
