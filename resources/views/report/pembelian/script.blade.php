
@section('script')
<script>
$('document').ready(function(){
    $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
        }
    });

    // select2 js config
    $('#period').select2({
        allowclear: true
    });

    // config lightbox js
    lightbox.option({
        'disableScrolling': true,
        'showImageNumberLabel': false,
    })

    // config datatable for total pembelian
    $('#data-table').on('draw.dt', function() {
        let intVal, total, pageTotal;

        intVal = function(i) {
            return typeof i === "string" ?
            i.replace(/[\$,]/g, '') * 1 :
            typeof i === "number" ?
            i : 0;
        }

        total = table.column(6).data().reduce( function(a, b) {
                    a = convertToAngka(a);
                    b = convertToAngka(b);
            return (intVal(a)) + (intVal(b));
        }, 0);

        pageTotal = table.column(6, {page: 'current'}).data().reduce(function (a, b) {
            return intVal(a) + intVal(b);
        }, 0);

        $('.total').text(convertToRupiah(total));
    });

    table = $("#data-table").DataTable({
            responsive: true,
            processing : true,
            serverSide : true,
            ajax: {
                url: "{{ route('report.pembelian.index') }}",
                type: "GET",
                data: function(d) {
                    d.filter = $('#period').val();
                }
            },
            columns: [
            {
                data: 'DT_RowIndex',
                name: 'DT_RowIndex'
            },
            {
                data: 'pembelian_kode',
                name: 'pembelian_kode'
            },
            {
                data: 'supplier.supplier_nama',
                name: 'supplier.supplier_nama',
                orderable: false,
                searchable: false
            },
            {
                data: 'pembelian_detail[0].total',
                name: 'pembelian_detail[0].total',
                orderable: false,
                searchable: false
            },
            {
                data: 'pembelian_total',
                name: 'pembelian_total',
                orderable: false,
                searchable: false
            },
            {
                data: 'user.name',
                name: 'user.name',
                orderable: false,
                searchable: false
            },
            {
                data: 'tanggal',
                name: 'tanggal'
            },
            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
            }
            ],
            columnDefs: [
                {
                    className: 'text-center', targets: [3]
                }
            ],
            "oLanguage" :
            {
                "sSearch" : "Pencarian",
                "oPaginate" :
                    {
                        "sNext" : "Berikutnya",
                        "sPrevious" : "Sebelumnya",
                        "sFirst" : "Awal",
                        "sLast" : "Akhir",
                        "sEmptyTable" : "Data tidak ditemukan!"
                    }
            }
        });

    $('body').on('click', '#report-detail', function(e) {
        e.preventDefault();

        let id = $(this).attr('data');

        $.ajax({
            url: 'pembelian/'+id,
            method: 'GET',
            dataType: 'JSON',
            cache: false,
            success: function(data)
            {
                let i, gtotal;

                $('#report-body-table').find('.row-report-table').remove();
                $('#report-supplier-nama').text(data.supplier.supplier_nama);
                $('#report-supplier-alamat').text(data.supplier.supplier_alamat);
                $('#report-supplier-phone').text(data.supplier.supplier_phone);
                $('#report-pembelian-kode').text('No. Transaksi #'+data.pembelian_kode);
                $('#report-pembelian-tanggal').text(data.tanggal);
                $('#report-pembelian-nama').text(data.user.name);
                $('#report-pembelian-total').text(convertToRupiah(data.pembelian_total));

                for(i=0; i < data.pembelian_detail.length; i++)
                {
                    $('#report-body-table').append(
                        '<tr class="row-report-table">'+
                        '<td>'+data.pembelian_detail[i].produk.produk_kode+'</td>'+
                        '<td>'+data.pembelian_detail[i].produk.produk_nama+'</td>'+
                        '<td>'+data.pembelian_detail[i].detailpembelian_jumlah+'</td>'+
                        '<td>'+convertToRupiah(data.pembelian_detail[i].produk.produk_beli)+'</td>'+
                        '<td class="text-right">'+convertToRupiah(data.pembelian_detail[i].detailpembelian_subtotal)+'</td>'+
                        '</tr>'
                    );
                }
            }
        });

        $('#reportModal').modal('show');
    });

    $('body').on('change', '#period', function(e) {
        e.preventDefault();
        table.draw();
    });

    $('body').on('click', '#toPDF', function(e) {
        e.preventDefault();

        let filter = $('#period').val();

        $.ajax({
            url: 'pembelian/toPDF',
            method: 'POST',
            dataType: 'JSON',
            data: {filter:filter},
            success: function(data)
            {

            }
        });
    });
});
</script>
@endsection
