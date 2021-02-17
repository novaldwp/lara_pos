
@section('script')
<script>
$('document').ready(function(){
    let uri = 'penjualan/';

    $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#produk_kode').focus();
    clearPenjualanCart()

    function getPenjualanCart()
    {
        $('#detail-cart').load('penjualan/getPenjualanCart');
        $('#detail-cart').show();
    }

    function clearPenjualanCart()
    {
        $.ajax({
            url: uri+'clearPenjualanCart',
            type: 'POST'
        });
    }

    function payment_modal()
    {
        $('#penjualanModal').modal('show');
    }

    $('body').on('keyup', '#produk_kode', function(){
        var kode = $('#produk_kode').val();

        if(kode.length == 8)
        {
            $('#produk_kode').val("");
            $.ajax({
                url: uri+'insertPenjualanCart',
                type:'POST',
                dataType:'JSON',
                data:{kode:kode},
                success: function(res)
                {
                    getPenjualanCart();
                    $('#produk_kode').focus();
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
    });

    $('body').on('click', '#qty-plus', function(e){
        e.preventDefault();
        var me = $(this),
            id = me.attr('produk-id');

        $.ajax({
            url: uri+id+'/plusPenjualanCartQty',
            type: 'GET',
            dataType: 'JSON',
            success:function(res)
            {
                getPenjualanCart();
            }
        });
    });

    $('body').on('click', '#qty-minus', function(e){
        e.preventDefault();
        let me = $(this),
            id = me.attr('produk-id');

        $.ajax({
            url: uri+id+'/minusPenjualanCartQty',
            type: 'GET',
            dataType: 'JSON',
            success:function(res)
            {
                if (res.countCart != 0) {
                    getPenjualanCart();
                }
                else {
                    $('#detail-cart').hide();
                }
            }
        });
    });

    $('body').on('keypress', 'input[name="qty-enter"]', function(e){
        let me      = $(this),
            id      = me.attr('produk-id'),
            stok    = parseInt(me.attr('produk-stok')),
            qty     = parseInt(me.val());
            keycode = (e.keyCode ? e.keyCode :  e.which);

        if(keycode == 13)
        {
            if(qty > stok)
            {
                swal({
                    type: "error",
                    title: "Error!",
                    text: "Jumlah produk melebihi batas persediaan.",
                    timer: 2000,
                    showConfirmButton: false
                })
                me.val(stok);
            }
            else{
                $.ajax({
                    url:uri+id+'/enterPenjualanCartQty',
                    type:'GET',
                    dataType:'JSON',
                    data:{qty:qty},
                    success:function()
                    {
                        getPenjualanCart();
                        $('#produk_kode').focus();
                    }
                });
            }
        }
    });

    $('body').on('click', 'a#remove-item', function(e) {
        e.preventDefault();

        let me = $(this),
            id  = me.attr('produk-id');

        $.ajax({
            url: uri+id+'/deletePenjualanCartItem',
            type: 'GET',
            dataType: 'JSON',
            success: function(res)
            {
                if (res.countCart != 0)
                {
                    getPenjualanCart();
                }
                else {
                    $('#detail-cart').hide();
                }

                $('#produk_kode').focus();
            }
        });
    });

    $('body').on('keyup', '#member_kode', function(){
        let member_kode = $('#member_kode').val(),
            current     = $(location).attr('href'), // get url
            link        = current.replace("transaction/penjualan", "member/getMemberByCode/");

        if(member_kode.length == 7)
        {
            $.ajax({
                url: link+member_kode,
                type: 'GET',
                dataType: 'JSON',
                success: function(res)
                {
                    $('#member_nama').val(res.data);
                    $('#uang_bayar').trigger('focus');
                },
                error: function(res)
                {
                        swal({
                            type: "error",
                            title: "Error!",
                            text: "Pelanggan tidak ditemukan.",
                            timer: 2000,
                            showConfirmButton: false
                        })
                        .then(function(){
                            setTimeout(function(){
                                $('#member_kode').val('');
                                $('#member_kode').trigger('focus');
                            }, 300);
                        });
                }
            });
        }
        else{
            $('#member_nama').val('Umum');
        }
    });

    shortcut.add("Ctrl+Q", function(){
        $('#produk_kode').focus();
    });

    shortcut.add("F2", function(){
        clearPenjualanCart();

        $('#detail-cart').hide();
    });

    shortcut.add("F4", function(){
        payment_modal();
    });

    shortcut.add("F6", function(){
        $('#member_kode').focus();
    });

    shortcut.add("F7", function(){
        $('#uang_bayar').focus();
    });

    shortcut.add("F8", function(){
        var gtotal = $('#grand_total').val();
        $('#uang_bayar').val(gtotal);
    })

    $('body').on('click', '#pay', function(e){
        e.preventDefault();
        payment_modal();
    });

    $('body').on('click', '#reset', function(e) {
        e.preventDefault();
        clearPenjualanCart();

        $('#detail-cart').hide();
    })

    $('body').on('click', '#save', function(e){

        var uang_bayar = convertToAngka($('#uang_bayar').val()),
            gtotal     = convertToAngka($('#grand_total').val()),

            uang_bayar = uang_bayar ? uang_bayar:0;

        if(uang_bayar == 0)
        {
            swal({
                type: "warning",
                title: "Peringatan!",
                text: "Uang bayar tidak boleh kosong.",
                timer: 2000,
                showConfirmButton: false
            })
            .then(function(){
                setTimeout(function(){
                    $('#uang_bayar').trigger('focus');
                }, 300);
            });
        }
        else if(parseInt(gtotal) > parseInt(uang_bayar))
        {
            swal({
                type: "warning",
                title: "Peringatan!",
                text: "Uang bayar tidak boleh kurang tadi Grand Total.",
                timer: 2000,
                showConfirmButton: false
            });
        }
        else{
            $(this).attr('disabled', true);
            var no_penjualan    = $('#no_penjualan').val(),
                penjualan_kode  = $('#penjualan_kode').val();
                grand_total     = convertToAngka($('#grand_total').val()),
                uang_bayar      = convertToAngka($('#uang_bayar').val()),
                kembalian       = convertToAngka($('#kembalian').val()),
                cashier_id      = $('#cashier_name').attr('cashier-id');
                member_kode     = $('#member_kode').val();

            $.ajax({
                url: 'penjualan/insertPenjualanData',
                type: 'POST',
                dataType: 'html',
                data: {
                    grand_total:grand_total, uang_bayar:uang_bayar,
                    kembalian:kembalian, cashier_id:cashier_id, member_kode:member_kode, penjualan_kode:penjualan_kode
                },
                success:function(res)
                {
                    $(this).removeAttr('disabled');
                    $('#detail-cart').hide();
                    $('#penjualanModal').modal('hide');
                    swal({
                        type: "success",
                        title: "Success!",
                        text: "Proses Transaksi Penjualan Berhasil",
                        timer: 2000,
                        showConfirmButton: false
                    })
                    .then(function(){
                        var w = window.open(window.location.href,"_blank");
                        w.document.open();
                        w.document.write(res);
                        w.document.close();
                        w.window.print();
                        $('#no_penjualan').val('');
                        $('#grand_total').val('');
                        $('#uang_bayar').val('');
                        $('#kembalian').val('');
                        $('#id_member').val('');
                    })
                }
            });
        }
    });
});
</script>
@endsection
