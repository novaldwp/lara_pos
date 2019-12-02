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
        <table class="table table-responsive table-hover table-striped" id="detail-table">
            <thead>
                <tr>
                    <th width="30">No</th>
                    <th>Kode Produk</th>
                    <th>Nama Produk</th>
                    <th>Harga Beli</th>
                    <th>Jumlah</th>
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
                    <td>{{ $row->pembelian_jumlah }}</td>
                    <td>{{ $row->produk->produk_beli * $row->pembelian_jumlah }}</td>
                    <td>Edit | Delete</td>
                </tr>
                @endforeach
                <tr>
                    <td colspan="4" ></td>
                    <td align="left"><strong>Grand Total:</strong></td>
                    <td colspan="2" aling="left"><strong>{{ $gtotal }}</strong></td>
                </tr>
            </tbody>
        </table>

        <!-- End of Content body-->
        </div>
      </div>
    </div>
</div>
<!-- End of Bawah -->
