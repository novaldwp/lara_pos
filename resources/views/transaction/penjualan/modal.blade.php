<div id="penjualanModal" class="modal fade" role="dialog" aria-hidden="true" data-backdrop="static" tabindex="-1">
    <div class="modal-dialog modal-lg">
          <div class="modal-content" style="border-radius: 10px;">
                <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                      <h4 id="modal-title" class="modal-title">Menu Pembayaran</h4>
                </div>

                <div class="modal-body">
                <form class="form-horizontal">
                    <div class="row"> <!-- start row-->
                            <div class="col-sm-12">
                                <div class="col-sm-6">
                                <!-- Start left column -->

                                    <div class="form-group">
                                        <label class="control-label col-sm-4">Nama Kasir:</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="cashier_name" cashier-id="{{ Auth::user()->id }}" name="cashier_name" value="{{ Auth::user()->name }}" readonly>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                            <label class="control-label col-sm-4">Tanggal:</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" id="tanggal" name="tanggal" value="<?php echo date('d-m-Y'); ?>" readonly>
                                            </div>
                                        </div>

                                    <div class="form-group">
                                        <label class="control-label col-sm-4">Kode Pembeli:</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="member_kode" name="member_kode" maxlength="7" pattern="[0-7]" value="" autocomplete="off">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-sm-4">Nama Pembeli:</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="member_nama" name="member_nama" value="Umum" readonly>
                                        </div>
                                    </div>

                                <!-- end of left column -->
                                </div>
                                <div class="col-sm-6">
                                <!-- start right column -->

                                <div class="form-group">
                                    <label class="control-label col-sm-4">No. Penjualan:</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="penjualan_kode" name="penjualan_kode" readonly>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-sm-4">Grand Total:</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="grand_total" name="grand_total" value="{{ convert_to_rupiah_without_prefix($gtotal) }}" readonly>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-sm-4">Uang Bayar:</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="uang_bayar" name="uang_bayar" pattern="[0-9]" required autocomplete="off">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-sm-4">Kembalian:</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="kembalian" name="kembalian" value="0" readonly>
                                    </div>
                                </div>
                                <!-- end of right column -->
                                </div>
                            </div>
                    </div> <!-- end of rows-->
                    <div class="row">
                        <hr>
                        <div class="col-sm-6">
                            <dl>
                                <dt><b>*Keterangan :</b></dt>
                                <div class="data-description" style="margin-left:25%">
                                    <dd><b>[F6]</b> = Kode Pembeli</dd>
                                    <dd><b>[F7]</b> = Uang Bayar</dd>
                                    <dd><b>[F8]</b> = Uang Pas</dd>
                                </div>
                            </dl>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <div class="row">
                        <div class="col-sm-12">
                            <a href="javascript:void(0);" class="btn btn-success" name="save" id="save"><i class="fa fa-save"></i> Simpan</a>
                        </div>
                    </div>
                </div>
                </form>
          </div>
    </div>
</div>

<script>
    $(document).ready(function(){
        let uri = 'penjualan/';

        getPenjualanCode();

        $( '#uang_bayar' ).mask('0.000.000.000', {reverse: true});

        $('body').on('keyup', '#uang_bayar', function(){
            // set variable
            uang = convertToAngka($(this).val());
            gtotal = convertToAngka($('#grand_total').val());

            // kalkulasi uang bayar - grand total
            kembalian = uang - gtotal;

            // jika valuenya NaN akan di convert ke 0
            kembalian = kembalian ? kembalian : 0;

            $('#kembalian').val(convertToRupiah(kembalian));
        });

        function getPenjualanCode()
        {
            $.ajax({
                url: uri+'getPenjualanCode',
                method: 'GET',
                success: function(data)
                {
                    $('#penjualan_kode').val(data);
                }
            });
        }
    })
</script>
