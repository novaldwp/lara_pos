@extends('layouts.app')

@section('header')
    Pembeli
@endsection

@section('title')
  Daftar Data Pembeli
@endsection

@section('breadcrumb')
   @parent
   <li>Pembeli</li>
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
                <th>Kode Pembeli</th>
                <th>Nama Pembeli</th>
                <th>No. Handphone</th>
                <th>Alamat</th>
                <th>Aksi</th>
            </tr>
          </thead>
        </table>
      </div>
    </div>
  </div>
</div>

    @include('main.member.form')
@endsection

@section('script')
    @include('main.member.script')
@endsection
