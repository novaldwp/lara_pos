<script>
    $(document).ready(function() {
        let uri = 'kategori/';

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
                    url: "{{ route('master.kategori.index') }}",
                    },
                    columns: [
                    {
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'kategori_nama',
                        name: 'kategori_nama'
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

            title.text('Tambah Data Kategori');
                action.val(me.hasClass('edit') ? 'Update' : 'Save')
                    .removeClass('btn-primary')
                    .addClass('btn-success');

            $("#modal_form")[0].reset();
            modal.modal('show');
        });

        // form validation
        $("#modal_form").validate({
            rules: {
                kategori_nama: {
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
                        url: "{{ route('master.kategori.store') }}",
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
                    let id  = $('#kategori_id').val();

                    $.ajax({
                        url: uri+id,
                        method: "PUT",
                        data: $("#modal_form").serialize(),
                        success: function(res)
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
                    $('#kategori_nama').val(data.kategori_nama);
                    $('#kategori_id').val(data.kategori_id);
                    // showing modal and other customize for update
                    modal.modal('show');
                    title.text('Ubah Data Kategori');
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
