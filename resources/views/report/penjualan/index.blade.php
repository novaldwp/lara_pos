@extends('layouts.app')

@section('header')
    Laporan Penjualan
@endsection

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
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label pull-left">Periode :</label>
                    <div class="col-sm-3">
                        <select name="period" id="period" class="form-control">
                                <option value="" selected> Semua</option>
                                <option value="day"> Harian</option>
                                <option value="month"> Bulanan</option>
                                <option value="year"> Tahunan</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group pull-right">
                    <label for="" class="control-label">Export: &nbsp;&nbsp;&nbsp;</label>
                    <a href="javascript:void(0);" id="toPDF" class="btn btn-danger">
                        <i class="fa fa-file-pdf-o"></i>
                        &nbsp;&nbsp; PDF
                    </a>
                </div>
            </div>
        </div>
        <hr style="margin-top:0px; margin-bottom:10px;">
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
