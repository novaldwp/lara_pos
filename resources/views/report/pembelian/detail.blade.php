<div id="reportModal" class="modal fade" role="dialog" aria-hidden="true" data-backdrop="static" tabindex="-1">
        <div class="modal-dialog modal-lg">
              <div class="modal-content">
                    <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                          <h4 id="modal-title" class="modal-title">Detail Transaksi Pembelian</h4>
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
                                <p style="font-size:26px;" id="report-supplier-nama">Nama Supplier</p>
                                <p id="report-supplier-alamat">Alamat Supplier</p>
                                <p id="report-supplier-phone">No. Telp Supplier</p>
                            </div>
                            <div class="col-md-6 text-right">
                                <p style="font-size:26px;" id="report-pembelian-kode">No. Transaksi #PMB1029192</p>
                                <p id="report-pembelian-tanggal">Tanggal Pembelian</p>
                                <p id="report-pembelian-nama">Nama Petugas</p>
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
                                                <th class="text-right"><p id="report-pembelian-total">Total Pembelian</p></th>
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
