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
                <?= form_open('', 'class="form-horizontal" id="form-peminjaman-ruangan"') ?>
                <input type="hidden" name="id" id="id">
                <div class="row">
                    <div class="col-lg-8">
                        <h6><b>Informasi Dasar</b></h6>
                        <small><em>Informasi kegiatan dan tanggal peminjaman ruangan</em></small>
                        <hr>
                        <div class="form-group tight">
                            <label>Ruangan</label>
                            <?= form_dropdown('ruangan', $ruangan, array(), 'id=ruangan class="form-control reset-form"') ?>
                            <em class="help-block error invalid-feedback"></em>
                        </div>
                        <div class="form-group tight">
                            <label>Nama Kegiatan</label>
                            <input type="text" name="nama_kegiatan" id="nama-kegiatan" class="form-control reset-form">
                            <em class="help-block error invalid-feedback"></em>
                        </div>
                        <div class="form-group tight">
                            <label>Jumlah Orang</label>
                            <textarea name="jumlah_orang" id="jumlah-orang" rows="3" class="form-control reset-form"></textarea>
                            <em class="help-block error invalid-feedback"></em>
                        </div>
                        <!-- <div class="form-group tight">
                            <label>Makan Siang</label><br>
                            <input type="text" name="makan_siang" id="makan-siang" class="select2-input reset-form">
                            <em class="help-block error invalid-feedback"></em>
                        </div> -->
                        <div class="form-group tight">
                            <label>Makan Siang</label><br>
                            <?= form_dropdown('makan_siang', array('Tidak' => 'Tidak', 'Ada' => 'Ada'), array(), 'id=makan-siang class="form-control reset-form"') ?>
                            <em class="help-block error invalid-feedback"></em>
                        </div>
                        <div class="form-group tight makan-siang_">
                            <label>Jumlah Orang <small>(makan siang)</small></label><br>
                            <input type="text" name="jumlah_orang_makan-siang" id="jumlah-orang-makan-siang" class="form-control reset-form">
                            <em class="help-block error invalid-feedback"></em>
                        </div>
                        <div class="form-group tight">
                            <label>Snack</label><br>
                            <?= form_dropdown('snack', array('Tidak' => 'Tidak', 'Ada' => 'Ada'), array(), 'id=snack class="form-control reset-form"') ?>
                            <em class="help-block error invalid-feedback"></em>
                        </div>
                        <div class="form-group tight snack_">
                            <label>Jumlah Orang <small>(snack)</small></label><br>
                            <input type="text" name="jumlah_orang_snack" id="jumlah-orang-snack" class="form-control reset-form">
                            <em class="help-block error invalid-feedback"></em>
                        </div>
                        <!-- <div class="form-group tight">
                            <label>Snack</label><br>
                            <input type="text" name="snack" id="snack" class="select2-input reset-form">
                            <em class="help-block error invalid-feedback"></em>
                        </div> -->
                        <div class="form-group tight">
                            <label>Keterangan <small>(Optional)</small></label>
                            <textarea name="keterangan" id="keterangan" rows="3" class="form-control reset-form"></textarea>
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
                            <?php foreach($persetujuan as $key => $row): ?>
                                <?php if($row->id_users === $this->session->userdata('id')): ?>
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
                                    <div class="form-group">
                                        <?php if($row->label !== null): ?>
                                        <label>Status Persetujuan <?= $row->label ?></label><br>    
                                        <?php else: ?>
                                        <label>Status Persetujuan <?= $row->divisi ?></label><br>
                                        <?php endif ?>
                                        <select name="status_persetujuan[]" class="form-control" id="status-persetujuan-<?= $key ?>">
                                            <option value="Disetujui">Disetujui</option>
                                            <option value="Ditolak">Ditolak</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <?php if($row->label !== null): ?>
                                        <label>Keterangan <?= $row->label ?></label><br>    
                                        <?php else: ?>
                                        <label>Keterangan <?= $row->divisi ?></label><br>
                                        <?php endif ?>
                                        <textarea name="keterangan_persetujuan[]" id="keterangan-persetujuan-<?= $key ?>" rows="3" class="form-control"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label>Tanda Tangan</label>
                                        <div class="jq-signature" id="signature-<?= $key ?>" data-input="#signature-input-<?= $key ?>"></div>
                                        <button type="button" id="btn-hapus-signature" class="btn btn-outline-success btn-block" onclick="hapusSignature(<?= $key ?>)"><i class="fas fa-trash mr-2"></i>Hapus</button>
                                        <img src="" id="signature-img">
                                        <input type="hidden" name="signature[]" id="signature-input-<?= $key ?>" value="">
                                    </div>
                                <?php endif ?>
                            <?php endforeach ?>
                            <div class="alert alert-secondary" role="alert">
                                <small><i class="fas fa-info-circle mr-2 text-primary"></i>Dokumen ini membutuhkan persetujuan <b>Atasan</b> yang dipilih.</small>
                            </div> 
                        <?php endif ?>
                    </div>
                </div>
                <?= form_close() ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-dismiss="modal"><i class="fas fa-times-circle mr-2"></i>Keluar</button>
                <button type="button" class="btn btn-primary" id="btn-simpan" onclick="konfirmasi_simpan()"><i class="fas fa-save mr-2"></i>Simpan</button>
            </div>
        </div>
    </div>
</div>