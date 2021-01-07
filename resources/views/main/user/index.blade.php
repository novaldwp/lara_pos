@extends('layouts.app')

@section('header')
    Pengguna
@endsection

@section('title')
  Daftar Data Pengguna
@endsection

@section('breadcrumb')
   @parent
   <li>Pengguna</li>
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
                <th>Nama Lengkap</th>
                <th>Username</th>
                <th>Tanggal Lahir</th>
                <th>No. Handphone</th>
                <th>Posisi</th>
                <th>Photo</th>
                <th>Aksi</th>
            </tr>
          </thead>
        </table>
      </div>
    </div>
  </div>
</div>

@include('main.user.form')
@endsection

@include('main.user.style')
@include('main.user.script')
