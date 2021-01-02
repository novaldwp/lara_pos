<!-- Start of Bawah -->
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header">
                <h4>Detail Pembelian</h4>
                <hr>
            </div>
            <div class="box-body">
                <!-- Content body-->
                <div class="col-md-12">
                    <table class="table table-responsive table-hover table-striped" id="detail-table">
                        <thead>
                            <tr>
                                <th width="5%">No</th>
                                <th>Kode Produk</th>
                                <th>Nama Produk</th>
                                <th>Harga Beli</th>
                                <th class="text-center" width="20%">Jumlah</th>
                                <th>Sub Total</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $i = 1; @endphp
                            @foreach($pdummy as $row)
                            <tr>
                                <td>{{ $i++ }}</td>
                                <td>{{ $row->produk->produk_kode }}</td>
                                <td>{{ $row->produk->produk_nama }}</td>
                                <td>{{ $row->produk->produk_beli }}</td>
                                <td class="text-center">
                                    <input type="text" class="text-center" name="qty-enter" produk-id="{{ $row->produk_id }}" value="{{ $row->pembelian_jumlah }}" style="width:20%" autocomplete="off">
                                </td>
                                <td>{{ $row->subtotal }}</td>
                                <td><a href="#" class="btn btn-danger" id="delete-detail" produk-id="{{ $row->produk_id }}" data-toggle="tooltip" title="Hapus"><span class="fa fa-trash"></span></a></td>
                            </tr>
                            @endforeach
                            <tr>
                                <td colspan="4" ></td>
                                <td align="left"><strong>Grand Total:</strong></td>
                                <td colspan="2" aling="left"><strong>{{ $gtotal }}</strong></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="box-footer">
                    <button class="btn btn-success col-sm-12" name="confirm" id="confirm" url="{{ route('transaction.pembelian.store') }}">Simpan</button>
                </div>
            <!-- End of Content body-->
        </div>
    </div>
</div>
<!-- End of Bawah -->
