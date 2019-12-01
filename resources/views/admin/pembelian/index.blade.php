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
    <form method="post" class="form-horizontal" enctype="multipart/form-data">
        <!-- Kiri-->
        <div class="col-md-6">
            <div class="hidden">
                <input type="hidden" name="produk_id" id="produk_id">
            </div>

            <div class="form-group">
                <label class="col-sm-4 control-label no-padding-right"> Kode Produk </label>
                <div class="col-sm-8">
                    <div class="clearfix">
                        <div class="input-group">
                            <input type="text" class="form-control" name="produk_kode" id="produk_kode" placeholder="Kode Produk" aria-describedby="search" oninput="ajax_barang_by_kode(this.value);" autocomplete="off" autofocus>
                            <span class="input-group-addon blue" id="search" style="cursor: pointer"><span class="fa fa-search" title="Pencarian Barang"></span></span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-sm-4">Nama Produk :</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" id="produk_nama" readonly>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-sm-4">Sisa Stok :</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" id="stok_jumlah" readonly>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-sm-4">Jumlah Beli :</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" id="produk_jumlah">
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-4 col-sm-8">
                    <button class="btn btn-success col-sm-12" id="tambah" name="tambah">Tambah</button>
                </div>
            </div>

        </div>
        <!-- end of Kiri -->

        <!-- Kanan -->
        <div class="col-md-6">
            {{-- <div class="form-group">
                <label class="control-label col-sm-3">No. Transaksi :</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="produk_kode" readonly>
                </div>
            </div> --}}

            <div class="form-group">
                <label class="col-sm-4 control-label no-padding-right">No. Transaksi </label>
                <div class="col-sm-8">
                    <div class="clearfix">
                        <div class="input-group">
                            <input type="text" class="form-control" name="transaksi_kode" id="transaksi_kode" placeholder="No. Transaksi" readonly>
                            <span class="input-group-addon info" id="generate" style="cursor: pointer">Generate!</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-group">
                    <label class="control-label col-sm-4">Tanggal :</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="produk_tanggal" value="<?php echo date('d-m-Y'); ?>" readonly>
                    </div>
            </div>

            <div class="form-group">
                <label class="control-label col-sm-4 pull-left">Supplier :</label>
                <div class="col-sm-8">
                    <select name="supplier_id" id="supplier_id" class="form-control">
                        <option value="" selected readonly></option>
                        @foreach($supplier as $row)
                            <option value="{{ $row->supplier_id }}"> {{ $row->supplier_nama }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

        </div>
        <!-- end of Kanan -->
    </form>
      <!-- End of Content body-->
      </div>
    </div>
  </div>
</div>
<!-- End of Atas-->

<!-- Start of Bawah -->
<div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header">
          <h4>Detail Pembelian</h4>
          <hr>
        </div>
        <div class="box-body">
        <!-- Content body-->
        <table class="table table-responsive table-hover table-striped" id="detail-table">
            <thead>
                <tr>
                    <th width="30">No</th>
                    <th>Kode Produk</th>
                    <th>Nama Produk</th>
                    <th>Harga Beli</th>
                    <th>Jumlah</th>
                    <th>Sub Total</th>
                    <th>Aksi</th>
                </tr>
            </thead>
        </table>

        <!-- End of Content body-->
        </div>
      </div>
    </div>
</div>
<!-- End of Bawah -->
@include('admin.pembelian.search')
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


    $("#generate").on('click', function(e){
        e.preventDefault();
        $.ajax({
            url:'pembelian/get_pembelian_kode',
            type: 'POST',
            dataType: 'JSON',
            success:function(data){
                $("#transaksi_kode").val(data);
            }
        })
    })

    $("#search").on('click', function(e){
        e.preventDefault();
        var modal = $('#formModal');

        modal.modal('show');
    })

    $('#data-table').on('click', '#select', function(e){
        e.preventDefault();
        var me = $(this),
            id = me.attr('data');

        $.ajax({
            url: 'pembelian/get_by_id/'+id,
            type: 'GET',
            dataType: 'JSON',
            success: function(data)
            {
                var stok    = (data[0].stok == null) ? '0' : data[0].stok.stok_jumlah,
                    modal   = $('#formModal');

                $('#produk_id').val(data[0].produk_id);
                $('#produk_nama').val(data[0].produk_nama);
                $('#stok_jumlah').val(stok);

                modal.modal('hide');
            }
        })
    })

    $('#tambah').on('click', function(e){
        e.preventDefault();

        if($('#pembelian_kode').val() == '')
        {
            swal({
                title:"Generate kode pembelian terlebih dahulu!",
                type: "warning",
                timer: 1000,
                showConfirmButton: false
            });

            $('#produk_kode').focus();
        }
        else if ($('#produk_id').val() == '')
        {
            swal({
                title:"Pilih produk terlebih dahulu!",
                type: "warning",
                timer: 1000,
                showConfirmButton: false
            });

            $('#produk_kode').focus();
        }
        else{

            $.ajax({
                url:'',
                type:'POST',
                dataType:'JSON',
                data:
                success:function(res)
                {

                },
                error:function(xhr)
                {
                    var res = xhr.responseJSON;

                    console.log(res);
                }
            })
        }

    })

});
</script>
@endsection
