<!-- Modal Form-->
<div class="modal fade" id="modal-form" data-backdrop="static" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-form-label"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?= form_open('', 'id=form-buku-tamu') ?>
                <input type="hidden" name="id" id="id">
                <div class="form-group">
                    <label>Nama Lengkap</label>
                    <input type="text" class="form-control validasi-input" name="nama" id="nama">
                    <em class="help-block error invalid-feedback"></em>
                </div>
                <div class="form-group">
                    <label>PT / Unit / Bagian (optional)</label>
                    <input type="text" class="form-control validasi-input" name="unit" id="unit">
                    <em class="help-block error invalid-feedback"></em>
                </div>
                <div class="form-group">
                    <label>No. Identitas (optional)</label>
                    <input type="text" class="form-control validasi-input" name="no_identitas" id="no-identitas">
                    <em class="help-block error invalid-feedback"></em>
                </div>
                <div class="form-group">
                    <label>Nopol. Kendaraan (optional)</label>
                    <input type="text" class="form-control validasi-input" name="no_polisi" id="no-polisi">
                    <em class="help-block error invalid-feedback"></em>
                </div>
                <div class="form-group">
                    <label>Bertemu Dengan</label>
                    <select name="atasan" id="atasan" class="form-control select2 validasi-input">
                        <option value="">- Pilih -</option>
                        <?php foreach($atasan as $key => $value): ?>
                        <optgroup label="<?= $key ?>">
                            <?php foreach($value as $index => $element): ?>
                            <option value="<?= $element['id'] ?>"><?= $element['nama'] ?></option>
                            <?php endforeach ?>
                        </optgroup>
                        <?php endforeach ?>
                    </select>
                    <em class="help-block error invalid-feedback"></em>
                </div>
                <div class="form-group">
                    <label>Keperluan</label>
                    <textarea name="keperluan" id="keperluan" rows="4" class="form-control validasi-input"></textarea>
                    <em class="help-block error invalid-feedback"></em>
                </div>
                <div class="form-group">
                    <label>Petugas (Masuk)</label>
                    <select name="petugas" id="petugas" class="form-control select2 validasi-input">
                        <option value="">- Pilih -</option>
                        <?php foreach($petugas as $key => $value): ?>
                        <optgroup label="<?= $key ?>">
                            <?php foreach($value as $index => $element): ?>
                            <option value="<?= $element['id'] ?>"><?= $element['nama'] ?></option>
                            <?php endforeach ?>
                        </optgroup>
                        <?php endforeach ?>
                    </select>
                    <em class="help-block error invalid-feedback"></em>
                </div>
                <?= form_close() ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <i class="fas fa-window-close mr-2"></i>Keluar
                </button>
                <button type="button" onclick="konfirmasi_simpan()" class="btn btn-primary">
                    <i class="fas fa-save mr-2"></i>Simpan
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Detail-->
<div class="modal fade" id="modal-status-keluar" data-backdrop="static" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-status-keluar-label"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?= form_open('', 'id=form-status-keluar') ?>
                <input type="hidden" name="id" id="id-detail">
                <div class="form-group">
                    <label>Nama Lengkap</label>
                    <input type="text" class="form-control validasi-input" name="nama" id="nama-detail" disabled>
                    <em class="help-block error invalid-feedback"></em>
                </div>
                <div class="form-group">
                    <label>PT / Unit / Bagian (optional)</label>
                    <input type="text" class="form-control validasi-input" name="unit" id="unit-detail" disabled>
                    <em class="help-block error invalid-feedback"></em>
                </div>
                <div class="form-group">
                    <label>Petugas (Keluar)</label>
                    <select name="petugas" id="petugas-detail" class="form-control select2 validasi-input">
                        <option value="">- Pilih -</option>
                        <?php foreach($petugas as $key => $value): ?>
                        <optgroup label="<?= $key ?>">
                            <?php foreach($value as $index => $element): ?>
                            <option value="<?= $element['id'] ?>"><?= $element['nama'] ?></option>
                            <?php endforeach ?>
                        </optgroup>
                        <?php endforeach ?>
                    </select>
                    <em class="help-block error invalid-feedback"></em>
                </div>
                <?= form_close() ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <i class="fas fa-times-circle mr-2"></i>Keluar
                </button>
                <button type="button" onclick="simpan_status_keluar()" class="btn btn-primary">
                    <i class="fas fa-save mr-2"></i>Simpan
                </button>
            </div>
        </div>
    </div>
</div>

