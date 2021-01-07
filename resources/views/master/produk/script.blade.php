<script>
$(document).ready(function() {
    let uri = 'produk/';

    // config lightbox js
    lightbox.option({
        'disableScrolling': true,
        'showImageNumberLabel': false,
    })

    // csrf token
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
        }
    });

    // datatables config
    table = $("#data-table").DataTable({
                responsive: true,
                processing : true,
                serverSide : true,
                ajax: {
                url: "{{ route('master.produk.index') }}",
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
                    data: 'kategori.kategori_nama',
                    name: 'kategori.kategori_nama'
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

    // event show modal form
    $('body').on('click', '#modal_button', function(e){
        e.preventDefault();
        var me      = $(this),
            title   = $('.modal-title'),
            action  = $('#action'),
            form    = $('#modal_form');
            modal   = $('#formModal');

        $.ajax({
            url: uri+'getProductCode',
            method: 'GET',
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

    // form validation
    $("#modal_form").validate({
        rules: {
            produk_nama: {
                required: true
            },
            produk_beli: {
                required: true,
                number: true
            },
            produk_jual: {
                required: true,
                number: true
            },
            kategori_id: {
                required: true
            },
            produk_image: {
                extension: "jpg|jpeg|png|gif|svg"
            }
        },
        highlight: function(element) {
            $(element).closest('.form-group').addClass('has-error');
        },
        unhighlight: function(element) {
            $(element).closest('.form-group').removeClass('has-error');
        },
        errorElement: 'span',
        errorClass: 'help-block',
        errorPlacement: function(error, element) {
            if(element.parent('.input-group').length) {
                error.insertAfter(element.parent());
            }
            else {
                error.insertAfter(element);
            }
        },
        // event if form button click
        submitHandler: function(form) {
            let action = $("#action").val(),
                formdata = new FormData($("#modal_form")[0]); // using formdata because we upload image

            if(action == "Save") {
                $.ajax({
                    url: "{{ route('master.produk.store') }}",
                    method: "POST",
                    dataType: "JSON",
                    enctype: "multipart/form-data",
                    processData: false,
                    cache: false,
                    contentType: false,
                    data: formdata,
                    success: function(data)
                    {
                        // reload datatable with ajax method, reset form and hide the modals
                        $("#formModal").modal('hide');
                        table.ajax.reload();
                        // sweetalert notify success
                        swal({
                            title: "Berhasil!",
                            text: data.message,
                            type: "success",
                            timer: 2000,
                            showConfirmButton: false
                        });
                    },
                });
            }
            else if(action == "Update")
            {
                var id  = $('#produk_id').val();

                // method spoofing for update
                formdata.append('_method', 'PATCH');

                // ajax config
                $.ajax({
                    url: uri+id,
                    method: "post",
                    dataType: "JSON",
                    processData: false,
                    cache: false,
                    contentType: false,
                    data: formdata,
                    success: function(data)
                    {
                        // reload datatable with ajax method, reset form and hide the modals
                        table.ajax.reload();
                        $("#formModal").modal('hide');

                        // sweetalert notify success
                        swal({
                            title: "Berhasil!",
                            text: data.message,
                            type: "success",
                            timer: 2000,
                            showConfirmButton: false
                        });
                    }
                });
            }
        }
    });

    // event click edit button
    $('#data-table').on('click','#edit', function(e){
        e.preventDefault();
        let me      = $(this),
            id      = me.attr('data'),
            form    = $('#modal_form form'),
            modal   = $('#formModal'),
            title   = $('#modal-title'),
            action  = $('#action');

        $.ajax({
            url: uri+id+"/edit",
            method: "GET",
            dataType: "JSON",
            success: function(data) {
                console.log(window.location.origin);
                let kategori_id = data.kategori_id,
                    path        = window.location.origin;
                    image       = data.produk_image == "" ? path+"/images/no_image.png" : path+'/images/produk/thumb/'+data.produk_image;
                    html        = '<img width="100" height="80" src='+image+'></img>';

                // passing from data to input text field
                $('#produk_kode').val(data.produk_kode);
                $('#produk_nama').val(data.produk_nama);
                $('#produk_beli').val(data.produk_beli);
                $('#produk_jual').val(data.produk_jual);
                $('#kategori_id option[value='+kategori_id+']').attr('selected', 'selected');
                $('#produk_image').val('');
                $('.image-edit').html(html);
                $('.image-edit').show();
                $('#produk_id').val(data.produk_id);

                // showing modal and other customize for update
                modal.modal('show');
                title.text('Edit produk');
                action.val(me.hasClass('edit') ? 'Update' : 'Save')
                    .removeClass('btn-success')
                    .addClass('btn-primary');
                $('#produk_nama').focus();
            }
        })
    });

    $('#data-table').on('click', '#delete', function(e){
        e.preventDefault();
        let me = $(this),
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
                    url: uri+id,
                    method: 'DELETE',
                    success: function(data) {
                        table.ajax.reload();

                        // sweetalert2 notif
                        swal({
                            type: "success",
                            title: data.message,
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
