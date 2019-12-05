@extends('layouts.app')

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


      </div>
      <!-- End of Content body-->
    </div>
  </div>
</div>
<!-- End of Atas-->

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
                url: "{{ route('pembelian.index') }}",
              },
              columns: [
                {
                  data: 'DT_RowIndex',
                  name: 'DT_RowIndex'
                },
                {
                  data: 'produk_kode',
                  name: 'produk_kode'
                },
                {
                  data: 'produk_nama',
                  name: 'produk_nama'
                },
                {
                  data: 'produk_beli',
                  name: 'produk_beli'
                },
                {
                  data: 'action',
                  name: 'action',
                  orderable: false,
                  searchable: false
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
              }
            });

});
</script>
@endsection
