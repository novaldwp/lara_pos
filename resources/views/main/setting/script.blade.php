@section('script')
<script>
    $(document).ready(function(){

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
            }
        });

    // config lightbox js
    lightbox.option({
        'disableScrolling': true,
        'showImageNumberLabel': false,
    })

    $("#setting_form").validate({
        rules: {
            setting_nama: {
                required: true
            },
            setting_phone: {
                required: true,
                number: true,
                rangelength: [10,14]
            },
            setting_alamat: {
                required: true
            },
            setting_image: {
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
        submitHandler: function(form) {
            let formdata    = new FormData($("#setting_form")[0]);

            $.ajax({
                url: "{{ route('setting.store') }}",
                method: "POST",
                dataType: "JSON",
                enctype: "multipart/form-data",
                processData: false,
                cache: false,
                contentType: false,
                data: formdata,
                success: function(data)
                {
                    let imagePath   = 'images/',
                        image = (data.setting.setting_image != "") ? 'images/pengaturan/'+data.setting.setting_image : 'images/no_image.png',
                        html = '<a href='+image+' data-lightbox="image-1">';
                        html += '<img src='+image+' width="100" height="80"></img>';
                        html += '</a>';

                    $('#setting_id').val(data.setting.setting_id);
                    $('#setting_nama').val(data.setting.setting_nama);
                    $('#setting_phone').val(data.setting.setting_phone);
                    $('#setting_alamat').val(data.setting.setting_alamat);
                    $('#setting_image').val('');

                    $('#setting_showImage').html(html);

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
@endsection
