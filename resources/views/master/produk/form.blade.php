<div id="formModal" class="modal fade" role="dialog" aria-hidden="true" data-backdrop="static" tabindex="-1">
        <div class="modal-dialog">
              <div class="modal-content">
                    <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                          <h4 id="modal-title" class="modal-title">Tambah Supplier Baru</h4>
                    </div>
                    <form method="post" id="modal_form" class="form-horizontal" enctpye="multipart/form-data">
                          <div class="modal-body">
                                <span id="form_result"></span>
                                @csrf
                                <div class="form-group">
                                      <label class="control-label col-md-4">
                                            Kode Produk:
                                      </label>
                                      <div class="col-md-8">
                                            <input type="text" name="produk_kode" id="produk_kode" class="form-control" autocomplete="off" readonly>
                                      </div>
                                </div>
                                <div class="form-group">
                                      <label class="control-label col-md-4">
                                            Nama Produk:
                                      </label>
                                      <div class="col-md-8">
                                            <input type="text" name="produk_nama" id="produk_nama" class="form-control" autocomplete="off" autofocus>
                                      </div>
                                </div>
                                <div class="form-group">
                                      <label class="control-label col-md-4">
                                            Harga Beli:
                                      </label>
                                      <div class="col-md-8">
                                            <input type="text" name="produk_beli" id="produk_beli" class="form-control" autocomplete="off">
                                      </div>
                                </div>
                                <div class="form-group">
                                      <label class="control-label col-md-4">
                                            Harga Jual:
                                      </label>
                                      <div class="col-md-8">
                                            <input type="text" name="produk_jual" id="produk_jual" class="form-control" autocomplete="off">
                                      </div>
                                </div>
                                <div class="form-group">
                                      <label class="control-label col-md-4">
                                            Kategori:
                                      </label>
                                      <div class="col-md-8">
                                            <select name="kategori_id" id="kategori_id" class="form-control">
                                                <option value="" selected readonly></option>
                                                @foreach($kategori as $row)
                                                    <option value="{{ $row->kategori_id }}"> {{ $row->kategori_nama }}</option>
                                                @endforeach
                                            </select>
                                      </div>
                                </div>
                                <div class="form-group">
                                      <label class="control-label col-md-4">
                                            Gambar:
                                      </label>
                                      <div class="col-md-8">
                                            <div class="image-edit">
                                                <img></img>
                                                <br><br>
                                            </div>
                                            <input type="file" name="produk_image" id="produk_image" class="form-control" autocomplete="off">
                                      </div>
                                </div>
                                <div class="hidden">
                                      <input type="hidden" name="produk_id" id="produk_id">
                                </div>
                          </div>
                          <div class="modal-footer">
                                <input type="submit" name="action" id="action" class="btn btn-success" value="Save">
                          </div>
                    </form>
              </div>
        </div>
  </div>
