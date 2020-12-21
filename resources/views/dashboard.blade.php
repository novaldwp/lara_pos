@extends('layouts.app')

@section('title')
  Dashboard
@endsection

@section('breadcrumb')
   @parent
   <li class="active">Dashboard</li>
@endsection


@section('content')
<!-- Start of Kiri -->
<div class="row">
    <div class="col-sm-12">
        <div class="row">
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-aqua">
                    <div class="inner">
                    {{-- <h3>{{ $jtransaksi ? "" }}</h3> --}}

                        <p>Transaksi Hari ini</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-bag"></i>
                    </div>
                    <a href="#" class="small-box-footer">Selengkapnya... <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-green">
                    <div class="inner">
                    {{-- <h3>{{ $jproduk }}</h3> --}}
                        <p>Total Produk</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-stats-bars"></i>
                    </div>
                    <a href="#" class="small-box-footer">Selengkapnya... <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-yellow">
                    <div class="inner">
                        {{-- <h3>{{ $jmember }}</h3> --}}
                        <p>Total Member</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-person-add"></i>
                    </div>
                    <a href="#" class="small-box-footer">Selengkapnya... <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-red">
                    <div class="inner">
                        {{-- <h2>{{ convert_to_rupiah($jpenjualan) }}</h2> --}}
                        <p>Penjualan Hari Ini</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-pie-graph"></i>
                    </div>
                    <a href="#" class="small-box-footer">Selengkapnya... <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
        </div>
    </div>
    <!-- end of column-->
</div>
<!-- end of row -->

<!-- /.row -->
<div class="row">
    <div class="col-sm-6">
        <div class="box">
            <div class="box-header">
                <div class="box-title">
                    <i class="fa fa-user"></i>
                    &nbsp;&nbsp;&nbsp; Produk
                    <small>&nbsp;&nbsp;&nbsp;&nbsp; 4 terbaru</small>
                </div>
            </div>
            <!-- ./header -->
            <div class="box-body no-padding">
                <table class="table table-responsive table-striped">
                    <tr>
                        <th>#</th>
                        <th>Kode Produk</th>
                        <th>Nama Produk</th>
                        <th>Harga Beli</th>
                        <th>Harga Jual</th>
                    </tr>
                    @php $i = 1; @endphp
                    {{-- @foreach($produk as $row)
                    <tr>
                        <td>{{ $i++ }}</td>
                        <td>{{ $row->produk_kode }}</td>
                        <td>{{ $row->produk_nama }}</td>
                        <td>{{ $row->produk_beli }}</td>
                        <td>{{ $row->produk_jual }}</td>
                    </tr>
                    @endforeach --}}
                </table>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="box">
            <div class="box-header">
                <div class="box-title">
                    <i class="fa fa-user"></i>
                    &nbsp;&nbsp;&nbsp; Member
                    <small>&nbsp;&nbsp;&nbsp;&nbsp; 4 terbaru</small>
                </div>
            </div>
            <!-- ./header -->
            <div class="box-body no-padding">
                <table class="table table-responsive table-striped">
                    <tr>
                        <th>#</th>
                        <th>Kode Member</th>
                        <th>Nama Member</th>
                        <th>Alamat</th>
                    </tr>
                    @php $i = 1; @endphp
                    {{-- @foreach($member as $row)
                    <tr>
                        <td>{{ $i++ }}</td>
                        <td>{{ $row->member_kode }}</td>
                        <td>{{ $row->member_nama }}</td>
                        <td>{{ $row->member_alamat }}</td>
                    </tr>
                    @endforeach --}}
                </table>
            </div>
        </div>
    </div>
</div>


@endsection

