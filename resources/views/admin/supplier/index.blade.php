@extends('layouts.app')

@section('title')
  Daftar Data Supplier
@endsection

@section('breadcrumb')
   @parent
   <li>Master</li>
   <li>Supplier</li>
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
                <th>Nama Supplier</th>
                <th>Alamat Supplier</th>
                <th>Kontak</th>
                <th>No. Telpon</th>
                <th>Aksi</th>
            </tr>
          </thead>
        </table>
      </div>
    </div>
  </div>
</div>

@include('admin.supplier.form')
@endsection

@section('script')
<script>
$(document).ready(function(){

    function remove_notification(){
        form   = $("#modal_form");

        // remove error notification
        form.find('.help-block').remove();
        form.find('.form-group').removeClass('has-error');
        $("div").remove(".spasi");
    }

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
                url: "{{ route('supplier.index') }}",
              },
              columns: [
                {
                  data: 'DT_RowIndex',
                  name: 'DT_RowIndex'
                },
                {
                  data: 'supplier_nama',
                  name: 'supplier_nama'
                },
                {
                  data: 'supplier_alamat',
                  name: 'supplier_alamat'
                },
                {
                  data: 'supplier_kontak',
                  name: 'supplier_kontak'
                },
                {
                  data: 'supplier_telpon',
                  name: 'supplier_telpon'
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
            modal   = $('#formModal');

        remove_notification();

        title.text('Tambah Supplier Baru');
            action.val(me.hasClass('edit') ? 'Update' : 'Save')
                .removeClass('btn-primary')
                .addClass('btn-success');

        $("#modal_form")[0].reset();
        modal.modal('show');
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
                url: "{{ route('supplier.store') }}",
                method: "POST",
                dataType: "JSON",
                data: $(this).serialize(),
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
            var id  = $('#supplier_id').val();

            $.ajax({
                url: "supplier/"+id,
                method: "PUT",
                data: $(this).serialize(),
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
                                    '<div class="col-md-4"></div>' +
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
            url: "supplier/"+id+"/edit",
            method: "GET",
            dataType: "JSON",
            success: function(data) {

                // passing from data to input text field
                $('#supplier_nama').val(data.supplier_nama);
                $('#supplier_alamat').val(data.supplier_alamat);
                $('#supplier_kontak').val(data.supplier_kontak);
                $('#supplier_telpon').val(data.supplier_telpon);
                $('#supplier_id').val(data.supplier_id);
                // showing modal and other customize for update
                modal.modal('show');
                title.text('Edit supplier');
                action.val(me.hasClass('edit') ? 'Update' : 'Save')
                    .removeClass('btn-success')
                    .addClass('btn-primary');
                // focus on text field supplier_nama
                $('#supplier_nama').focus();
            }
        })
    });

    $('#data-table').on('click', '#delete', function(e){
        e.preventDefault();
        var me = $(this),
            id = me.attr('data');

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
            if (result.value)
            {
                $.ajax({
                    url: 'supplier/'+id,
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
});
</script>
@endsection
