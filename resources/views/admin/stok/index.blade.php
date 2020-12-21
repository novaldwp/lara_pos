@extends('layouts.app')

@section('title')
  Daftar Stok Produk
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

    $('body').on('click', '#modal_button', function(e){
        e.preventDefault();
        var me      = $(this),
            title   = $('.modal-title'),
            action  = $('#action'),
            modal   = $('#formModal');

        title.text('Tambah Kategori Baru');
            action.val(me.hasClass('edit') ? 'Update' : 'Save')
                .removeClass('btn-primary')
                .addClass('btn-success');

        $("#modal_form")[0].reset();
        modal.modal('show');
    });

    $("#modal_form").on('submit', function(e){
        e.preventDefault();
        var action = $("#action").val();

        if(action == "Save") {
          $.ajax({
            url: "{{ route('stok.store') }}",
            method: "POST",
            dataType: "JSON",
            data: $(this).serialize(),
            success: function(data)
            {
              var html ='';
                if(data.errors){
                    for(var i = 0; i < data.errors.length; i++)
                      {
                          html  = '<div class="alert alert-danger alert-dismissible" display="display:block">';
                          html += '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
                          html += '<i class="icon fa fa-ban"></i>'+ data.errors[i];
                          html += '</div>';
                      }
                }
                if(data.success) {

                    $("#modal_form")[0].reset();
                    $("#formModal").modal('hide');
                    swal({
                        title:"Data berhasil disimpan!",
                        type: "success",
                        timer: 2000,
                        showConfirmButton: false
                    });

                    table.ajax.reload();
                }
              $("#form_result").html(html);
              $('#kategori_nama').focus();
            }
          })

        }
        else if(action == "Update") {
            var id  = $('#kategori_id').val();

            $.ajax({
                url: "kategori/"+id,
                method: "PUT",
                data: $(this).serialize(),
                success: function(data){

                    var html ='';
                    if(data.errors){
                        for(var i = 0; i < data.errors.length; i++)
                        {
                            html  = '<div class="alert alert-danger alert-dismissible" display="display:block">';
                            html += '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
                            html += '<i class="icon fa fa-ban"></i>'+ data.errors[i];
                            html += '</div>';
                        }
                    }
                    if(data.success) {

                        $("#modal_form")[0].reset();
                        $("#formModal").modal('hide');
                        swal({
                            title:"Data berhasil diperbarui!",
                            type: "success",
                            timer: 2000,
                            showConfirmButton: false
                        });

                        table.ajax.reload();
                    }

                    $("#form_result").html(html);
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
            url: "kategori/"+id+"/edit",
            method: "GET",
            dataType: "JSON",
            success: function(data) {

                // passing from data to input text field
                $('#kategori_nama').val(data.kategori_nama);
                $('#kategori_id').val(data.kategori_id);
                // showing modal and other customize for update
                modal.modal('show');
                title.text('Edit Kategori');
                action.val(me.hasClass('edit') ? 'Update' : 'Save')
                    .removeClass('btn-success')
                    .addClass('btn-primary');
                // focus on text field kategori_nama
                $('#kategori_nama').focus();
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
                    url: 'kategori/'+id,
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
