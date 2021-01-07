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
                    <h3>{{ $countProduk }}</h3>

                        <p>Total Produk</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-bag"></i>
                    </div>
                    <a href="{{ route('master.produk.index') }}" class="small-box-footer">Selengkapnya... <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-green">
                    <div class="inner">
                        <h3>{{ $countSupplier }}</h3>
                        <p>Total Supplier</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-person-add"></i>
                    </div>
                    <a href="{{ route('master.supplier.index') }}" class="small-box-footer">Selengkapnya... <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-yellow">
                    <div class="inner">
                        <h3>{{ $countPenjualan }}</h3>
                        <p>Total Transaksi Hari Ini</p>
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
                <div class="small-box bg-red">
                    <div class="inner">
                        <h3>{{ convert_to_rupiah($sumPenjualan) }}</h3>
                        <p>Total Pendapatan Hari Ini</p>
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
                    &nbsp;&nbsp;&nbsp; Produk Terlaris
                    <small>&nbsp;&nbsp;&nbsp;&nbsp; 5 terpilih</small>
                </div>
            </div>
            <!-- ./header -->
            <div class="box-body no-padding">
                <table class="table table-responsive table-striped">
                    <tr>
                        <th>#</th>
                        <th>Kode Produk</th>
                        <th>Nama Produk</th>
                        <th>Terjual</th>
                    </tr>
                    @php $i = 1; @endphp
                    @forelse($topProduk as $row)
                    <tr>
                        <td>{{ $i++ }}</td>
                        <td>{{ $row->produk->produk_kode }}</td>
                        <td>{{ $row->produk->produk_nama }}</td>
                        <td>{{ $row->total }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center">No Data Available.</td>
                    </tr>
                    @endforelse
                </table>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="box">
            <div class="box-header">
                <div class="box-title">
                    <i class="fa fa-user"></i>
                    &nbsp;&nbsp;&nbsp; Riwayat Transaksi Penjualan
                    <small>&nbsp;&nbsp;&nbsp;&nbsp; 5 terbaru</small>
                </div>
            </div>
            <!-- ./header -->
            <div class="box-body no-padding">
                <table class="table table-responsive table-striped">
                    <tr>
                        <th>#</th>
                        <th>Kode Transaksi</th>
                        <th>Subtotal</th>
                        <th>Quantity</th>
                        <th>Pembeli</th>
                    </tr>
                    @php $i = 1; @endphp
                    @forelse($recentPenjualan as $row)
                    <tr>
                        <td>{{ $i++ }}</td>
                        <td>{{ $row->penjualan_kode }}</td>
                        <td>{{ convert_to_rupiah($row->penjualan_total) }}</td>
                        <td>{{ $row->penjualan_detail[0]->total }}</td>
                        <td>{{ $row->member->member_nama }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center">No Data Available.</td>
                    </tr>
                    @endforelse
                </table>
            </div>
        </div>
    </div>
</div>


@endsection

