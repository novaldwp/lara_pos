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
                                            Nama Supplier:
                                      </label>
                                      <div class="col-md-8">
                                            <input type="text" name="supplier_nama" id="supplier_nama" class="form-control" autocomplete="off" autofocus>
                                      </div>
                                </div>
                                <div class="form-group">
                                      <label class="control-label col-md-4">
                                            Kontak:
                                      </label>
                                      <div class="col-md-8">
                                            <input type="text" name="supplier_kontak" id="supplier_kontak" class="form-control" autocomplete="off">
                                      </div>
                                </div>
                                <div class="form-group">
                                      <label class="control-label col-md-4">
                                            No. Telp:
                                      </label>
                                      <div class="col-md-8">
                                            <input type="text" name="supplier_phone" id="supplier_phone" class="form-control" autocomplete="off">
                                      </div>
                                </div>
                                <div class="form-group">
                                      <label class="control-label col-md-4">
                                            Alamat:
                                      </label>
                                      <div class="col-md-8">
                                            <textarea name="supplier_alamat" id="supplier_alamat" class="form-control" cols="58" rows="3" autocomplete="off"></textarea>
                                        </div>
                                </div>
                                <div class="hidden">
                                      <input type="hidden" name="supplier_id" id="supplier_id">
                                </div>
                          </div>
                          <div class="modal-footer">
                                <input type="submit" name="action" id="action" class="btn btn-success" value="Save">
                          </div>
                    </form>
              </div>
        </div>
  </div>
