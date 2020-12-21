@extends('layouts.app')

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

@include('admin.produk.form')
@include('admin.produk.image')
@endsection

@section('script')
<script>
$(document).ready(function(){

    $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
        }
    });

    function remove_notification(){
        form   = $("#modal_form");

        // remove error notification
        form.find('.help-block').remove();
        form.find('.form-group').removeClass('has-error');
        $("div").remove(".spasi");

    }

    table = $("#data-table").DataTable({
              responsive: true,
              processing : true,
              serverSide : true,
              ajax: {
                url: "{{ route('produk.index') }}",
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
                  data: 'kategori_nama',
                  name: 'kategori_nama'
                },
                {
                  data: 'produk_beli',
                  name: 'produk_beli'
                },
                {
                  data: 'produk_jual',
                  name: 'produk_jual'
                },
                {
                  data: 'image',
                  name: 'image'
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

    $('body').on('click', '#modal_button', function(e){
        e.preventDefault();
        var me      = $(this),
            title   = $('.modal-title'),
            action  = $('#action'),
            form    = $('#modal_form');
            modal   = $('#formModal');

        remove_notification();

        $.ajax({
            url: 'produk/get_produk_kode',
            type: 'POST',
            dataType: 'JSON',
            success: function(data)
            {

                title.text('Tambah produk Baru');
                    action.val(me.hasClass('edit') ? 'Update' : 'Save')
                        .removeClass('btn-primary')
                        .addClass('btn-success');

                $("#modal_form")[0].reset();
                $("#kategori_id").val("");
                $(".image-edit").hide();
                $("#produk_kode").val(data);
                $("#produk_nama").focus();
                modal.modal('show');
            }
        })

    });

    $("#modal_form").on('submit', function(e){
        e.preventDefault();
        // define some variables
        var action = $("#action").val(),
            form   = $("#modal_form");

        remove_notification();

        // if the button value = save
        if(action == "Save") {

            $.ajax({
                url: "{{ route('produk.store') }}",
                method: "POST",
                dataType: "JSON",
                processData: false,
                cache: false,
                contentType: false,
                data: new FormData(this),
                success: function(data)
                {
                    // reload datatable with ajax method, reset form and hide the modals
                    form.trigger('reset');
                    $("#formModal").modal('hide');
                    table.ajax.reload();
                    // sweetalert notify success
                    swal({
                        title:"Data berhasil disimpan!",
                        type: "success",
                        timer: 2000,
                        showConfirmButton: false
                    });
                },
                error: function(xhr)
                {
                    // error notification config
                    var res = xhr.responseJSON;
                    // if error response is not empty
                    if($.isEmptyObject(res) == false)
                    {
                        // then each object errors with the key and value
                        $.each(res.errors, function(key, value)
                        {
                            // config the key of errors
                            $('#' + key)
                                .closest('.form-group')
                                .addClass('has-error')
                                .append(
                                    '<div class="col-md-4 spasi"></div>' +
                                    '<span class="help-block col-md-8"><strong>'+ value +'</strong></span>'
                                    )
                        });
                    }
                }
            });
        }
        else if(action == "Update") {
            var id  = $('#produk_id').val(),
                formdata = new FormData(this);
            // method spoofing because FormData only can be "POST" and Laravel Route should "PATCH or PUT" to this route
            formdata.append('_method', 'PATCH');
            // ajax config
            $.ajax({
                url: "produk/"+id,
                method: "POST",
                dataType: "JSON",
                processData: false,
                cache: false,
                contentType: false,
                data: formdata,
                success: function(data){
                        // reload datatable with ajax method, reset form and hide the modals
                        table.ajax.reload();
                        form.trigger('reset');
                        $("#formModal").modal('hide');
                        // sweetalert notify success
                        swal({
                            title:"Data berhasil diperbarui!",
                            type: "success",
                            timer: 2000,
                            showConfirmButton: false
                        });
                },
                error: function(xhr){
                    // error notification config
                    var res = xhr.responseJSON;
                    // if error response is not empty
                    if($.isEmptyObject(res) == false)
                    {
                        // then each object errors with the key and value
                        $.each(res.errors, function(key, value)
                        {
                            // config the key of errors
                            $('#' + key)
                                .closest('.form-group')
                                .addClass('has-error')
                                .append(
                                    '<div class="col-md-4 spasi"></div>' +
                                    '<span class="help-block col-md-8"><strong>'+ value +'</strong></span>'
                                    )
                        });
                    }
                }
            })

        }
    });

    $('#data-table').on('click','#edit', function(e){
        e.preventDefault();
        var me      = $(this),
            id      = me.attr('data'),
            form    = $('#modal_form form'),
            modal   = $('#formModal'),
            title   = $('#modal-title'),
            action  = $('#action');

        remove_notification();

        $.ajax({
            url: "produk/"+id+"/edit",
            method: "GET",
            dataType: "JSON",
            success: function(data) {
                var kategori_id = data.kategori_id,
                    path        = data.produk_gambar == "no_image.png" ? "images/" : "images/produk/";
                    html        = '<img width="100" src='+path+data.produk_gambar+'></img>';

                // passing from data to input text field
                $('#produk_kode').val(data.produk_kode);
                $('#produk_nama').val(data.produk_nama);
                $('#produk_beli').val(data.produk_beli);
                $('#produk_jual').val(data.produk_jual);
                $('#kategori_id option[value='+kategori_id+']').attr('selected', 'selected');
                $('.image-edit').html(html);
                $('.image-edit').show();
                $('#produk_id').val(data.produk_id);
                // showing modal and other customize for update
                modal.modal('show');
                title.text('Edit produk');
                action.val(me.hasClass('edit') ? 'Update' : 'Save')
                    .removeClass('btn-success')
                    .addClass('btn-primary');
                // focus on text field produk_nama
                $('#produk_nama').focus();
            }
        })
    });

    $('#data-table').on('click', '#delete', function(e){
        e.preventDefault();
        var me = $(this),
            id = me.attr('data');
        // sweet alert config confirmation
        swal({
            title: "Apakah kamu yakin?!",
            text: "Data tidak dapat dikembalikan setelah dihapus!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya!',
            cancelButtonText: 'Tidak!',
        }).then( (result) => {
            // if the answer yes, then
            if (result.value)
            {
                // ajax config
                $.ajax({
                    url: 'produk/'+id,
                    method: 'DELETE',
                    success: function(response) {
                        table.ajax.reload();
                        swal({
                            type: "success",
                            text: "Data berhasil dihapus!",
                            timer: 2000,
                            showConfirmButton: false
                        })
                    }
                })
            }
        });
    });

    $('#data-table').on('click', '#image-click', function(e){
        e.preventDefault();
        var me      = $(this),
            id      = me.attr('data'),
            image   = me.attr('image'),
            modal   = $('#imageModal'),
            html    = '<img width="400px" src='+image+'></img>';

            modal.modal('show');
            $('.image-result').html(html);
    })


});
</script>
@endsection
