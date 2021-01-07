<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
</head>
<style>
    html{
        width:50%;
        height:20%;
        padding-left: 27%
    },
</style>
<body>
    <table align="center" width="100%" style="border-collapse: collapse; border: 0px;">
        <thead>
            <tr>
                <td colspan="4" align="center">{{ $setting->setting_nama }}</td>
            </tr>
            <tr>
                <td colspan="4" align="center">{{ $setting->setting_alamat }}</td>
            </tr>
            <tr style="border-bottom:2px solid black; border-bottom-style:dashed;">
                <td colspan="4" align="center" style="padding-bottom:7px;">{{ $setting->setting_phone }}</td>
            </tr>
        </thead>
        <tbody>
            <tr style="border-bottom:2px solid black; border-bottom-style:dashed;">
                <td>Nama</td>
                <td>Qty</td>
                <td>Harga</td>
                <td align="center">Subtotal</td>
            </tr>
            @foreach($data->penjualan_detail as $row)
            <tr>
                <td>{{ substr($row->produk->produk_nama, 0, 25) }}</td>
                <td>{{ $row->detailpenjualan_qty }}</td>
                <td>{{ convert_to_rupiah($row->detailpenjualan_harga) }}</td>
                <td align="right">{{ convert_to_rupiah($row->detailpenjualan_subtotal) }}</td>
            </tr>
            @endforeach
            <tr style="border-top:2px solid black; border-top-style:dashed;">
                <td colspan="1">Grand Total</td>
                <td colspan="2">:</td>
                <td align="right">{{ convert_to_rupiah($data->penjualan_total) }}</td>
            </tr>
            <tr>
                <td colspan="1">Uang Bayar</td>
                <td colspan="2">:</td>
                <td align="right">{{ convert_to_rupiah($data->penjualan_nominal) }}</td>
            </tr>
            <tr style="border-bottom:2px solid black; border-bottom-style:dashed;">
                <td colspan="1">Kembalian</td>
                <td colspan="2">:</td>
                <td align="right">{{ convert_to_rupiah($data->penjualan_kembalian) }}</td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <td>Operator</td>
                <td>:</td>
                <td colspan="2" align="right">{{ $data->user->name }}</td>
            </tr>
            <tr>
                <td>Pembeli</td>
                <td>:</td>
                <td colspan="2" align="right">{{ $data->member->member_nama ?? 'Umum' }}</td>
            </tr>
            <tr>
                <td>No. Transaksi</td>
                <td>:</td>
                <td colspan="2" align="right">{{ $data->penjualan_kode }}</td>
            </tr>
            <tr>
                <td>Tanggal</td>
                <td>:</td>
                <td colspan="2" align="right">{{ tanggal_indonesia($data->created_at) }}</td>
            </tr>
            <tr>
                <td colspan="4" align="center" style="padding-top:8px;">
                    <p>BARANG YANG SUDAH DIBELI TIDAK DAPAT DIKEMBALIKAN.</p>
                    TERIMA KASIH
                </td>
            </tr>
        </tfoot>
    </table>
</body>
</html>
