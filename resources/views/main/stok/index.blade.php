@extends('layouts.app')

@section('header')
    Stok
@endsection

@section('title')
  Daftar Data Stok Produk
@endsection

@section('breadcrumb')
   @parent
   <li>Stok</li>
@endsection

@section('content')
<div class="row">
  <div class="col-xs-12">
    <div class="box">
      <div class="box-header">
        <!-- ini di kosongin dulu sengaja-->
      </div>
      <div class="box-body">
        <table class="table table-responsive table-hover table-striped" id="data-table">
          <thead>
            <tr>
                <th width="5%">No</th>
                <th>Kode Produk</th>
                <th>Nama Produk</th>
                <th>Stok Produk</th>
            </tr>
          </thead>
        </table>
      </div>
    </div>
  </div>
</div>

@endsection

@section('script')
<script>
$(document).ready(function(){

    $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
        }
    });

    table = $("#data-table").DataTable({
              responsive: true,
              processing : true,
              serverSide : true,
              ajax: {
                url: "{{ route('stok.index') }}",
              },
              columns: [
                {
                  data: 'DT_RowIndex',
                  name: 'DT_RowIndex'
                },
                {
                  data: 'produk.produk_kode',
                  name: 'produk.produk_kode'
                },
                {
                  data: 'produk.produk_nama',
                  name: 'produk.produk_nama'
                },
                {
                  data: 'stok_jumlah',
                  name: 'stok_jumlah'
                }
              ],
              "oLanguage" : {
                "sSearch" : "Pencarian",
                "oPaginate" : {
                  "sNext" : "Berikutnya",
                  "sPrevious" : "Sebelumnya",
                  "sFirst" : "Awal",
                  "sLast" : "Akhir",
                  "sEmptyTable" : "Data tidak ditemukan!"
                }
              },
              "info": false,
              "bLengthChange": false
            });
});
</script>
@endsection
