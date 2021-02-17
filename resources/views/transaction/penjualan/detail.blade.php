<hr>
    <table class="table table-responsive table-hover table-striped" id="detail-penjualan" name="detail-penjualan">
        <thead>
            <tr>
                <th>#</th>
                <th>Kode Produk</th>
                <th>Nama Produk</th>
                <th>Harga</th>
                <th class="text-center" width="20%">Qty</th>
                <th class="text-center">Subtotal</th>
                <th></th>
            </tr>
        </thead>
        <tbody id="">
            @php $i = 1; @endphp
            @if($pdummy->count() != 0)
                @foreach($pdummy as $row)
                <tr>
                    <td>{{ $i++ }}</td>
                    <td>{{ $row->produk->produk_kode }}</td>
                    <td>{{ $row->produk->produk_nama }}</td>
                    <td>{{ $row->dummy_harga }}</td>
                    <td class="text-center">
                        <a href="#" class="btn btn-danger btn-sm" id="qty-minus" produk-id="{{ $row->produk_id }}"><i class="fa fa-minus"></i></a>
                        <input type="text" class="text-center" name="qty-enter" produk-id="{{ $row->produk_id }}" produk-stok="{{ $row->produk->stok['stok_jumlah'] }}" value="{{ $row->dummy_qty }}" style="width:20%" autocomplete="off">
                        <a href="#" class="btn btn-success btn-sm" id="qty-plus" produk-id="{{ $row->produk_id }}"><i class="fa fa-plus"></i></a>
                    </td>
                    <td class="text-right">{{ $row->dummy_subtotal }}</td>
                    <td class="text-center">
                        <a href"#" class="btn btn-danger" id="remove-item" name="remove-item" produk-id="{{ $row->produk_id }}">
                            <i class="fa fa-trash"></i>
                        </a>
                    </td>
                </tr>
                @endforeach

                <tr>
                    <td colspan="5" class="text-right"><label><h2>Grand Total: </h2></label></td>
                    <td class="text-right"><h2>{{ convert_to_rupiah($gtotal) }}</h2></td>
                    <td></td>
                </tr>
            <tbody>
            @else
            <tbody>
                <tr>
                    <td colspan="6" class="text-center"><i class="fa fa-bell-o"></i>No data available.</td>
                </tr>
            </tbody>
            @endif
    </table>

    <div class="col-sm-12">
        <div class="form-button text-center">
            <a href="javascript:void(0);" class="btn btn-danger" name="reset" id="reset">Reset [F2]</a>
            &nbsp;&nbsp;&nbsp;
            <a href="javascript:void(0);" class="btn btn-success" name="pay" id="pay">Bayar [F4]</a>
        </div>
    </div>

@include('transaction.penjualan.modal')
