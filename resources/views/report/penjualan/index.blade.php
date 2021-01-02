@extends('layouts.app')

@section('title')
  Laporan Transaksi Penjualan
@endsection

@section('breadcrumb')
   @parent
   <li>Laporan</li>
   <li>Penjualan</li>
@endsection

@section('content')
<div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header">
            <div class="form-group">
                <label class="control-label col-sm-1 pull-left">Periode :</label>
                <div class="col-sm-2">
                    <select name="period" id="period" class="form-control">
                        {{-- <option value="" selected></option> --}}
                            <option value="" selected> Semua</option>
                            <option value="day"> Harian</option>
                            <option value="month"> Bulanan</option>
                            <option value="year"> Tahunan</option>
                    </select>
                </div>
            </div>
        </div>
        <hr>
        <div class="box-body">
            <div class="col-md-12">
            <table class="table table-responsive table-hover table-striped" id="data-table">
                <thead>
                <tr>
                    <th width="5%">No</th>
                    <th>No. Transaksi</th>
                    <th>Pembeli</th>
                    <th>Quantity</th>
                    <th>Tanggal</th>
                    <th>Petugas</th>
                    <th>Subtotal</th>
                    <th width="15%">Aksi</th>
                </tr>
                </thead>
                <tbody>
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="5"></th>
                        <th>Total Penjualan</th>
                        <th><p class="total"></p></th>
                    </tr>
                </tfoot>
            </table>
            </div>
        </div>
      </div>
    </div>
  </div>
@include('report.penjualan.detail')
@endsection

@include('report.penjualan.script')
