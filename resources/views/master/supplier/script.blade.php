<script>
    let uri = 'supplier/';

    $(document).ready(function() {
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
                    url: "{{ route('master.supplier.index') }}",
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
                        data: 'supplier_kontak',
                        name: 'supplier_kontak'
                    },
                    {
                        data: 'supplier_phone',
                        name: 'supplier_phone'
                    },
                    {
                        data: 'supplier_alamat',
                        name: 'supplier_alamat'
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
            let me      = $(this),
                title   = $('.modal-title'),
                action  = $('#action'),
                modal   = $('#formModal');

            title.text('Tambah Data Supplier');
                action.val(me.hasClass('edit') ? 'Update' : 'Save')
                    .removeClass('btn-primary')
                    .addClass('btn-success');

            $("#modal_form")[0].reset();
            modal.modal('show');
        });

        // form validation
        $("#modal_form").validate({
            rules: {
                supplier_nama: {
                    required: true
                },
                supplier_kontak: {
                    required: true
                },
                supplier_phone: {
                    required: true,
                    number: true,
                    rangelength: [10,14]
                },
                supplier_alamat: {
                    required: true
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
            submitHandler: function(form) {
                let action = $("#action").val();

                if(action == "Save") {
                    $.ajax({
                        url: "{{ route('master.supplier.store') }}",
                        method: "POST",
                        dataType: "JSON",
                        data: $('#modal_form').serialize(),
                        success: function(data)
                        {
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
                        }
                    });
                }
                else if(action == "Update"){
                    let id  = $('#supplier_id').val();

                    $.ajax({
                        url: uri+id,
                        method: "PUT",
                        data: $("#modal_form").serialize(),
                        success: function(data)
                        {
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
            }
        });

        $('#data-table').on('click','#edit', function(e){
            e.preventDefault();
            let me      = $(this),
                id      = me.attr('data'),
                form    = $('#modal_form form'),
                modal   = $('#formModal'),
                title   = $('#modal-title'),
                action  = $('#action');

            // remove_notification();

            $.ajax({
                url: uri+id+"/edit",
                method: "GET",
                dataType: "JSON",
                success: function(data) {

                    // passing from data to input text field
                    $('#supplier_nama').val(data.supplier_nama);
                    $('#supplier_alamat').val(data.supplier_alamat);
                    $('#supplier_kontak').val(data.supplier_kontak);
                    $('#supplier_phone').val(data.supplier_phone);
                    $('#supplier_id').val(data.supplier_id);
                    // showing modal and other customize for update
                    modal.modal('show');
                    title.text('Ubah Data Supplier');
                    action.val(me.hasClass('edit') ? 'Update' : 'Save')
                        .removeClass('btn-success')
                        .addClass('btn-primary');
                    // focus on text field kategori_nama
                    $('#supplier_nama').focus();
                }
            })
        });

        $('#data-table').on('click', '#delete', function(e){
            e.preventDefault();
            let me = $(this),
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
                        },
                        error: function(xhr) {
                            swal({
                                type: "error",
                                text: "Cannot proceed",
                                timer: 2000,
                                showConfirmButton: false
                            })
                        }
                    })
                }
            });
        });
    })
</script>
