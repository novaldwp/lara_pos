@php $i = 1; @endphp
    @foreach($pdummy as $row)
    <tr>
        <td>{{ $i++ }}</td>
        <td>{{ $row->produk->produk_kode }}</td>
        <td>{{ $row->produk->produk_nama }}</td>
        <td>{{ $row->dummy_harga }}</td>
        <td class="text-center">
            <a href="#" class="btn btn-danger btn-sm" id="qty-minus" produk-id="{{ $row->produk_id }}"><i class="fa fa-minus"></i></a>
            <input type="text" class="text-center" name="qty" id="qty" produk-id="{{ $row->produk_id }}" value="{{ $row->dummy_qty }}" style="width:20%">
            <a href="#" class="btn btn-success btn-sm" id="qty-plus" produk-id="{{ $row->produk_id }}"><i class="fa fa-plus"></i></a>
        </td>
        <td class="text-right">{{ $row->dummy_subtotal }}</td>
        <td>
            <a href"#" class="btn btn-danger" id="remove-item" name="remove-item" produk-id="{{ $row->produk_id }}">
                <i class="fa fa-trash"></i>
            </a>
        </td>
    </tr>
    @endforeach

    <tr>
        <td colspan="5" class="text-right"><label>Grand Total: </label></td>
        <td class="text-right">Rp. {{ $gtotal}}</td>
    </tr>
