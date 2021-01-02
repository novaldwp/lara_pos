<div id="formModal" class="modal fade" role="dialog" aria-hidden="true" data-backdrop="static" tabindex="-1">
      <div class="modal-dialog">
            <div class="modal-content">
                  <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 id="modal-title" class="modal-title">Tambah Kategori Baru</h4>
                  </div>
                  <form name="kategori" method="post" id="modal_form" class="form-horizontal" enctpye="multipart/form-data">
                        <div class="modal-body">
                              <span id="form_result"></span>
                              @csrf
                              <div class="form-group">
                                    <label class="control-label col-md-4">
                                          Nama Kategori:
                                    </label>
                                    <div class="col-md-8">
                                          <input type="text" name="kategori_nama" id="kategori_nama" class="form-control" autocomplete="off" autofocus>
                                    </div>
                              </div>
                              <div class="hidden">
                                    <input type="hidden" name="kategori_id" id="kategori_id">
                              </div>
                        </div>
                        <div class="modal-footer">
                              <input type="submit" name="action" id="action" class="btn btn-success" value="Save">
                        </div>
                  </form>
            </div>
      </div>
</div>
