@extends('layouts.app')

@section('title')
  Daftar user
@endsection

@section('breadcrumb')
   @parent
   <li>user</li>
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
                <th>Username</th>
                <th>Nama Lengkap</th>
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

@include('admin.user.form')
@include('admin.user.image')
@endsection

@section('script')
<script>
$(document).ready(function(){
    $(".image-edit").hide();

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
                url: "{{ route('user.index') }}",
              },
              columns: [
                {
                  data: 'DT_RowIndex',
                  name: 'DT_RowIndex'
                },
                {
                  data: 'username',
                  name: 'username'
                },
                {
                  data: 'name',
                  name: 'name'
                },
                {
                  data: 'level',
                  name: 'level'
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
            modal   = $('#formModal');

        title.text('Tambah user Baru');
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

        // remove error notification
        form.find('.help-block').remove();
        form.find('.form-group').removeClass('has-error');
        $("div").remove(".spasi");

        // if the button value = save
        if(action == "Save") {
            $.ajax({
                url: "{{ route('user.store') }}",
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
            var id       = $('#id').val();
                formdata = new FormData(this);
            // method spoofing because FormData only can be "POST" and Laravel Route should "PATCH or PUT" to this route
            formdata.append('_method', 'PATCH');
            $.ajax({
                url: "user/"+id,
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

        $.ajax({
            url: "user/"+id+"/edit",
            method: "GET",
            dataType: "JSON",
            success: function(data) {
                var path        = data.photo == "no_image.png" ? "images/" : "images/user/";
                    html        = '<img width="100" src='+path+data.photo+'></img>';

                // passing from data to input text field
                $('#username').val(data.username).attr('readonly', 'true');
                $('#password').val(data.password);
                $('#name').val(data.name);
                $('#level option[value='+data.level+']').attr('selected', 'selected');
                $('.image-edit').html(html).show();
                $('#id').val(data.id);
                // showing modal and other customize for update
                modal.modal('show');
                title.text('Edit user');
                action.val(me.hasClass('edit') ? 'Update' : 'Save')
                    .removeClass('btn-success')
                    .addClass('btn-primary');
                // focus on text field user_nama
                $('#user_nama').focus();
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
                    url: 'user/'+id,
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
