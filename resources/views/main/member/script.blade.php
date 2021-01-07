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
                        url: "{{ route('member.index') }}",
                      },
                      columns: [
                        {
                          data: 'DT_RowIndex',
                          name: 'DT_RowIndex'
                        },
                        {
                          data: 'member_kode',
                          name: 'member_kode'
                        },
                        {
                          data: 'member_nama',
                          name: 'member_nama'
                        },
                        {
                          data: 'member_phone',
                          name: 'member_phone'
                        },
                        {
                          data: 'member_alamat',
                          name: 'member_alamat'
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

                $.ajax({
                    url: 'member/createMemberCode',
                    method: 'GET',
                    dataType: 'JSON',
                    success: function(data) {
                        title.text('Tambah Data Pembeli');
                            action.val(me.hasClass('edit') ? 'Update' : 'Save')
                                .removeClass('btn-primary')
                                .addClass('btn-success');

                        $("#modal_form")[0].reset();
                        $("#member_kelamin").val("");
                        $("#member_kode").val(data);
                        modal.modal('show');
                        $("#member_nama").focus();
                    }
                })

            });

            $("#modal_form").validate({
                rules: {
                    member_nama: {
                        required: true
                    },
                    member_phone: {
                        required: true,
                        number: true,
                        rangelength: [10,14]
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
                    var action = $("#action").val();

                    // if the button value = save
                    if(action == "Save") {
                        $.ajax({
                            url: "{{ route('member.store') }}",
                            method: "POST",
                            dataType: "JSON",
                            data: $("#modal_form").serialize(),
                            success: function(data)
                            {
                                // reload datatable with ajax method, reset form and hide the modals
                                $("#formModal").modal('hide');
                                table.ajax.reload();

                                // sweetalert notify success
                                swal({
                                    title: "Berhasil",
                                    text: data.message,
                                    type: "success",
                                    timer: 2000,
                                    showConfirmButton: false
                                });
                            },
                        })
                    }
                    else if(action == "Update") {
                        var id  = $('#member_id').val();

                        $.ajax({
                            url: "member/"+id,
                            method: "PUT",
                            data: $("#modal_form").serialize(),
                            success: function(data){

                                // reload datatable with ajax method, reset form and hide the modals
                                $("#formModal").modal('hide');
                                table.ajax.reload();

                                // sweetalert notify success
                                swal({
                                    title: "Berhasil",
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
                var me      = $(this),
                    id      = me.attr('data'),
                    form    = $('#modal_form form'),
                    modal   = $('#formModal'),
                    title   = $('#modal-title'),
                    action  = $('#action');

                $.ajax({
                    url: "member/"+id+"/edit",
                    method: "GET",
                    dataType: "JSON",
                    success: function(data) {

                        // passing from data to input text field
                        $('#member_kode').val(data.member_kode);
                        $('#member_nama').val(data.member_nama);
                        $('#member_alamat').val(data.member_alamat);
                        $('#member_phone').val(data.member_phone);
                        $('#member_id').val(data.member_id);
                        // showing modal and other customize for update
                        modal.modal('show');
                        title.text('Edit member');
                        action.val(me.hasClass('edit') ? 'Update' : 'Save')
                            .removeClass('btn-success')
                            .addClass('btn-primary');
                        // focus on text field member_nama
                        $('#member_nama').focus();
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
                            url: 'member/'+id,
                            method: 'DELETE',
                            success: function(data) {
                                table.ajax.reload();
                                swal({
                                    type: "success",
                                    title: "Berhasil",
                                    text: data.message,
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
