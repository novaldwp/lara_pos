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
                            <input type="text" class="form-control" name="produk_kode" id="produk_kode" placeholder="Kode Produk" aria-describedby="search" autocomplete="off" autofocus>
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
                    <input type="text" class="form-control" id="pembelian_jumlah" name="pembelian_jumlah">
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
                            <input type="text" class="form-control" name="pembelian_kode" id="pembelian_kode" placeholder="No. Transaksi" readonly>
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
                    <label class="control-label col-sm-4">Harga Beli :</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="produk_beli" readonly>
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
<div class="tampil-detail">

</div>

<!-- Start of Bawah -->
<div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header">
            <button class="btn btn-success col-sm-12" name="confirm" id="confirm" url="{{ route('pembelian.store') }}">Simpan</button>
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

    delete_detail();
    tampil_detail();

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

    function tampil_detail(){
        $('.tampil-detail').load('get_pembelian_detail');
    }

    function delete_detail(){
        $.ajax({
            url:'pembelian/delete_detail',
            type:'POST'
        })
    }

    $('#produk_kode').on('input', function(){
        var produk_kode = $('#produk_kode').val();
        $.ajax({
            url:'pembelian/get_produk_by_kode/'+produk_kode,
            type: 'GET',
            dataType: 'JSON',
            success:function(data)
            {
                var stok    = (data.stok == null) ? '0' : data.stok.stok_jumlah;

                $('#produk_id').val(data.produk_id);
                $('#produk_nama').val(data.produk_nama);
                $('#produk_beli').val(data.produk_beli);
                $('#stok_jumlah').val(stok);
            },
            error:function(xhr)
            {
                var res = xhr.responseTEXT;

                alert(res);
            }
        })

    })

    $("#generate").on('click', function(e){
        e.preventDefault();
        $.ajax({
            url:'pembelian/get_pembelian_kode',
            type: 'POST',
            dataType: 'JSON',
            success:function(data){
                $("#pembelian_kode").val(data);
            }
        })
    });

    $("#search").on('click', function(e){
        e.preventDefault();
        var modal = $('#formModal');

        modal.modal('show');
    });

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
                $('#produk_kode').val(data[0].produk_kode);
                $('#produk_nama').val(data[0].produk_nama);
                $('#produk_beli').val(data[0].produk_beli);
                $('#stok_jumlah').val(stok);

                modal.modal('hide');
            }
        })
    });

    $('#tambah').on('click', function(e){
        e.preventDefault();
        var produk_id        = $('#produk_id').val(),
            pembelian_jumlah = $('#pembelian_jumlah').val(),
            produk_beli      = $('#produk_beli').val();

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
                url:'pembelian/storeDummy',
                type:'POST',
                dataType:'JSON',
                data:{produk_id:produk_id, pembelian_jumlah:pembelian_jumlah, produk_beli:produk_beli},
                success:function(res)
                {
                    $('#pembelian_jumlah').val('');
                    $('#produk_id').val('');
                    $('#produk_kode').val('');
                    $('#produk_beli').val('');
                    $('#produk_nama').val('');
                    $('#stok_jumlah').val('');
                    tampil_detail();
                    $('#produk_kode').focus();
                },
                error:function(xhr)
                {
                    var res = xhr.responseTEXT;

                    alert(rest);
                }
            })
        }
    });

    $('#confirm').on('click', function(e){
        e.preventDefault();
        var pembelian_kode = $('#pembelian_kode').val(),
            supplier_id    = $('#supplier_id').val();

        swal({
            title: "Konfirmasi",
            text: "Apakah data sudah terisi dengan benar?",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya!',
            cancelButtonText: 'Tidak!',
        }).then( (result) => {
            if (result.value)
            {
                $.ajax({
                    url:"{{ route('pembelian.index') }}",
                    type:'POST',
                    dataType:'JSON',
                    data:{pembelian_kode:pembelian_kode, supplier_id:supplier_id},
                    success:function(data)
                    {
                        swal({
                            type: "success",
                            text: data,
                            timer: 2000,
                            showConfirmButton: false,
                            // onAfterClose: () => window.scrollTo(0,0) going to fix it later
                        });

                        tampil_detail();
                        $('#pembelian_kode').val('');
                        $('#supplier_id').val('');


                    },
                    error:function(xhr)
                    {
                        var res = xhr.responseTEXT;

                        alert(res);
                    }
                });
            }
        })
    });

});
</script>
@endsection
