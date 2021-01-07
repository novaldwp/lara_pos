@extends('layouts.app')

@section('header')
    Produk
@endsection

@section('title')
  Daftar Data Produk
@endsection

@section('breadcrumb')
   @parent
   <li>Produk</li>
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
                <th width="30">No</th>
                <th>Kode Produk</th>
                <th>Nama Produk</th>
                <th>Kategori</th>
                <th>Harga Beli</th>
                <th>Harga Jual</th>
                <th>Gambar</th>
                <th>Aksi</th>
            </tr>
          </thead>
        </table>
      </div>
    </div>
  </div>
</div>

    @include('master.produk.form')
@endsection

@section('style')
    @include('master.produk.style')
@endsection

@section('script')
    @include('master.produk.script')
@endsection
