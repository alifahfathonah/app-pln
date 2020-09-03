<!-- Modal -->
<div class="modal fade" id="modal" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="modal-label" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-label"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?= form_open('', 'class="form-horizontal" id="form-peminjaman-kendaraan"') ?>
                <input type="hidden" name="id" id="id">
                <input type="hidden" name="no_dokumen" id="no_dokumen" value="FM-SMK3-VHC-<?= sprintf("%04s", $no_dokumen) ?>">
                <div class="row">
                    <div class="col-lg-8">
                        <h6><b>INFROMASI DASAR</b></h6>
                        <hr>
                        <div class="form-group">
                            <label>Kendaraan</label><br>
                            <input type="text" class="select2-input reset-form" name="kendaraan" id="kendaraan">
                            <em class="help-block error invalid-feedback"></em>
                        </div>
                        <div class="form-group">
                            <label>Nominal Voucher <small>(Optional)</small></label>
                            <input type="text" class="form-control reset-form" name="voucher" id="voucher">
                            <em class="help-block error invalid-feedback"></em>
                        </div>
                        <div class="form-group form-check">
                            <input type="checkbox" class="form-check-input" name="is_use_driver" value="1" id="is-use-driver">
                            <label class="form-check-label" for="is-use-driver">Gunakan Driver</label>
                            <div class="alert alert-secondary" role="alert">
                                <small><i class="fas fa-info-circle mr-2 text-primary"></i>Centang untuk memilih Driver</small>
                            </div>
                        </div>
                        <div class="form-group driver">
                            <label>Driver</label><br>
                            <input type="text" class="select2-input reset-form" name="driver" id="driver">
                            <em class="help-block error invalid-feedback"></em>
                        </div>
                        <div class="form-group">
                            <label>Tujuan</label>
                            <input type="text" class="form-control reset-form" name="tujuan" id="tujuan">
                            <em class="help-block error invalid-feedback"></em>
                        </div>
                        <div class="form-group">
                            <label>Keterangan <small>(Optional)</small></label>
                            <textarea name="keterangan" id="keterangan" class="form-control reset-form" rows="3"></textarea>
                            <em class="help-block error invalid-feedback"></em>
                        </div>
                        <div class="form-group">
                            <label>Tanggal Peminjaman</label>
                            <div class="row">
                                <div class="col-lg-5">
                                    <input type="text" class="form-control" name="tgl_start" id="tgl-start" value="<?= date('d/m/Y H:i') ?>">
                                </div>
                                <div class="col-lg-1">
                                    <h6 class="mt-2">S/D</h6>
                                </div>
                                <div class="col-lg-5">
                                    <input type="text" class="form-control" name="tgl_end" id="tgl-end" value="<?= date('d/m/Y H:i') ?>">
                                    <em class="help-block error invalid-feedback"></em>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Diajukan Oleh</label><br>
                            <input type="text" class="select2-input reset-form" name="users" id="users">
                            <em class="help-block error invalid-feedback"></em>
                        </div>

                        <hr>
                        <?php if($persetujuan): ?>
                            <h6><b>PERSETUJUAN</b></h6>
                            <?php foreach($persetujuan as $row): ?>
                            <div class="form-group persetujuan">
                                <?php if($row->label !== null): ?>
                                <label><?= $row->label ?></label><br>    
                                <?php else: ?>
                                <label><?= $row->divisi ?></label><br>
                                <?php endif ?>
                                
                                <input type="text" class="form-control" value="<?= $row->divisi ?> - <?= $row->users ?>" readonly>
                                <input type="hidden" class="form-control" name="atasan[]" value="<?= $row->id_users ?>">
                                <em class="help-block error invalid-feedback"></em>
                            </div>
                            <?php endforeach ?>
                            <div class="alert alert-secondary" role="alert">
                                <small><i class="fas fa-info-circle mr-2 text-primary"></i>Dokumen ini membutuhkan persetujuan <b>Atasan</b> yang dipilih.</small>
                            </div> 
                        <?php endif ?>
                    </div>
                    <div class="col-lg-4">
                        <h6><b>INFORMASI KENDARAAN</b></h6>
                        <hr>
                        <div class="content-informasi-kendaraan">
                            <small><span id="detail-kendaraan">Tidak ada informasi kendaraan</span></small>
                        </div>
                        <br>
                        <h6><b>INFORMASI DRIVER</b></h6>
                        <hr>
                        <div class="content-informasi-kendaraan">
                            <small><span id="detail-driver">Tidak ada informasi driver</span></small>
                        </div>
                    </div>
                </div>
                <br>
                <hr>
                <h6><b>PERSONIL</b></h6>
                <div id="load-content-personil"></div>
                <button type="button" class="btn btn-success btn-block" id="btn-tambah-personil" onclick="tambah_input_personil()"><i class="fas fa-plus-circle mr-2"></i>Tambah</button>
                <?= form_close() ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-dismiss="modal"><i class="fas fa-times-circle mr-2"></i>Keluar</button>
                <button type="button" class="btn btn-primary" id="btn-simpan" onclick="konfirmasi_simpan()"><i class="fas fa-save mr-2"></i>Simpan</button>
            </div>
        </div>
    </div>
</div>