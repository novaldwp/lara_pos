<div id="formModal" class="modal fade" role="dialog" aria-hidden="true" data-backdrop="static" tabindex="-1">
        <div class="modal-dialog">
              <div class="modal-content">
                    <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                          <h4 id="modal-title" class="modal-title">Tambah Pengguna Baru</h4>
                    </div>
                    <form method="post" id="modal_form" class="form-horizontal" enctpye="multipart/form-data">
                          <div class="modal-body">
                                <span id="form_result"></span>
                                @csrf
                                <div class="form-group">
                                      <label class="control-label col-md-4">
                                            Username:
                                      </label>
                                      <div class="col-md-8">
                                            <input type="text" name="username" id="username" class="form-control" autocomplete="off" autofocus>
                                      </div>
                                </div>
                                <div class="form-group">
                                      <label class="control-label col-md-4">
                                            Nama Lengkap:
                                      </label>
                                      <div class="col-md-8">
                                            <input type="text" name="name" id="name" class="form-control" autocomplete="off">
                                      </div>
                                </div>
                                <div class="form-group">
                                      <label class="control-label col-md-4">
                                            No. Handphone:
                                      </label>
                                      <div class="col-md-8">
                                            <input type="text" name="phone" id="phone" class="form-control" autocomplete="off">
                                      </div>
                                </div>
                                <div class="form-group">
                                      <label class="control-label col-md-4">
                                            Tanggal Lahir:
                                      </label>
                                      <div class="col-md-8">
                                            <input type="text" name="birthdate" id="birthdate" class="form-control datepicker" data-date-format="dd-mm-yyyy" autocomplete="off">
                                      </div>
                                </div>
                                <div class="form-group">
                                      <label class="control-label col-md-4">
                                            Posisi:
                                      </label>
                                      <div class="col-md-8">
                                            <select name="level" id="level" class="form-control">
                                                <option value="" selected readonly></option>
                                                <option value="1">Administrator</option>
                                                <option value="2">Operator</option>
                                            </select>
                                      </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-4">
                                          Photo:
                                    </label>
                                    <div class="col-md-8">
                                          <div class="image-edit">
                                              <img></img>
                                              <br>
                                          </div>
                                          <input type="file" name="photo" id="photo" class="form-control" autocomplete="off">
                                    </div>
                              </div>
                                <div class="hidden">
                                      <input type="hidden" name="id" id="id">
                                </div>
                          </div>
                          <div class="modal-footer">
                                <input type="submit" name="action" id="action" class="btn btn-success" value="Save">
                          </div>
                    </form>
              </div>
        </div>
  </div>
