<!-- Modal -->
<div class="modal fade" id="modal" role="dialog" data-backdrop="static" aria-labelledby="modal-label" aria-hidden="true">
    <div class="modal-dialog" style="min-width: 60%" role="document">
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
                    <div class="col-lg-12">
                        <h6><b>INFROMASI DASAR</b></h6>
                        <hr>
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

<!-- Modal Input KM -->
<div class="modal fade" id="modal-km-awal" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="modal-label" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-km-awal-label"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?= form_open('', 'class="form-horizontal" id="form-km-awal"') ?>
                <input type="hidden" name="id" id="id-booking-km-awal">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label>KM Awal Kendaraan</label>
                            <input type="text" class="form-control reset-form" name="km_awal" id="km-awal">
                            <em class="help-block error invalid-feedback"></em>
                        </div>
                    </div>
                </div>
               
                <?= form_close() ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-dismiss="modal"><i class="fas fa-times-circle mr-2"></i>Keluar</button>
                <button type="button" class="btn btn-primary" id="btn-simpan" onclick="konfirmasi_simpan_km_awal()"><i class="fas fa-save mr-2"></i>Simpan</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Input KM -->
<div class="modal fade" id="modal-km-akhir" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="modal-label" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-km-akhir-label"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?= form_open('', 'class="form-horizontal" id="form-km-akhir"') ?>
                <input type="hidden" name="id" id="id-booking-km-akhir">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label>KM Akhir Kendaraan</label>
                            <input type="text" class="form-control reset-form" name="km_akhir" id="km-akhir">
                            <em class="help-block error invalid-feedback"></em>
                        </div>
                    </div>
                </div>
               
                <?= form_close() ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-dismiss="modal"><i class="fas fa-times-circle mr-2"></i>Keluar</button>
                <button type="button" class="btn btn-primary" id="btn-simpan" onclick="konfirmasi_simpan_km_akhir()"><i class="fas fa-save mr-2"></i>Simpan</button>
            </div>
        </div>
    </div>
</div>