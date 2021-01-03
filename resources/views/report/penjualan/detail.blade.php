<div id="reportModal" class="modal fade" role="dialog" aria-hidden="true" data-backdrop="static" tabindex="-1">
        <div class="modal-dialog modal-lg">
              <div class="modal-content">
                    <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                          <h4 id="modal-title" class="modal-title">Detail Transaksi Penjualan</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 text-left">
                                <a href="{{ URL::to('images/pengaturan/'.$setting->setting_image) }}" data-lightbox="image-1">
                                    <img src="{{ URL::to('images/pengaturan/thumb/'.$setting->setting_image) }}" width="300" height="100"></img>
                                </a>
                            </div>
                            <div class="col-md-6 text-right">
                                <p style="font-size:30px;">{{ $setting->setting_nama ?? ''}}</p>
                                <p>{{ $setting->setting_alamat ?? '' }}</p>
                                <p>{{ $setting->setting_phone ?? '' }}</p>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-6 text-left">
                                <p style="font-size:26px;" id="report-pembeli-nama"></p>
                                <p id="report-pembeli-alamat"></p>
                                <p id="report-pembeli-phone"></p>
                            </div>
                            <div class="col-md-6 text-right">
                                <p style="font-size:26px;" id="report-penjualan-kode">No. Transaksi #PENJ1029192</p>
                                <p id="report-penjualan-tanggal"></p>
                                <p id="report-penjualan-nama"></p>
                            </div>
                            <br><br><br>
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table name="table-report" class="table table-striped table-hovered">
                                        <thead>
                                            <tr>
                                                <th>Kode Produk</th>
                                                <th>Nama Produk</th>
                                                <th>Quantity</th>
                                                <th>Harga</th>
                                                <th width="15%">Subtotal</th>
                                            </tr>
                                        </thead>
                                        <tbody id="report-body-table">

                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th colspan="3"></th>
                                                <th>Grand Total :</th>
                                                <th class="text-right"><p id="report-penjualan-total"></p></th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
              </div>
        </div>
  </div>
