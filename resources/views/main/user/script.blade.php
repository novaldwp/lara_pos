
@section('script')
<script>
$(document).ready(function(){
    let uri = 'user/';

    // lightbox js config
    lightbox.option({
        'disableScrolling': true,
        'showImageNumberLabel': false,
    })

    // datepicker js config
    $('.datepicker').datepicker({
      autoclose: true
    })

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
                data: 'name',
                name: 'name'
            },
            {
                data: 'username',
                name: 'username'
            },
            {
                data: 'birthdate',
                name: 'birthdate'
            },
            {
                data: 'phone',
                name: 'phone'
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

    function remove_notification(element)
    {
        $('#'+element).closest('.form-group')
        .removeClass('has-error');
        $('span#'+element).remove();
        $('div#'+element).remove();
    }

    // disable space function
    $('#username').keypress(function( e ) {
       if(e.which === 32)
         return false;
    });

    $('#username').on('keyup', function() {
        remove_notification("username");
    });

    $("#phone").on('keyup', function() {
        remove_notification("phone");
    })

    $("#old_password").on('keyup', function() {
        remove_notification("old_password");
    })

    $("#password").on('keyup', function() {
        remove_notification("password");
    })

    $("#password_confirmation").on('keyup', function() {
        remove_notification("password_confirmation");
    })

    $('body').on('click', '#modal_button', function(e){
        e.preventDefault();
        var me      = $(this),
            title   = $('.modal-title'),
            action  = $('#action'),
            modal   = $('#formModal');

        title.text('Tambah Data Pengguna');
            action.val(me.hasClass('edit') ? 'Update' : 'Save')
                .removeClass('btn-primary')
                .addClass('btn-success');

        $('.image-edit').hide();
        $("#modal_form")[0].reset();
        modal.modal('show');
    });

    // form validation
    $("#modal_form").validate({
        rules: {
            username: {
                required: true,
                minlength: 4
            },
            name: {
                required: true
            },
            phone: {
                required: true,
                number: true,
                rangelength: [10,14]
            },
            birthdate: {
                required: true
            },
            level: {
                required: true
            },
            photo: {
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
                    url: "{{ route('user.store') }}",
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
                            title: "Berhasil",
                            text: data.message,
                            type: "success",
                            timer: 2000,
                            showConfirmButton: false
                        });
                    },
                    error: function(xhr)
                    {
                        // error notification config for unique data
                        let res = xhr.responseJSON;
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
                                    '<div class="col-md-4 spasi" id="'+key+'"></div>' +
                                    '<span class="help-block col-md-8" id="'+key+'"><strong>'+ value +'</strong></span>'
                                )
                            });
                        }
                    }
                });
            }
            else if(action == "Update")
            {
                var id  = $('#id').val();

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
                            title: "Berhasil",
                            text: data.message,
                            type: "success",
                            timer: 2000,
                            showConfirmButton: false
                        });
                    },
                    error: function(xhr)
                    {
                        // error notification config for unique data
                        let res = xhr.responseJSON;
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
                                    '<div class="col-md-4 spasi" id="'+key+'"></div>' +
                                    '<span class="help-block col-md-8" id="'+key+'"><strong>'+ value +'</strong></span>'
                                )
                            });
                        }
                    }
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
            url: uri+id+"/edit",
            method: "GET",
            dataType: "JSON",
            success: function(data) {
                var path        = data.photo == "" ? "images/no_image.png" : "images/user/";
                    html        = '<img width="100" src='+path+data.photo+'></img>';

                // passing from data to input text field
                $('#username').val(data.username).attr('readonly', 'true');
                $('#password').val(data.password);
                $('#name').val(data.name);
                $('#phone').val(data.phone);
                $('#birthdate').val(data.birthdate);
                $('#level option[value='+data.level+']').attr('selected', 'selected');
                $('.image-edit').html(html).show();
                $('#id').val(data.id);
                // showing modal and other customize for update
                modal.modal('show');
                title.text('Ubah Data Pengguna');
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
                    url: uri+id,
                    method: 'DELETE',
                    success: function(data) {
                        table.ajax.reload();
                        swal({
                            title: "Berhasil",
                            type: "success",
                            text: data.message,
                            timer: 2000,
                            showConfirmButton: false
                        })
                    }
                })
            }
        });
    });

    // profile
    // form validation
    $("#profile_form").validate({
        rules: {
            name: {
                required: true
            },
            phone: {
                required: true,
                number: true,
                rangelength: [10,14]
            },
            birthdate: {
                required: true
            },
            photo: {
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
            let html, path, img,
                formdata = new FormData($("#profile_form")[0]); // using formdata because we upload image

            $.ajax({
                url: "{{ URL::to('user/update-profile') }}",
                method: "POST",
                dataType: "JSON",
                enctype: "multipart/form-data",
                processData: false,
                cache: false,
                contentType: false,
                data: formdata,
                success: function(data)
                {
                    html = '';
                    path = window.location.origin+'/images/';
                    img  = data.photo == "" ? path+"no_avatar.png":path+"user/"+data.user.photo;
                    html = '<a href='+img+' data-lightbox="image-1">';
                    html += '<img src='+img+' width="100" height="80"></img>';
                    html += '</a>';

                    $('#name').val(data.user.name);
                    $('#phone').val(data.user.phone);
                    $('#photo').val('');
                    $('#profile_showImage').html(html);
                    $('img.profile-image').attr('src', img);

                    // sweetalert notify success
                    swal({
                        title: "Berhasil",
                        text: data.message,
                        type: "success",
                        timer: 2000,
                        showConfirmButton: false
                    });
                },
                error: function(xhr)
                {
                    // error notification config for unique data
                    let res = xhr.responseJSON;
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
                                '<div class="col-md-2 spasi" id="'+key+'"></div>' +
                                '<span class="help-block col-md-9" id="'+key+'"><strong>'+ value +'</strong></span>'
                            )
                        });
                    }
                }
            });
        }
    });

    // change password
    $("#password_form").validate({
        rules: {
            old_password: {
                required: true
            },
            password: {
                required: true,
                minlength: 3
            },
            password_confirmation: {
                required: true,
                minlength: 3
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
            remove_notification("old_password");
            remove_notification("password");
            remove_notification("password_confirmation");

            $.ajax({
                url: "{{ URL::to('user/update-password') }}",
                method: "POST",
                dataType: "JSON",
                data: $('#password_form').serialize(),
                success: function(data)
                {
                    // sweetalert notify success
                    swal({
                        title: "Berhasil!",
                        text: data.message,
                        type: "success",
                        timer: 2000,
                        showConfirmButton: false
                    });
                },
                error: function(xhr)
                {
                    // error notification config for unique data
                    let res = xhr.responseJSON;
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
                                '<div class="col-md-2 spasi" id="'+key+'"></div>' +
                                '<span class="help-block col-md-10" id="'+key+'"><strong>'+ value +'</strong></span>'
                            )
                        });
                    }
                }
            });
        }
    });
});
</script>
@endsection
