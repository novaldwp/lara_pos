@extends('layouts.app')

@section('title')
  Transaksi Produk
@endsection

@section('breadcrumb')
   @parent
   <li>Transaksi</li>
@endsection

@section('content')
<!-- Start of Kiri -->
<div class="row">
  <div class="col-xs-5">
    <div class="box">
        <div class="box-body">
        <!-- Content body-->
            <div class="row">
                <div class="col-xs-12" style="margin-left:0px">
                    <div class="clearfix">
                        <div class="input-group">
                            <input type="text" class="form-control" name="produk_kode" id="produk_kode" placeholder="Scan Barcode disini..." aria-describedby="scan" autocomplete="off">
                            <span class="input-group-addon blue" id="search" style="cursor: pointer"><span class="fa fa-search" title="Pencarian Barang"></span></span>
                        </div>
                    </div>
                </div>
            </div>

            <table class="table table-responsive table-hover table-striped" id="table-produk" name="table-produk">
                <thead>
                    <tr>
                        <th width="30">No</th>
                        <th>Kode Produk</th>
                        <th>Nama Produk</th>
                        <th>Harga</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @php $i = 1; @endphp
                    @foreach($produk as $row)
                    <tr>
                        <td>{{ $i }}</td>
                        <td>{{ $row->produk_kode }}</td>
                        <td>{{ $row->produk_nama }}</td>
                        <td>{{ $row->produk_jual }}</td>
                        <td>
                            <a href"#" class="btn btn-success" id="add-item" name="add-item" produk-id="{{ $row->produk_id }}">
                                <i class="fa fa-plus"></i>
                            </a>
                        </td>
                    </tr>
                    @php $i++; @endphp
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- End of Content body-->
    </div>
  </div>
<!-- End of Kiri-->

<!-- Start of Kanan -->
    <div class="col-xs-7">
        <div class="box">
            <div class="box-body">
            <!-- Content body-->

                <table class="table table-responsive table-hover table-striped" id="detail-produk" name="detail-produk">
                    <thead>
                        <tr>
                            <th width="">No</th>
                            <th>Nama Produk</th>
                            <th>Qty</th>
                            <th>Subtotal</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody id="detail-cart">
                    </tbody>
                </table>
            </div>
            <!-- End of Content body-->
        </div>
    </div>
    </div>
    <!-- End of Kanan-->
@endsection

@section('script')
<script>
$(document).ready(function(){

    $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#produk_kode').focus();

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
