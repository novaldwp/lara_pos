@extends('layouts.app')

@section('header')
    Kategori
@endsection

@section('title')
  Daftar Data Kategori
@endsection

@section('breadcrumb')
   @parent
   <li>Master</li>
   <li>Kategori</li>
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
                <th>Nama Kategori</th>
                <th width="15%">Aksi</th>
            </tr>
          </thead>
        </table>
      </div>
    </div>
  </div>
</div>

@include('master.kategori.form')
@endsection

@section('script')
@include('master.kategori.script')
@endsection
