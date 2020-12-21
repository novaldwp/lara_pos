@extends('layouts.app')

@section('title')
  Transaksi Produk
@endsection

@section('breadcrumb')
   @parent
   <li>Transaksi</li>
@endsection

@section('content')
<!-- Start of Kiri -->
<div class="row">
    <div class="col-sm-12">
        <div class="box">
            <div class="box-body">
            <!-- Content body-->
            <div class="col-sm-6">
                <!-- left column -->
                    <form class="form-horizontal">
                        <div class="form-group">
                            <label class="control-label col-sm-4">Scan Barcode [Ctrl+Q] :</label>
                            <div class="col-sm-8">
                                <input type="text" placeholder="Scan Barcode disini.." class="form-control" id="produk_kode" name="produk_kode">
                            </div>
                        </div>
                    </form>
                <!-- end of left column -->
                </div>
                <div class="col-sm-12" id="detail-cart">

                </div>
            </div>
            <!-- End of Content body-->
        </div>
    </div>
</div>

@endsection

@section('script')
<script>
$('document').ready(function(){

    $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#produk_kode').focus();
    clear_penjualan_cart()

    function get_penjualan_cart(){
        $('#detail-cart').load('get_penjualan_cart');
        $('#detail-cart').show();
    }

    function clear_penjualan_cart(){
        $.ajax({
            url: 'produk/clear_penjualan_cart',
            type: 'POST'
        })
    }

    function payment_modal(){
        $('#penjualanModal').modal('show');
    }

    $('body').on('keyup', '#produk_kode', function(){
        var kode = $('#produk_kode').val();

        if(kode.length == 7)
        {
            $('#produk_kode').val("");
            $.ajax({
                url:'produk/insert_penjualan_cart',
                type:'POST',
                dataType:'JSON',
                data:{kode:kode},
                success:function(res)
                {
                    get_penjualan_cart();
                    $('#produk_kode').focus();
                }
            })

        }
    })

    $('body').on('keyup', '#member_kode', function(){
        var member_kode = $('#member_kode').val();

        if(member_kode.length == 9)
        {
            $.ajax({
                url:'member/get-member-by-kode/'+member_kode,
                type: 'GET',
                dataType: 'JSON',
                success:function(res)
                {
                    $('#member_nama').val(res);
                }
            })
        }
        else{
            $('#member_nama').val('Umum');
        }


    })

    $('body').on('click', '#qty-plus', function(e){
        e.preventDefault();
        var me = $(this),
            id = me.attr('produk-id');

        $.ajax({
            url: 'produk/'+id+'/plus_penjualan_cart',
            type: 'GET',
            dataType: 'JSON',
            success:function()
            {
                get_penjualan_cart();
            }
        })

    })

    $('body').on('click', '#qty-minus', function(e){
        e.preventDefault();
        var me = $(this),
            id = me.attr('produk-id');

        $.ajax({
            url: 'produk/'+id+'/minus_penjualan_cart',
            type: 'GET',
            dataType: 'JSON',
            success:function()
            {
                get_penjualan_cart();
            }
        })

    })

    $('body').on('keypress', 'input[name="qty-enter"]', function(e){
        var me      = $(this),
            id      = me.attr('produk-id'),
            stok    = parseInt(me.attr('produk-stok')),
            qty     = parseInt(me.val());
            keycode = (e.keyCode ? e.keyCode :  e.which);

        if(keycode == 13)
        {
            if(qty > stok)
            {
                swal({
                    type: "warning",
                    title: "Warning!",
                    text: "Quantity exceeds the available stock limit",
                    timer: 2000,
                    showConfirmButton: false
                })

                me.val(stok);
            }
            else{
                $.ajax({
                    url:'produk/'+id+'/enter_penjualan_cart',
                    type:'GET',
                    dataType:'JSON',
                    data:{qty:qty},
                    success:function()
                    {
                        get_penjualan_cart();
                        $('#produk_kode').focus();
                    }
                })
            }
        }

    })

    shortcut.add("Ctrl+Q", function(){
        $('#produk_kode').focus();
    });

    shortcut.add("F2", function(){
        $.ajax({
            url: 'produk/clear_penjualan_cart',
            type: 'POST',
            success:function(res)
            {
                $('#detail-cart').hide();
            }
        })
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

    $('body').on('click', '#save', function(e){

        var uang_bayar = convertToAngka($('#uang_bayar').val()),
            gtotal     = convertToAngka($('#grand_total').val()),

            uang_bayar = uang_bayar ? uang_bayar:0;

        if(uang_bayar == 0)
        {
            swal({
                type: "warning",
                title: "Warning!",
                text: "The payment amount cannot be empty!",
                timer: 2000,
                showConfirmButton: false
            })
            .then(function(){
                setTimeout(function(){
                    $('#uang_bayar').trigger('focus');
                }, 300);
            })
        }
        else if(gtotal > uang_bayar)
        {
            swal({
                type: "error",
                title: "Error!",
                text: "The payment amount cannot be less than grand total!",
                timer: 2000,
                showConfirmButton: false
            })
        }
        else{
            $(this).attr('disabled', true);
            var no_penjualan = $('#no_penjualan').val(),
                grand_total  = convertToAngka($('#grand_total').val()),
                uang_bayar   = convertToAngka($('#uang_bayar').val()),
                kembalian    = convertToAngka($('#kembalian').val()),
                cashier_id   = $('#cashier_name').attr('cashier-id');
                id_member    = $('#id_member').val(),
                id_member    = id_member ? id_member : 0;

            $.ajax({
                url: 'produk/insert-penjualan-data',
                type: 'POST',
                dataType: 'JSON',
                data: {
                    no_penjualan:no_penjualan, grand_total:grand_total, uang_bayar:uang_bayar,
                    kembalian:kembalian, cashier_id:cashier_id, id_member:id_member
                },
                success:function(res)
                {
                    $(this).removeAttr('disabled');
                    get_penjualan_cart();
                    $('#penjualanModal').modal('hide');
                    swal({
                        type: "success",
                        title: "Success!",
                        text: "The payment is successfully complete!",
                        timer: 2000,
                        showConfirmButton: false
                    })
                    .then(function(){
                        $('#no_penjualan').val('');
                        $('#grand_total').val('');
                        $('#uang_bayar').val('');
                        $('#kembalian').val('');
                        $('#id_member').val('');

                    })
                }
            })
        }
    });
});
</script>
@endsection
