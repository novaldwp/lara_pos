@extends('layouts.app')

@section('header')
    Transaksi Penjualan
@endsection

@section('title')
  Transaksi Penjualan Produk
@endsection

@section('breadcrumb')
   @parent
   <li>Transaksi</li>
@endsection

@section('content')
<!-- Start of Kiri -->
<div class="row">
    <div class="col-sm-12">
        <div class="box">
            <div class="box-body">
            <!-- Content body-->
            <div class="col-sm-6">
                <!-- left column -->
                    <form class="form-horizontal">
                        <div class="form-group">
                            <label class="control-label col-sm-4">Scan Barcode [Ctrl+Q] :</label>
                            <div class="col-sm-8">
                                <input type="text" placeholder="Scan Barcode disini.." class="form-control" id="produk_kode" name="produk_kode">
                            </div>
                        </div>
                    </form>
                <!-- end of left column -->
                </div>
                <div class="col-sm-12" id="detail-cart">

                </div>
            </div>
            <!-- End of Content body-->
        </div>
    </div>
</div>
@endsection
@include('transaction.penjualan.script')
