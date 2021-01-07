@extends('layouts.app')

@section('header')
    Supplier
@endsection

@section('title')
  Daftar Data Supplier
@endsection

@section('breadcrumb')
   @parent
   <li>Master</li>
   <li>Supplier</li>
@endsection

@section('content')
<div class="row">
  <div class="col-xs-12">
    <div class="box">
      <div class="box-header">
        <a href="javascript:void(0);" id="modal_button" name="modal_button" class="btn btn-success"><i class="fa fa-plus-circle"></i> Tambah</a>
      </div>
      <div class="box-body">
        <table class="table table-responsive table-hover table-striped" id="data-table">
          <thead>
            <tr>
                <th width="5%">No</th>
                <th>Nama Supplier</th>
                <th>Kontak</th>
                <th>No. Telpon</th>
                <th>Alamat Supplier</th>
                <th width="15%">Aksi</th>
            </tr>
          </thead>
        </table>
      </div>
    </div>
  </div>
</div>

@include('master.supplier.form')
@endsection

@section('script')
@include('master.supplier.script')
@endsection
