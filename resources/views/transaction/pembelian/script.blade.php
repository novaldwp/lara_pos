
@section('script')
<script>
$(document).ready(function(){

    $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
        }
    });

    deleteDummy();
    getPembelianCode();

    // select2 js config
    $('#supplier_id').select2({
        placeholder: "Pilih Supplier",
        allowclear: true
    });

    table = $("#data-table").DataTable({
              responsive: true,
              processing : true,
              serverSide : true,
              ajax: {
                url: "{{ route('transaction.pembelian.index') }}",
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
                  data: 'produk_beli',
                  name: 'produk_beli'
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

    function getPembelianDetail(){
        $('.tampil-detail').load('getPembelianDetail');
        $('.tampil-detail').show();
    }

    function deleteDummy(){
        $.ajax({
            url:'pembelian/deleteDummy',
            type:'POST'
        });
    }

    function goToTop()
    {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    }

    $('#produk_kode').on('input', function(e){
        let produk_kode = $('#produk_kode').val(),
            current     = $(location).attr('href');
            link        = current.replace("transaction/pembelian", "master/produk");

        if(produk_kode.length == 8) {
            $.ajax({
                url: link+'/getProductByCode/'+produk_kode,
                type: 'GET',
                dataType: 'JSON',
                success:function(data)
                {
                    let stok    = (data.produk.stok == null) ? '0' : data.produk.stok.stok_jumlah;

                    $('#produk_id').val(data.produk.produk_id);
                    $('#produk_nama').val(data.produk.produk_nama);
                    $('#produk_beli').val(data.produk.produk_beli);
                    $('#stok_jumlah').val(stok);
                },
                error: function(res)
                {
                    swal({
                        type: "error",
                        title: "Error!",
                        text: res.responseJSON.message,
                        timer: 2000,
                        showConfirmButton: false
                    })
                }
            });
        }
        else {
            $('#produk_id').val('');
            $('#produk_nama').val('');
            $('#produk_beli').val('');
            $('#stok_jumlah').val('');
        }
    });

    function getPembelianCode()
    {
        $.ajax({
            url:'pembelian/getPembelianCode',
            type: 'GET',
            dataType: 'JSON',
            success:function(data){
                $("#pembelian_kode").val(data);
            }
        });
    }

    $("#search").on('click', function(e){
        e.preventDefault();

        let modal = $('#formModal');

        modal.modal('show');
    });

    $('#data-table').on('click', '#select', function(e){
        e.preventDefault();

        let me      = $(this),
            id      = me.attr('data'),
            current = $(location).attr('href'),
            link    = current.replace("transaction/pembelian", "master/produk");

        $.ajax({
            url: link+'/getProductById/'+id,
            type: 'GET',
            dataType: 'JSON',
            success: function(data)
            {
                let stok    = (data.produk.stok == null) ? '0' : data.produk.stok.stok_jumlah,
                    modal   = $('#formModal');

                $('#produk_id').val(data.produk.produk_id);
                $('#produk_kode').val(data.produk.produk_kode);
                $('#produk_nama').val(data.produk.produk_nama);
                $('#produk_beli').val(data.produk.produk_beli);
                $('#stok_jumlah').val(stok);

                modal.modal('hide');
            }
        });
    });

    $('#tambah').on('click', function(e){
        e.preventDefault();

        let produk_id        = $('#produk_id').val(),
            pembelian_jumlah = $('#pembelian_jumlah').val(),
            produk_beli      = $('#produk_beli').val();

        if ($('#produk_id').val() == '')
        {
            swal({
                title: "Error!",
                text:"Pilih Produk Terlebih Dahulu.",
                type: "warning",
                timer: 1000,
                showConfirmButton: false
            });

            $('#produk_kode').focus();
        }
        else if ($('#pembelian_jumlah').val() == '')
        {
            swal({
                title: "Error!",
                text:"Input Jumlah Beli Terlebih Dahulu.",
                type: "warning",
                timer: 1000,
                showConfirmButton: false
            });

            $('#pembelian_jumlah').focus();
        }
        else{
            $.ajax({
                url:'pembelian/insertPembelianCart',
                type:'POST',
                dataType:'JSON',
                data:{produk_id:produk_id, pembelian_jumlah:pembelian_jumlah, produk_beli:produk_beli},
                success:function(res)
                {
                    $('#pembelian_jumlah').val('');
                    $('#produk_id').val('');
                    $('#produk_kode').val('');
                    $('#produk_beli').val('');
                    $('#produk_nama').val('');
                    $('#stok_jumlah').val('');
                    getPembelianDetail();
                    $('#produk_kode').focus();
                },
                error:function(xhr)
                {
                    let res = xhr.responseTEXT;

                    alert(res);
                }
            });
        }
    });

    $('body').on('keypress', 'input[name="qty-enter"]', function(e){
        let me      = $(this),
            id      = me.attr('produk-id'),
            qty     = parseInt(me.val());
            keycode = (e.keyCode ? e.keyCode :  e.which);

        if(keycode == 13)
        {
            $.ajax({
                url:'pembelian/'+id+'/enterPembelianCartQty',
                type:'GET',
                dataType:'JSON',
                data:{qty:qty},
                success:function()
                {
                    getPembelianDetail();
                    $('#produk_kode').focus();
                }
            });
        }
    });

    $('body').on('click', '#delete-detail', function(e) {
        e.preventDefault();

        let me  = $(this),
            produk_id   = me.attr('produk-id');

        $.ajax({
            url: 'pembelian/'+produk_id+'/deletePembelianCartItem',
            type: 'GET',
            dataType: 'JSON',
            success: function(res)
            {
                swal({
                    title: "Berhasil!",
                    text: res.message,
                    type: "success",
                    timer: 2000,
                    showConfirmButton: false
                });

                if (res.count == 0)
                {
                    $('.tampil-detail').hide();
                    goToTop();
                }
                else {
                    getPembelianDetail();
                }
            },
            error: function(res)
            {
                swal({
                    type: "error",
                    title: "Error!",
                    text: res.responseJSON.message,
                    timer: 2000,
                    showConfirmButton: false
                });
            }
        });
    });

    $('body').on('click', '#confirm', function(e){
        e.preventDefault();
        let pembelian_kode = $('#pembelian_kode').val(),
            supplier_id    = $('#supplier_id').val();

        if(supplier_id == "") {
            swal({
                title: "Peringatan!",
                text: "Pilih supplier terlebih dahulu!",
                type: "warning",
                timer: 2000,
                showConfirmButton: false
            });
        }
        else {
            swal({
            title: "Konfirmasi",
            text: "Apakah data sudah terisi dengan benar?",
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
                        url:"{{ route('transaction.pembelian.index') }}",
                        type:'POST',
                        dataType:'JSON',
                        data:{pembelian_kode:pembelian_kode, supplier_id:supplier_id},
                        success:function(res)
                        {
                            swal({
                                type: "success",
                                text: res.message,
                                timer: 2000,
                                showConfirmButton: false,
                            });

                            goToTop();
                            getPembelianCode();
                            $('.tampil-detail').hide();
                            $('#supplier_id').val('').trigger('change');
                        },
                        error:function(xhr)
                        {
                            let res = xhr.responseTEXT;

                            alert(res);
                        }
                    });
                }
            });
        }
    });
});
</script>
@endsection
