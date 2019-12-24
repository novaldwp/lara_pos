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
    <div class="col-sm-12">
        <div class="box">
            <div class="box-header">
                <div class="col-sm-6">
                <!-- left column -->
                <form class="form-horizontal">
                    <div class="form-group">
                        <label class="control-label col-sm-3">No. Penjualan :</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="penjualan_kode" name="penjualan_kode" value="" readonly>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-3">Scan Barcode :</label>
                        <div class="col-sm-9">
                            <input type="text" placeholder="Scan Barcode disini.." class="form-control" id="produk_kode" name="produk_kode">
                        </div>
                    </div>
                </form>
                <!-- end of left column -->
                </div>
                <div class="col-sm-6">
                <!-- right column -->
                <form class="form-horizontal">
                    <div class="form-group">
                        <label class="control-label col-sm-4">ID Member :</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="member_id" name="member_id">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-4">Nama Member :</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="member_name" name="member_name" readonly>
                        </div>
                    </div>
                </form>
                <!-- end of right column -->
                </div>
            </div>
            <div class="box-body">
            <!-- Content body-->
                <div class="col-sm-12">
                    <hr>
                    <table class="table table-responsive table-hover table-striped" id="detail-penjualan" name="detail-penjualan">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Kode Produk</th>
                                <th>Nama Produk</th>
                                <th>Harga</th>
                                <th class="text-center" width="20%">Qty</th>
                                <th class="text-center">Subtotal</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody id="detail-cart">

                        </tbody>
                    </table>
                </div>

            </div>
            <!-- End of Content body-->
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

    get_penjualan_cart();

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

    function get_penjualan_cart(){
        $('#detail-cart').load('get_penjualan_cart');
    }

    $('body').on('keyup', '#produk_kode', function(e){
        var keycode = (e.keyCode ? e.keyCode :  e.which);
        var kode = $('#produk_kode').val();

            if(kode.length == 7)
            {
                $.ajax({
                    url:'produk/insert_penjualan_cart',
                    type:'POST',
                    dataType:'JSON',
                    data:{kode:kode},
                    success:function(res)
                    {
                        get_penjualan_cart();
                        $('#produk_kode').val("");
                        $('#produk_kode').focus();
                    }
                })
            }

    })


});
</script>
@endsection
