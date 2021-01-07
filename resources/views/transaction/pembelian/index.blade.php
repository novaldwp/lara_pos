@extends('layouts.app')

@section('header')
    Transaksi Pembelian
@endsection

@section('title')
  Transaksi produk
@endsection

@section('breadcrumb')
   @parent
   <li>Transaksi</li>
@endsection

@section('content')
<!-- Start of Atas -->
<div class="row">
  <div class="col-xs-12">
    <div class="box">
      <div class="box-header">
        <h4>Informasi Pembelian</h4>
        <hr>
      </div>
      <div class="box-body">
      <!-- Content body-->
    <form method="post" class="form-horizontal" enctype="multipart/form-data">
        <!-- Kiri-->
        <div class="col-md-6">
            <div class="hidden">
                <input type="hidden" name="produk_id" id="produk_id">
            </div>

            <div class="form-group">
                <label class="col-sm-4 control-label no-padding-right"> Kode Produk </label>
                <div class="col-sm-8">
                    <div class="clearfix">
                        <div class="input-group">
                            <input type="text" class="form-control" name="produk_kode" id="produk_kode" maxlength="8" pattern="[0-8]" placeholder="Kode Produk" aria-describedby="search" autocomplete="off" autofocus>
                            <span class="input-group-addon blue" id="search" style="cursor: pointer"><span class="fa fa-search" title="Pencarian Barang"></span></span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-sm-4">Nama Produk :</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" id="produk_nama" readonly>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-sm-4">Sisa Stok :</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" id="stok_jumlah" readonly>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-sm-4">Jumlah Beli :</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" id="pembelian_jumlah" name="pembelian_jumlah">
                </div>
            </div>

            <div class="form-group">
                <div class="col-sm-offset-4 col-sm-8">
                    <button class="btn btn-success col-sm-12" id="tambah" name="tambah">Tambah</button>
                </div>
            </div>

        </div>
        <!-- end of Kiri -->

        <!-- Kanan -->
        <div class="col-md-6">
            <div class="form-group">
                <label class="col-sm-4 control-label no-padding-right">No. Transaksi </label>
                <div class="col-sm-8">
                        <input type="text" class="form-control" name="pembelian_kode" id="pembelian_kode" placeholder="No. Transaksi" readonly>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-sm-4">Tanggal :</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" id="produk_tanggal" value="<?php echo date('d-m-Y'); ?>" readonly>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-sm-4">Harga Beli :</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" id="produk_beli" readonly>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-sm-4 pull-left">Supplier :</label>
                <div class="col-sm-8">
                    <select name="supplier_id" id="supplier_id" class="form-control">
                        <option value="" selected></option>
                        @foreach($supplier as $row)
                            <option value="{{ $row->supplier_id }}"> {{ $row->supplier_nama }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

        </div>
        <!-- end of Kanan -->
    </form>
      <!-- End of Content body-->
      </div>
    </div>
  </div>
</div>
<!-- End of Atas-->
<div class="tampil-detail">

</div>


<!-- End of Bawah -->

@include('transaction.pembelian.search')
@endsection
@include('transaction.pembelian.script')
