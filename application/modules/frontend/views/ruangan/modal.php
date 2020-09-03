<!-- Modal -->
<div class="modal fade" id="modal" role="dialog" data-backdrop="static" aria-labelledby="modal-label"
    aria-hidden="true">
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
                <input type="hidden" name="no_dokumen" id="no_dokumen"
                    value="FM-SMK3-BLD-<?= sprintf("%04s", $no_dokumen) ?>">
                <div class="row">
                    <div class="col-lg-12">
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
                            <textarea name="jumlah_orang" id="jumlah-orang" rows="3"
                                class="form-control reset-form"></textarea>
                            <em class="help-block error invalid-feedback"></em>
                        </div>
                        <div class="form-group tight">
                            <label>Makan Siang</label><br>
                            <?= form_dropdown('makan_siang', array('Tidak' => 'Tidak', 'Ada' => 'Ada'), array(), 'id=makan-siang class="form-control select2 reset-form"') ?>
                            <em class="help-block error invalid-feedback"></em>
                        </div>
                        <div class="form-group tight makan-siang_">
                            <label>Jumlah Orang <small>(makan siang)</small></label><br>
                            <input type="text" name="jumlah_orang_makan_siang" id="jumlah-orang-makan-siang" class="form-control reset-form">
                            <em class="help-block error invalid-feedback"></em>
                        </div>
                        <div class="form-group tight">
                            <label>Snack</label><br>
                            <?= form_dropdown('snack', array('Tidak' => 'Tidak', 'Ada' => 'Ada'), array(), 'id=snack class="form-control select2 reset-form"') ?>
                            <em class="help-block error invalid-feedback"></em>
                        </div>
                        <div class="form-group tight snack_">
                            <label>Jumlah Orang <small>(snack)</small></label><br>
                            <input type="text" name="jumlah_orang_snack" id="jumlah-orang-snack" class="form-control reset-form">
                            <em class="help-block error invalid-feedback"></em>
                        </div>
                        <div class="form-group tight">
                            <label>Keterangan <small>(Optional)</small></label>
                            <textarea name="keterangan" id="keterangan" rows="3"
                                class="form-control reset-form"></textarea>
                            <em class="help-block error invalid-feedback"></em>
                        </div>
                        <div class="form-group">
                            <label>Tanggal Peminjaman</label>
                            <div class="row">
                                <div class="col-lg-5">
                                    <input type="text" class="form-control" name="tgl_start" id="tgl-start"
                                        value="<?= date('d/m/Y H:i') ?>">
                                </div>
                                <div class="col-lg-1">
                                    <h6 class="mt-2">S/D</h6>
                                </div>
                                <div class="col-lg-5">
                                    <input type="text" class="form-control" name="tgl_end" id="tgl-end"
                                        value="<?= date('d/m/Y H:i') ?>">
                                    <em class="help-block error invalid-feedback"></em>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Diajukan Oleh</label>
                            <select name="users" id="users" class="form-control select2 reset-form">
                                <option value="">- Pilih -</option>
                                <?php foreach($diajukan_oleh as $key => $value): ?>
                                <optgroup label="<?= $key ?>">
                                    <?php foreach($value as $index => $element): ?>
                                    <option value="<?= $element['id'] ?>"><?= $element['nama'] ?></option>
                                    <?php endforeach ?>
                                </optgroup>
                                <?php endforeach ?>
                            </select>
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
                            <input type="text" class="form-control" value="<?= $row->divisi ?> - <?= $row->users ?>"
                                readonly>
                            <input type="hidden" class="form-control" name="atasan[]" value="<?= $row->id_users ?>">
                            <em class="help-block error invalid-feedback"></em>
                        </div>
                        <?php endforeach ?>
                        <div class="alert alert-secondary" role="alert">
                            <small>
                                <i class="fas fa-info-circle mr-2 text-primary"></i>
                                Dokumen ini membutuhkan persetujuan <b>Atasan</b> yang dipilih.
                            </small>
                        </div>
                        <?php endif ?>
                    </div>
                </div>
                <?= form_close() ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-dismiss="modal">
                    <i class="fas fa-times-circle mr-2"></i>Keluar
                </button>
                <button type="button" class="btn btn-primary" id="btn-simpan" onclick="konfirmasi_simpan()">
                    <i class="fas fa-save mr-2"></i>Simpan
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Daftar Hadir -->
<div class="modal fade" id="modal-attendances" role="dialog" data-backdrop="static" aria-labelledby="modal-label"
    aria-hidden="true">
    <div class="modal-dialog" style="min-width: 90%" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-attendances-label"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="id" id="id_">
                <input type="hidden" name="status_dokumen" id="status-dokumen_">
                <input type="hidden" name="tgl_start_absen" id="tgl-start-absen">
                <input type="hidden" name="tgl_end_absen" id="tgl-end-absen">
                <h5><b>Informasi Kegiatan</b></h5>
                <div class="row">
                    <div class="col-lg-4 mb-3">
                        <div class="card border-primary">
                            <div class="card-body">
                                <h4 class="card-title text-primary">PIC</h4>
                                <p class="card-text" id="pic"></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 mb-3">
                        <div class="card border-primary">
                            <div class="card-body">
                                <h4 class="card-title text-primary">Nama Ruangan</h4>
                                <p class="card-text" id="nama-ruangan"></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 mb-3">
                        <div class="card border-primary">
                            <div class="card-body">
                                <h4 class="card-title text-primary">Nama Kegiatan</h4>
                                <p class="card-text" id="kegiatan"></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4 mb-3">
                        <div class="card border-primary">
                            <div class="card-body">
                                <h4 class="card-title text-primary">No. Dokumen</h4>
                                <p class="card-text" id="no-dokumen"></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 mb-3">
                        <div class="card border-primary">
                            <div class="card-body">
                                <h4 class="card-title text-primary">Tgl Pemakaian</h4>
                                <p class="card-text" id="tgl-pemakaian"></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 mb-3">
                        <div class="card border-primary">
                            <div class="card-body">
                                <h4 class="card-title text-primary">Status Kegiatan</h4>
                                <p class="card-text" id="status-kegiatan"></p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-4 col-lg-3 mt-2 btn-qrcode">
                        <button type="button" id="btn-generate-qrcode" class="btn btn-primary btn-block">
                            <i class="fas fa-sync-alt mr-2"></i>Generate QRCode
                        </button>
                    </div>
                    <div class="col-md-4 col-lg-3 mt-2 btn-checkout">
                        <button type="button" id="btn-ubah-status" class="btn btn-danger btn-block">
                            <i class="fas fa-times-circle mr-2"></i>Selesai
                        </button>
                    </div>
                    <div class="col-md-4 col-lg-3 mt-2">
                        <button type="button" id="btn-download" class="btn btn-secondary btn-block">
                            <i class="fas fa-download mr-2"></i>Download Data Peserta
                        </button>
                    </div>
                </div>

                <div id="qrcode" class="d-flex justify-content-center mt-3"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-dismiss="modal">
                    <i class="fas fa-times-circle mr-2"></i>Keluar
                </button>
            </div>
        </div>
    </div>
</div>