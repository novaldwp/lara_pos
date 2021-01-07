@extends('layouts.app')

@section('header')
    Laporan Pembelian
@endsection

@section('title')
  Laporan Transaksi Pembelian
@endsection

@section('breadcrumb')
   @parent
   <li>Laporan</li>
   <li>Pembelian</li>
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
        <hr>
        <div class="box-body">
            <div class="col-md-12">
            <table class="table table-responsive table-hover table-striped" id="data-table">
                <thead>
                <tr>
                    <th width="5%">No</th>
                    <th>No. Transaksi</th>
                    <th>Supplier</th>
                    <th>Quantity</th>
                    <th>Subtotal</th>
                    <th>Petugas</th>
                    <th>Tanggal</th>
                    <th width="15%">Aksi</th>
                </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
            </div>
        </div>
      </div>
    </div>
  </div>
@include('report.pembelian.detail')
@endsection

@include('report.pembelian.script')
